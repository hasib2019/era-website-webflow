<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Page;
use App\Models\PageSection;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Page-by-page content editing.
 *
 * Each page is a list of sections, and each section's `content` is a map of
 * field => ['type' => ..., 'value' => ...]. The editor renders an input per
 * field from that type, so adding a field to a section needs no code change.
 */
class PageController extends Controller
{
    public function index()
    {
        return view('admin.pages.index', [
            'pages' => Page::withCount('sections')->orderBy('sort_order')->get(),
        ]);
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', [
            'page' => $page->load('sections'),
            'mediaOptions' => Media::orderBy('folder')->orderBy('original_name')->get(),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'og_image_id' => ['nullable', 'exists:media,id'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $page->update($data);

        ActivityLogger::log('updated', $page, 'Updated page settings: ' . $page->name, ActivityLogger::diff($page));

        return back()->with('success', 'Page settings saved.');
    }

    public function updateSection(Request $request, Page $page, PageSection $section): RedirectResponse
    {
        abort_unless($section->page_id === $page->id, 404);

        $submitted = $request->input('content', []);
        $content = $section->content ?? [];

        // only fields the section already declares are writable, and each keeps
        // the type it was seeded with
        foreach ($content as $key => $definition) {
            if (! array_key_exists($key, $submitted)) {
                continue;
            }

            $value = $submitted[$key];
            $content[$key]['value'] = ($definition['type'] ?? 'text') === 'image'
                ? (string) $value
                : (is_string($value) ? trim($value) : $value);
        }

        $section->update([
            'content' => $content,
            'is_visible' => $request->boolean('is_visible'),
        ]);

        ActivityLogger::log(
            'updated',
            $section,
            'Updated section "' . $section->name . '" on ' . $page->name,
            ActivityLogger::diff($section),
        );

        return back()->with('success', 'Section "' . $section->name . '" saved.');
    }
}
