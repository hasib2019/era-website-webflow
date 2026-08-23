<?php

namespace App\Http\Controllers\Admin;

use App\Models\TeamMember;

class TeamController extends ResourceController
{
    protected function model(): string
    {
        return TeamMember::class;
    }

    protected function key(): string
    {
        return 'team';
    }

    protected function labels(): array
    {
        return ['singular' => 'Team member', 'plural' => 'Team'];
    }

    protected function columns(): array
    {
        return ['name', 'designation', 'is_published', 'sort_order'];
    }

    protected function slugSource(): ?string
    {
        return null;
    }

    protected function searchable(): array
    {
        return ['name', 'designation'];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Name', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'designation' => ['label' => 'Designation', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'bio' => ['label' => 'Short bio', 'type' => 'textarea', 'rules' => 'nullable|string'],
            'image_id' => ['label' => 'Photo', 'type' => 'media', 'rules' => 'nullable|exists:media,id'],
            'image_alt' => ['label' => 'Photo alt text', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'facebook_url' => ['label' => 'Facebook', 'type' => 'text', 'rules' => 'nullable|string|max:255', 'group' => 'Social'],
            'twitter_url' => ['label' => 'Twitter / X', 'type' => 'text', 'rules' => 'nullable|string|max:255', 'group' => 'Social'],
            'instagram_url' => ['label' => 'Instagram', 'type' => 'text', 'rules' => 'nullable|string|max:255', 'group' => 'Social'],
            'linkedin_url' => ['label' => 'LinkedIn', 'type' => 'text', 'rules' => 'nullable|string|max:255', 'group' => 'Social'],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
