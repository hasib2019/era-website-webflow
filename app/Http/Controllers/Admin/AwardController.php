<?php

namespace App\Http\Controllers\Admin;

use App\Models\Award;

/**
 * The "awards & achievements" list on the about page.
 *
 * Rendered with the same row design as the job openings list: the title on the
 * left, the year and awarding body on the right.
 */
class AwardController extends ResourceController
{
    protected function model(): string
    {
        return Award::class;
    }

    protected function key(): string
    {
        return 'awards';
    }

    protected function labels(): array
    {
        return ['singular' => 'Award', 'plural' => 'Awards'];
    }

    protected function columns(): array
    {
        return ['title', 'year', 'is_published', 'sort_order'];
    }

    protected function slugSource(): ?string
    {
        return null;
    }

    protected function searchable(): array
    {
        return ['title', 'awarded_by'];
    }

    protected function fields(): array
    {
        return [
            'title' => [
                'label' => 'Award',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'help' => 'e.g. "National ICT Award".',
            ],
            'year' => [
                'label' => 'Year',
                'type' => 'text',
                'rules' => 'nullable|string|max:20',
                'help' => 'Shown on the right of the row. Leave empty to omit it.',
            ],
            'awarded_by' => [
                'label' => 'Awarded by',
                'type' => 'text',
                'rules' => 'nullable|string|max:255',
                'help' => 'Optional second line on the right, e.g. the awarding body.',
            ],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0', 'help' => 'Low to high, top to bottom.'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
