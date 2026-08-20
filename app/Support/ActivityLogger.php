<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Records who changed what. With several administrators sharing the dashboard,
 * an edit is only useful if it can be traced back.
 */
class ActivityLogger
{
    public static function log(string $action, ?Model $subject = null, ?string $description = null, array $changes = []): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => $subject ? $subject::class : null,
            'subject_id' => $subject?->getKey(),
            'description' => $description ?? static::describe($action, $subject),
            'changes' => $changes ?: null,
            'ip_address' => Request::ip(),
        ]);
    }

    /** Values that actually changed, with passwords and tokens stripped. */
    public static function diff(Model $model): array
    {
        $hidden = ['password', 'remember_token'];
        $changes = [];

        foreach ($model->getChanges() as $key => $new) {
            if (in_array($key, $hidden, true) || $key === 'updated_at') {
                continue;
            }
            $changes[$key] = ['from' => $model->getOriginal($key), 'to' => $new];
        }

        return $changes;
    }

    private static function describe(string $action, ?Model $subject): string
    {
        if (! $subject) {
            return $action;
        }

        $label = $subject->title ?? $subject->name ?? $subject->question ?? $subject->author ?? ('#' . $subject->getKey());

        return ucfirst($action) . ' ' . class_basename($subject) . ': ' . $label;
    }
}
