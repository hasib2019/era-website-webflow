<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PostCategory;

class PostController extends ResourceController
{
    protected function model(): string
    {
        return Post::class;
    }

    protected function key(): string
    {
        return 'posts';
    }

    protected function labels(): array
    {
        return ['singular' => 'Post', 'plural' => 'Blog posts'];
    }

    protected function columns(): array
    {
        return ['title', 'published_at', 'is_featured', 'is_published'];
    }

    protected function defaultOrder(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }

    protected function fields(): array
    {
        return [
            'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'summary' => ['label' => 'Summary', 'type' => 'textarea', 'rules' => 'nullable|string'],
            'body' => ['label' => 'Body', 'type' => 'richtext', 'rules' => 'nullable|string'],
            'image_id' => ['label' => 'Featured image', 'type' => 'media', 'rules' => 'nullable|exists:media,id'],
            'image_alt' => ['label' => 'Image alt text', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'post_category_id' => [
                'label' => 'Category',
                'type' => 'select',
                'rules' => 'nullable|exists:post_categories,id',
                'options' => fn () => PostCategory::orderBy('name')->pluck('name', 'id')->all(),
            ],
            'author_name' => ['label' => 'Author', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'author_role' => ['label' => 'Author role', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
            'author_image_id' => ['label' => 'Author photo', 'type' => 'media', 'rules' => 'nullable|exists:media,id'],
            'read_time' => ['label' => 'Read time', 'type' => 'number', 'rules' => 'nullable|integer|min:1'],
            'read_time_unit' => ['label' => 'Read time unit', 'type' => 'text', 'rules' => 'nullable|string|max:30'],
            'published_at' => ['label' => 'Publish date', 'type' => 'datetime', 'rules' => 'nullable|date'],
            'meta_title' => ['label' => 'Meta title', 'type' => 'text', 'rules' => 'nullable|string|max:255', 'group' => 'SEO'],
            'meta_description' => ['label' => 'Meta description', 'type' => 'textarea', 'rules' => 'nullable|string', 'group' => 'SEO'],
            'is_featured' => ['label' => 'Featured', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
            'is_published' => ['label' => 'Published', 'type' => 'checkbox', 'rules' => 'nullable|boolean'],
        ];
    }
}
