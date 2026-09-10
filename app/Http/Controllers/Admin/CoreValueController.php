<?php

namespace App\Http\Controllers\Admin;

use App\Models\CoreValue;

/**
 * The numbered circles in the "core values" band of the about page.
 *
 * The design draws them as a row of overlapping circles sized at 20% each, so
 * five rows fill the band exactly; more than five wrap onto a second row.
 */
class CoreValueController extends ResourceController
{
    protected function model(): string
    {
        return CoreValue::class;
    }

    protected function key(): string
    {
        return 'core-values';
    }

    protected function labels(): array
    {
        return ['singular' => 'Core value', 'plural' => 'Core values'];
    }

    protected function columns(): array
    {
        return ['number', 'title', 'is_published', 'sort_order'];
    }

    protected function slugSource(): ?string
    {
        return null;
    }

    protected function searchable(): array
    {
        return ['title', 'description'];
    }

    protected function fields(): array
    {
        return [
            'number' => [
                'label' => 'Number',
                'type' => 'text',
                'rules' => 'nullable|string|max:10',
                'help' => 'Shown in the small circle badge. Text, so "01" keeps its leading zero.',
            ],
            'title' => [
                'label' => 'Value',
                'type' => 'text',
                'rules' => 'required|string|max:255',
                'help' => 'Kept short — the design sets it in caps inside a circle, e.g. "Integrity".',
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'textarea',
                'rules' => 'nullable|string',
                'help' => 'One short line under the value. Leave empty to show the value alone.',
            ],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0', 'help' => 'Low to high, left to right.'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
