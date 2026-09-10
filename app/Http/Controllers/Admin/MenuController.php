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
         *
         * A dropdown's children are exempt: their headings are free text, so any
         * heading is a real column of that panel.
         */
        $stray = $menu->columnMode() === 'none' || $menu->supportsDropdowns()
            ? collect()
            : $items->reject(fn ($i) => in_array((string) $i->column_heading, $columns, true));

        return view('admin.menus.edit', [
            'menu' => $menu,
            'columns' => $columns,
            'items' => $items,
            'stray' => $stray,
            'board' => $menu->board(),
            'dropdowns' => $items->whereNull('parent_id')->filter->isDropdown(),
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
            'items.*.parent' => ['nullable', 'integer'],
        ];

        if ($menu->columnMode() === 'fixed') {
            $rules['items.*.column'] = ['nullable', Rule::in($menu->columnOptions())];
        }

        $rows = $request->validate($rules)['items'];

        // ids are client-supplied; only this menu's own items may be touched
        $owned = $menu->items()->pluck('id')->flip();
        $flat = $menu->columnMode() === 'none';
        $nested = $menu->supportsDropdowns();

        // only a dropdown of this menu can take children, and never itself
        $parents = $menu->items()->whereNull('parent_id')
            ->where('type', MenuItem::TYPE_DROPDOWN)->pluck('id')->flip();

        // menus are two levels deep, so anything that already has children stays put
        $hasChildren = $menu->items()->whereNotNull('parent_id')->pluck('parent_id')->unique()->flip();

        DB::transaction(function () use ($rows, $owned, $flat, $nested, $parents, $hasChildren) {
            foreach (array_values($rows) as $position => $row) {
                $id = (int) $row['id'];

                if (! $owned->has($id)) {
                    continue;
                }

                $parent = $nested && filled($row['parent'] ?? null) ? (int) $row['parent'] : null;

                /*
                 * Reject a nesting that cannot be drawn: a parent that is not a
                 * dropdown of this menu, an item under itself, or a panel being
                 * dragged into another panel — that last one would leave its own
                 * children pointing at something the navbar never opens, so they
                 * would vanish from the site with nothing on screen to explain it.
                 */
                if ($parent !== null && (! $parents->has($parent) || $parent === $id || $hasChildren->has($id))) {
                    $parent = null;
                }

                $column = filled($row['column'] ?? null) ? $row['column'] : null;

                $update = [
                    'sort_order' => $position,
                    // a child is always in a column; a top-level item never is
                    'column_heading' => $nested
                        ? ($parent === null ? null : $column)
                        : ($flat ? null : $column),
                ];

                if ($nested) {
                    $update['parent_id'] = $parent;

                    // a dropdown dragged under another item goes back to a link
                    if ($parent !== null) {
                        $update['type'] = MenuItem::TYPE_LINK;
                    }
                }

                MenuItem::whereKey($id)->update($update);
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

        if ($menu->supportsDropdowns()) {
            $rules['type'] = ['nullable', Rule::in([MenuItem::TYPE_LINK, MenuItem::TYPE_DROPDOWN])];

            // a parent must be a dropdown of this menu, so a child cannot be orphaned
            $rules['parent_id'] = [
                'nullable',
                Rule::exists('menu_items', 'id')
                    ->where('menu_id', $menu->id)
                    ->whereNull('parent_id')
                    ->where('type', MenuItem::TYPE_DROPDOWN),
            ];

            // a child is always in a column of its panel; a top-level item never is
            $rules['column_heading'] = $request->filled('parent_id')
                ? ['required', 'string', 'max:255']
                : ['nullable'];
        } else {
            $rules['column_heading'] = match ($mode) {
                // a mega item with no column renders nowhere, so it is not optional
                'fixed' => ['required', Rule::in($menu->columnOptions())],
                'free' => ['required', 'string', 'max:255'],
                default => ['nullable'],
            };
        }

        $data = $request->validate($rules, [], ['column_heading' => 'column']);

        $data['is_active'] = $request->boolean('is_active');
        $data['target'] = $data['target'] ?? '_self';

        if ($menu->supportsDropdowns()) {
            $data['parent_id'] = $data['parent_id'] ?? null;
            // only a top-level item can open a panel
            $data['type'] = $data['parent_id'] === null
                ? ($data['type'] ?? MenuItem::TYPE_LINK)
                : MenuItem::TYPE_LINK;
            $data['column_heading'] = $data['parent_id'] === null ? null : ($data['column_heading'] ?? null);
        } else {
            $data['column_heading'] = $mode === 'none' ? null : ($data['column_heading'] ?? null);
        }

        return $data;
    }
}
