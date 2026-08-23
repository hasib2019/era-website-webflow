<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChangelogEntry;

class ChangelogController extends ResourceController
{
    protected function model(): string
    {
        return ChangelogEntry::class;
    }

    protected function key(): string
    {
        return 'changelog';
    }

    protected function labels(): array
    {
        return ['singular' => 'Changelog entry', 'plural' => 'Changelog'];
    }

    protected function columns(): array
    {
        return ['version', 'title', 'released_on', 'is_published'];
    }

    protected function slugSource(): ?string
    {
        return null;
    }

    protected function searchable(): array
    {
        return ['title', 'version'];
    }

    protected function fields(): array
    {
        return [
            'version' => ['label' => 'Version', 'type' => 'text', 'rules' => 'nullable|string|max:40'],
            'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'body' => ['label' => 'Details', 'type' => 'richtext', 'rules' => 'nullable|string'],
            'released_on' => ['label' => 'Released on', 'type' => 'date', 'rules' => 'nullable|date'],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
