<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;

class ServiceController extends ResourceController
{
    protected function model(): string
    {
        return Service::class;
    }

    protected function key(): string
    {
        return 'services';
    }

    protected function labels(): array
    {
        return ['singular' => 'Service', 'plural' => 'Services'];
    }

    protected function columns(): array
    {
        return ['counter', 'title', 'is_published', 'sort_order'];
    }

    protected function fields(): array
    {
        return [
            'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'counter' => ['label' => 'Counter', 'type' => 'text', 'rules' => 'nullable|string|max:10', 'help' => 'The two-digit number shown beside the row, e.g. 01.'],
            'excerpt' => ['label' => 'Excerpt', 'type' => 'textarea', 'rules' => 'nullable|string'],
            'image_id' => ['label' => 'Listing image', 'type' => 'media', 'rules' => 'nullable|exists:media,id'],
            'image_alt' => ['label' => 'Image alt text', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'hero_heading' => ['label' => 'Detail page heading', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'hero_intro' => ['label' => 'Detail page intro', 'type' => 'textarea', 'rules' => 'nullable|string'],
            'hero_image_id' => ['label' => 'Detail page image', 'type' => 'media', 'rules' => 'nullable|exists:media,id'],
            'body' => ['label' => 'Body', 'type' => 'richtext', 'rules' => 'nullable|string'],
            'meta_title' => ['label' => 'Meta title', 'type' => 'text', 'rules' => 'nullable|string|max:255', 'group' => 'SEO'],
            'meta_description' => ['label' => 'Meta description', 'type' => 'textarea', 'rules' => 'nullable|string', 'group' => 'SEO'],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
