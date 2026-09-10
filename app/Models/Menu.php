<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'description'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    /**
     * How this menu groups its items: none, fixed or free.
     *
     * @see config/menus.php, which explains why the mega menu's set is closed
     *      and the footer's is not.
     */
    public function columnMode(): string
    {
        return config('menus.' . $this->slug . '.mode', 'free');
    }

    /** Headings to offer in the editor, in the order the site renders them. */
    public function columnOptions(): array
    {
        if ($this->columnMode() === 'none') {
            return [];
        }

        if ($this->columnMode() === 'fixed') {
            return config('menus.' . $this->slug . '.columns', []);
        }

        // free: whatever the items already use, so the editor mirrors the site
        return $this->items()
            ->whereNotNull('column_heading')
            ->distinct()
            ->orderBy('column_heading')
            ->pluck('column_heading')
            ->all();
    }

    public function help(): ?string
    {
        return config('menus.' . $this->slug . '.help');
    }

    /** Whether an item in this menu may open a panel instead of navigating. */
    public function supportsDropdowns(): bool
    {
        return (bool) config('menus.' . $this->slug . '.dropdowns', false);
    }

    /**
     * The drag board: one bucket per drop target, in the order they are drawn.
     *
     * A bucket is [title, parent, column, items]. `parent` and `column` are what
     * the drag handler posts back, so dropping a card into a bucket is what sets
     * both its position and where it belongs — there is no second step.
     *
     * Menus without dropdowns keep their old shape exactly: one bucket for a
     * flat menu, one per column otherwise. A menu with dropdowns gets the top
     * row first, then each dropdown's columns beneath it.
     *
     * Free-column buckets are followed by an empty one, so a new column is made
     * by dragging a link into it rather than by knowing to type a new heading.
     */
    public function board(): array
    {
        $items = $this->items()->orderBy('sort_order')->orderBy('id')->get();
        $mode = $this->columnMode();

        if (! $this->supportsDropdowns()) {
            if ($mode === 'none') {
                return [['title' => 'All links', 'parent' => '', 'column' => '', 'items' => $items]];
            }

            $buckets = [];
            foreach ($this->columnOptions() as $heading) {
                $buckets[] = [
                    'title' => $heading,
                    'parent' => '',
                    'column' => $heading,
                    'items' => $items->filter(fn (MenuItem $i) => (string) $i->column_heading === $heading),
                ];
            }

            if ($mode === 'free') {
                $buckets[] = $this->emptyColumnBucket('', $this->columnOptions());
            }

            return $buckets;
        }

        $top = $items->whereNull('parent_id');

        $buckets = [['title' => 'Top row', 'parent' => '', 'column' => '', 'items' => $top]];

        foreach ($top as $item) {
            if (! $item->isDropdown()) {
                continue;
            }

            $children = $items->where('parent_id', $item->id);
            $headings = $children->pluck('column_heading')
                ->map(fn ($h) => (string) ($h ?: 'Column 1'))
                ->unique()
                ->values()
                ->all();

            foreach ($headings as $heading) {
                $buckets[] = [
                    'title' => $item->label . ' → ' . $heading,
                    'parent' => (string) $item->id,
                    'column' => $heading,
                    'items' => $children->filter(
                        fn (MenuItem $c) => (string) ($c->column_heading ?: 'Column 1') === $heading,
                    ),
                ];
            }

            $buckets[] = $this->emptyColumnBucket((string) $item->id, $headings, $item->label . ' → ');
        }

        return $buckets;
    }

    /** A drop target for a column that does not exist yet. */
    private function emptyColumnBucket(string $parent, array $existing, string $prefix = ''): array
    {
        $n = 1;
        while (in_array('Column ' . $n, $existing, true)) {
            $n++;
        }

        return [
            'title' => $prefix . 'Column ' . $n,
            'parent' => $parent,
            'column' => 'Column ' . $n,
            'items' => collect(),
            'new' => true,
        ];
    }

    /** Active top-level items with their children, ready to render. */
    public function tree(): Collection
    {
        return $this->items()
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->get();
    }
}
