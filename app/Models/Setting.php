<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Site-wide values the dashboard edits: logos, contact details, social links,
 * SEO defaults. Reads are cached because the layout touches them on every request.
 */
class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value', 'type', 'label', 'sort_order'];

    public const CACHE_KEY = 'settings.all';

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }

    /** All settings as group.key => value. */
    public static function allFlat(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::query()
                ->get()
                ->mapWithKeys(fn (self $s) => [$s->group . '.' . $s->key => $s->value])
                ->all();
        });
    }

    public static function get(string $path, mixed $default = null): mixed
    {
        return static::allFlat()[$path] ?? $default;
    }

    public static function put(string $group, string $key, mixed $value, string $type = 'text'): self
    {
        return static::updateOrCreate(
            ['group' => $group, 'key' => $key],
            ['value' => $value, 'type' => $type],
        );
    }
}
