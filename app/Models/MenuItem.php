<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    public const TYPE_LINK = 'link';

    public const TYPE_DROPDOWN = 'dropdown';

    protected $fillable = [
        'menu_id', 'parent_id', 'type', 'label', 'url',
        'target', 'column_heading', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    /** A dropdown opens a panel built from its children instead of navigating. */
    public function isDropdown(): bool
    {
        return $this->type === self::TYPE_DROPDOWN;
    }

    /**
     * The panel's columns, in the order the site draws them.
     *
     * Grouped on `column_heading`, so naming a new heading grows a column and
     * emptying one removes it — the same rule the footer already follows.
     * Children with no heading fall into the first column rather than
     * disappearing, because an invisible link is the harder bug to notice.
     */
    public function columns(): \Illuminate\Support\Collection
    {
        return $this->children
            ->groupBy(fn (self $child) => (string) ($child->column_heading ?: 'Column 1'));
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }
}
