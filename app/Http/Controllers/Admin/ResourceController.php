<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Support\ActivityLogger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Shared CRUD for the content collections.
 *
 * A subclass declares its model, labels and a field spec; the index table, the
 * create/edit form, validation and the activity trail all follow from that, so
 * the collections behave the same way without ten near-identical controllers.
 */
abstract class ResourceController extends Controller
{
    /** @return class-string<Model> */
    abstract protected function model(): string;

    /** Route/view segment, e.g. "services". */
    abstract protected function key(): string;

    /** ['singular' => 'Service', 'plural' => 'Services'] */
    abstract protected function labels(): array;

    /**
     * field => [label, type, rules, help, options, ...]
     * Types: text, textarea, richtext, number, select, checkbox, media, date, slug.
     */
    abstract protected function fields(): array;

    /** Columns shown in the index table (field keys). */
    protected function columns(): array
    {
        return array_slice(array_keys($this->fields()), 0, 3);
    }

    /** Field whose value seeds the slug, when the model has one. */
    protected function slugSource(): ?string
    {
        return 'title';
    }

    protected function searchable(): array
    {
        return ['title', 'name'];
    }

    protected function baseQuery(): Builder
    {
        $model = $this->model();

        return $model::query();
    }

    protected function defaultOrder(Builder $query): Builder
    {
        $model = new ($this->model());

        return in_array('sort_order', $model->getFillable(), true)
            ? $query->orderBy('sort_order')->orderBy('id')
            : $query->latest('id');
    }

    public function index(Request $request)
    {
        $query = $this->defaultOrder($this->baseQuery());

        if ($term = trim((string) $request->get('q'))) {
            $columns = array_intersect($this->searchable(), (new ($this->model()))->getFillable());
            $query->where(function (Builder $q) use ($columns, $term) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$term}%");
                }
            });
        }

        return view('admin.resource.index', $this->viewData([
            'records' => $query->paginate(20)->withQueryString(),
            'columns' => $this->columns(),
        ]));
    }

    public function create()
    {
        $model = $this->model();

        return view('admin.resource.form', $this->viewData([
            'record' => new $model(),
            'mediaOptions' => $this->mediaOptions(),
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $record = $this->model()::create($this->prepare($data, $request));

        ActivityLogger::log('created', $record);

        return redirect()
            ->route("admin.{$this->key()}.index")
            ->with('success', $this->labels()['singular'] . ' created.');
    }

    public function edit(int $id)
    {
        return view('admin.resource.form', $this->viewData([
            'record' => $this->baseQuery()->findOrFail($id),
            'mediaOptions' => $this->mediaOptions(),
        ]));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $record = $this->baseQuery()->findOrFail($id);
        $data = $this->validated($request, $record);

        $record->update($this->prepare($data, $request, $record));

        ActivityLogger::log('updated', $record, null, ActivityLogger::diff($record));

        return redirect()
            ->route("admin.{$this->key()}.index")
            ->with('success', $this->labels()['singular'] . ' updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $record = $this->baseQuery()->findOrFail($id);
        ActivityLogger::log('deleted', $record);
        $record->delete();

        return redirect()
            ->route("admin.{$this->key()}.index")
            ->with('success', $this->labels()['singular'] . ' deleted.');
    }

    /** Persist the order the index page was dragged into. */
    public function reorder(Request $request): RedirectResponse
    {
        $order = $request->validate(['order' => ['required', 'array']])['order'];

        foreach (array_values($order) as $position => $id) {
            $this->model()::whereKey($id)->update(['sort_order' => $position]);
        }

        return back()->with('success', 'Order saved.');
    }

    protected function validated(Request $request, ?Model $record = null): array
    {
        $rules = [];

        foreach ($this->fields() as $name => $spec) {
            $rule = $spec['rules'] ?? 'nullable';
            if (is_string($rule) && str_contains($rule, '{id}')) {
                $rule = str_replace('{id}', (string) ($record?->getKey() ?? 'NULL'), $rule);
            }
            $rules[$name] = $rule;
        }

        return $request->validate($rules);
    }

    /**
     * Normalises values just before they hit the model.
     *
     * The one thing to get right here is a blank input. ConvertEmptyStringsToNull
     * has already turned every untouched box into null by the time this runs, and
     * columns like `sort_order`, `read_time`, `scope` and `row_group` are NOT NULL
     * with a database default -- writing an explicit null overrides the default and
     * the insert dies on a 1048. Leaving "Order" empty is the normal way to create a
     * record, so that took out create on every collection.
     *
     * A blank value therefore only becomes null when the column actually accepts
     * one. Otherwise the key is dropped: a create then takes the column default,
     * and an update leaves the stored value alone.
     */
    protected function prepare(array $data, Request $request, ?Model $record = null): array
    {
        $nullable = $this->nullableColumns();

        foreach ($this->fields() as $name => $spec) {
            if (($spec['type'] ?? 'text') === 'checkbox') {
                $data[$name] = $request->boolean($name);
                continue;
            }

            if (! array_key_exists($name, $data) || ($data[$name] !== '' && $data[$name] !== null)) {
                continue;
            }

            if (in_array($name, $nullable, true) && ($spec['nullable'] ?? true)) {
                $data[$name] = null;
            } else {
                unset($data[$name]);
            }
        }

        $model = new ($this->model());
        $source = $this->slugSource();

        if (in_array('slug', $model->getFillable(), true) && $source && ! empty($data[$source])) {
            $slug = Str::slug($data['slug'] ?? '' ?: $data[$source]);
            $data['slug'] = $this->uniqueSlug($slug, $record);
        }

        return $data;
    }

    private function uniqueSlug(string $slug, ?Model $record): string
    {
        $base = $slug ?: 'item';
        $candidate = $base;
        $n = 2;

        while ($this->model()::where('slug', $candidate)
            ->when($record, fn ($q) => $q->whereKeyNot($record->getKey()))
            ->exists()) {
            $candidate = $base . '-' . $n++;
        }

        return $candidate;
    }

    /**
     * Column names on this model's table that accept null.
     *
     * Read from the schema rather than declared per field, so a migration that
     * relaxes or tightens a column cannot drift out of sync with the forms.
     */
    protected function nullableColumns(): array
    {
        static $cache = [];

        $table = (new ($this->model()))->getTable();

        return $cache[$table] ??= array_keys(array_filter(
            array_column(Schema::getColumns($table), 'nullable', 'name'),
        ));
    }

    protected function mediaOptions()
    {
        return Media::orderBy('folder')->orderBy('original_name')->get();
    }

    protected function viewData(array $extra = []): array
    {
        return array_merge([
            'key' => $this->key(),
            'labels' => $this->labels(),
            'fields' => $this->fields(),
        ], $extra);
    }
}
