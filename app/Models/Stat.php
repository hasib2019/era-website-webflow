<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = ['scope', 'value', 'suffix', 'suffix_html', 'label', 'sort_order'];

    public function scopeForScope($query, string $scope)
    {
        return $query->where('scope', $scope);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
