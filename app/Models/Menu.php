<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'description'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    /**
     * How this menu groups its items: none, fixed or free.
     *
     * @see config/menus.php, which explains why the mega menu's set is closed
     *      and the footer's is not.
     */
    public function columnMode(): string
    {
        return config('menus.' . $this->slug . '.mode', 'free');
    }

    /** Headings to offer in the editor, in the order the site renders them. */
    public function columnOptions(): array
    {
        if ($this->columnMode() === 'none') {
            return [];
        }

        if ($this->columnMode() === 'fixed') {
            return config('menus.' . $this->slug . '.columns', []);
        }

        // free: whatever the items already use, so the editor mirrors the site
        return $this->items()
            ->whereNotNull('column_heading')
            ->distinct()
            ->orderBy('column_heading')
            ->pluck('column_heading')
            ->all();
    }

    public function help(): ?string
    {
        return config('menus.' . $this->slug . '.help');
    }

    /** Active top-level items with their children, ready to render. */
    public function tree(): Collection
    {
        return $this->items()
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->get();
    }
}
