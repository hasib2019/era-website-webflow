<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseStudyStrategy extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_study_id', 'heading', 'body',
        'image_id', 'image_alt', 'layout', 'sort_order',
    ];

    public function caseStudy(): BelongsTo
    {
        return $this->belongsTo(CaseStudy::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'image_id');
    }

    public function isImageFirst(): bool
    {
        return $this->layout === 'image_left_text_right';
    }
}
