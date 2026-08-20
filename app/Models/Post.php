<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'title', 'summary', 'body', 'image_id', 'image_alt',
        'post_category_id', 'author_name', 'author_role', 'author_image_id',
        'read_time', 'read_time_unit', 'is_featured',
        'meta_title', 'meta_description', 'is_published', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'read_time' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'image_id');
    }

    public function authorImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'author_image_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }

    /** "Jul 10, 2024" — the format the template prints. */
    public function getDisplayDateAttribute(): string
    {
        return ($this->published_at ?? $this->created_at)->format('M j, Y');
    }
}
