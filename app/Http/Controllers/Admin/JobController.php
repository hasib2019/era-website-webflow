<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobOpening;

class JobController extends ResourceController
{
    protected function model(): string
    {
        return JobOpening::class;
    }

    protected function key(): string
    {
        return 'jobs';
    }

    protected function labels(): array
    {
        return ['singular' => 'Job opening', 'plural' => 'Job openings'];
    }

    protected function columns(): array
    {
        return ['title', 'location', 'employment_type', 'is_published'];
    }

    protected function fields(): array
    {
        return [
            'title' => ['label' => 'Job title', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'department' => ['label' => 'Department', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'location' => ['label' => 'Location', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'employment_type' => ['label' => 'Employment type', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'experience' => ['label' => 'Experience', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'salary_range' => ['label' => 'Salary range', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'summary' => ['label' => 'Summary', 'type' => 'textarea', 'rules' => 'nullable|string'],
            'description' => ['label' => 'Description', 'type' => 'richtext', 'rules' => 'nullable|string'],
            'responsibilities' => ['label' => 'Responsibilities', 'type' => 'richtext', 'rules' => 'nullable|string'],
            'requirements' => ['label' => 'Requirements', 'type' => 'richtext', 'rules' => 'nullable|string'],
            'benefits' => ['label' => 'Benefits', 'type' => 'richtext', 'rules' => 'nullable|string'],
            'closes_on' => ['label' => 'Closes on', 'type' => 'date', 'rules' => 'nullable|date'],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
