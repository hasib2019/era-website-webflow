<?php

namespace App\Http\Controllers\Admin;

use App\Models\CaseStudy;

class CaseStudyController extends ResourceController
{
    protected function model(): string
    {
        return CaseStudy::class;
    }

    protected function key(): string
    {
        return 'case-studies';
    }

    protected function labels(): array
    {
        return ['singular' => 'Case study', 'plural' => 'Case studies'];
    }

    protected function columns(): array
    {
        return ['title', 'subtitle', 'client', 'is_published'];
    }

    protected function fields(): array
    {
        return [
            'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'image_id' => ['label' => 'Cover image', 'type' => 'media', 'rules' => 'nullable|exists:media,id'],
            'image_alt' => ['label' => 'Image alt text', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'client' => ['label' => 'Client', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'category' => ['label' => 'Category', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'duration' => ['label' => 'Duration', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'website_url' => ['label' => 'Website', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'overview' => ['label' => 'Overview', 'type' => 'richtext', 'rules' => 'nullable|string'],
            'objective' => ['label' => 'Objective', 'type' => 'richtext', 'rules' => 'nullable|string'],
            'result_summary' => ['label' => 'Result summary', 'type' => 'richtext', 'rules' => 'nullable|string'],
            'meta_title' => ['label' => 'Meta title', 'type' => 'text', 'rules' => 'nullable|string|max:255', 'group' => 'SEO'],
            'meta_description' => ['label' => 'Meta description', 'type' => 'textarea', 'rules' => 'nullable|string', 'group' => 'SEO'],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
