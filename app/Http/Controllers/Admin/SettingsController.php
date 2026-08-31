<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Setting;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'groups' => Setting::orderBy('group')->orderBy('sort_order')->get()->groupBy('group'),
            'mediaOptions' => Media::orderBy('folder')->orderBy('original_name')->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $submitted = $request->input('settings', []);
        $changed = 0;

        foreach (Setting::all() as $setting) {
            $path = $setting->group . '.' . $setting->key;
            if (! Arr::has($submitted, $path)) {
                continue;
            }

            $value = data_get($submitted, $path);

            if ((string) $value === (string) $setting->value) {
                continue;
            }

            $setting->update(['value' => is_string($value) ? trim($value) : $value]);
            $changed++;
        }

        ActivityLogger::log('updated', null, "Updated $changed site setting(s)");

        return back()->with('success', $changed . ' setting(s) saved.');
    }
}
