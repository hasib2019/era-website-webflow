<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProcessStep;
use Illuminate\Database\Eloquent\Builder;

/**
 * The numbered process strip ("01 Analyze", "02 Execution", ...) on three
 * pages. `scope` is which page a row belongs to, so one screen serves all
 * three; arriving from the page editor narrows it with ?scope=home.
 */
class ProcessStepController extends ResourceController
{
    /** scope => label, in page order. */
    public const SCOPES = [
        'home' => 'Home page',
        'service' => 'Services page',
        'why-choose-us' => 'Why choose us page',
    ];

    protected function model(): string
    {
        return ProcessStep::class;
    }

    protected function key(): string
    {
        return 'process-steps';
    }

    protected function labels(): array
    {
        return ['singular' => 'Process step', 'plural' => 'Process steps'];
    }

    protected function columns(): array
    {
        return ['title', 'number', 'scope', 'sort_order'];
    }

    protected function slugSource(): ?string
    {
        return null;
    }

    protected function searchable(): array
    {
        return ['title', 'description'];
    }

    /**
     * Restricted to the three pages this screen actually manages.
     *
     * The table also carries six `service-details` rows the export left
     * behind: that page's feature list is static markup, not a loop over this
     * scope, so nothing reads them and their `title` never made it out of
     * extraction cleanly either. Surfacing them here would let an edit
     * silently reassign one to a real scope -- the select only offers the
     * three below, so whichever renders first would win on save.
     */
    protected function baseQuery(): Builder
    {
        $scope = request('scope');

        return ProcessStep::query()
            ->whereIn('scope', array_keys(self::SCOPES))
            ->when(
                is_string($scope) && array_key_exists($scope, self::SCOPES),
                fn (Builder $query) => $query->where('scope', $scope),
            );
    }

    /** Group the three pages together rather than interleaving them by sort_order. */
    protected function defaultOrder(Builder $query): Builder
    {
        return $query->orderBy('scope')->orderBy('sort_order')->orderBy('id');
    }

    protected function fields(): array
    {
        return [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'help' => 'E.g. "Analyze", "Execution", "Growth & Scale".',
            ],
            'number' => [
                'label' => 'Number',
                'type' => 'text',
                'rules' => 'nullable|string|max:10',
                'help' => 'The step number shown next to the title, e.g. "01".',
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => 'nullable|string',
                'help' => 'Stored for this step, but the current design does not display it on the page.',
            ],
            'scope' => [
                'label' => 'Shown on',
                'type' => 'select',
                'rules' => 'required|in:' . implode(',', array_keys(self::SCOPES)),
                'options' => self::SCOPES,
            ],
            'sort_order' => [
                'label' => 'Order',
                'type' => 'number',
                'rules' => 'nullable|integer|min:0',
                'help' => 'Low to high, left to right within the page.',
            ],
        ];
    }
}
