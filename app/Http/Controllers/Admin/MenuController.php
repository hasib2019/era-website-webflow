<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Support\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * The navigation builder.
 *
 * Items carry a `column_heading` that the site partials read literally — the
 * mega menu asks for 'Column 1'..'Column 3' by name, the footer groups by
 * whatever headings exist. The editor used to offer no way to set it at all,
 * so every link added here landed with a null heading and rendered nowhere.
 * config/menus.php now declares what each menu accepts and the forms below
 * enforce it.
 */
class MenuController extends Controller
{
    public function index()
    {
        return view('admin.menus.index', [
            'menus' => Menu::withCount('items')->orderBy('name')->get(),
        ]);
    }

    public function edit(Menu $menu)
    {
        $items = $menu->items()->orderBy('sort_order')->orderBy('id')->get();
        $columns = $menu->columnOptions();

        /*
         * Anything whose heading is not a known column would be invisible on the
         * site, so it gets its own bucket in the editor rather than being hidden
         * here too. That is where links added before this screen could set a
         * column end up, which is exactly what needs to be obvious.
         */
        $stray = $menu->columnMode() === 'none'
            ? collect()
            : $items->reject(fn ($i) => in_array((string) $i->column_heading, $columns, true));

        return view('admin.menus.edit', [
            'menu' => $menu,
            'columns' => $columns,
            'items' => $items,
            'stray' => $stray,
        ]);
    }

    public function storeItem(Request $request, Menu $menu): RedirectResponse
    {
        $data = $this->validateItem($request, $menu);
        $data['menu_id'] = $menu->id;
        $data['sort_order'] = $data['sort_order'] ?? ((int) $menu->items()->max('sort_order') + 1);

        $item = MenuItem::create($data);
        ActivityLogger::log('created', $item, 'Added "' . $item->label . '" to ' . $menu->name);

        return back()->with('success', 'Added "' . $item->label . '" to ' . $menu->name . '.');
    }

    public function updateItem(Request $request, Menu $menu, MenuItem $item): RedirectResponse
    {
        abort_unless($item->menu_id === $menu->id, 404);

        $item->update($this->validateItem($request, $menu));
        ActivityLogger::log('updated', $item, 'Updated "' . $item->label . '" in ' . $menu->name, ActivityLogger::diff($item));

        return back()->with('success', 'Saved "' . $item->label . '".');
    }

    public function destroyItem(Menu $menu, MenuItem $item): RedirectResponse
    {
        abort_unless($item->menu_id === $menu->id, 404);

        ActivityLogger::log('deleted', $item, 'Removed "' . $item->label . '" from ' . $menu->name);
        $item->delete();

        return back()->with('success', 'Removed "' . $item->label . '".');
    }

    /**
     * Persist a drag: the new order, and which column each item landed in.
     *
     * The whole menu is sent at once, so one pass writes every position and no
     * item can be left holding a stale index.
     */
    public function reorder(Request $request, Menu $menu): JsonResponse
    {
        $rules = [
            'items' => ['present', 'array'],
            'items.*.id' => ['required', 'integer'],
            'items.*.column' => ['nullable', 'string', 'max:255'],
        ];

        if ($menu->columnMode() === 'fixed') {
            $rules['items.*.column'] = ['nullable', Rule::in($menu->columnOptions())];
        }

        $rows = $request->validate($rules)['items'];

        // ids are client-supplied; only this menu's own items may be touched
        $owned = $menu->items()->pluck('id')->flip();
        $flat = $menu->columnMode() === 'none';

        DB::transaction(function () use ($rows, $owned, $flat) {
            foreach (array_values($rows) as $position => $row) {
                if (! $owned->has((int) $row['id'])) {
                    continue;
                }

                MenuItem::whereKey((int) $row['id'])->update([
                    'sort_order' => $position,
                    'column_heading' => $flat ? null : (filled($row['column'] ?? null) ? $row['column'] : null),
                ]);
            }
        });

        ActivityLogger::log('updated', $menu, 'Reordered ' . $menu->name);

        return response()->json(['message' => $menu->name . ' order saved.']);
    }

    private function validateItem(Request $request, Menu $menu): array
    {
        $mode = $menu->columnMode();

        $rules = [
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'target' => ['nullable', 'in:_self,_blank'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];

        $rules['column_heading'] = match ($mode) {
            // a mega item with no column renders nowhere, so it is not optional
            'fixed' => ['required', Rule::in($menu->columnOptions())],
            'free' => ['required', 'string', 'max:255'],
            default => ['nullable'],
        };

        $data = $request->validate($rules, [], ['column_heading' => 'column']);

        $data['is_active'] = $request->boolean('is_active');
        $data['target'] = $data['target'] ?? '_self';
        $data['column_heading'] = $mode === 'none' ? null : ($data['column_heading'] ?? null);

        return $data;
    }
}
