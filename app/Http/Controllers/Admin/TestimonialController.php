<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;

class TestimonialController extends ResourceController
{
    protected function model(): string
    {
        return Testimonial::class;
    }

    protected function key(): string
    {
        return 'testimonials';
    }

    protected function labels(): array
    {
        return ['singular' => 'Testimonial', 'plural' => 'Testimonials'];
    }

    protected function columns(): array
    {
        return ['author', 'role', 'company', 'is_published'];
    }

    protected function slugSource(): ?string
    {
        return null;
    }

    protected function searchable(): array
    {
        return ['author', 'company', 'quote'];
    }

    protected function fields(): array
    {
        return [
            'author' => ['label' => 'Author', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'role' => ['label' => 'Role', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'company' => ['label' => 'Company', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'quote' => ['label' => 'Quote', 'type' => 'textarea', 'rules' => 'required|string'],
            'image_id' => ['label' => 'Photo', 'type' => 'media', 'rules' => 'nullable|exists:media,id'],
            'image_alt' => ['label' => 'Photo alt text', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'rating' => ['label' => 'Rating', 'type' => 'number', 'rules' => 'nullable|integer|min:1|max:5'],
            'sort_order' => ['label' => 'Order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
