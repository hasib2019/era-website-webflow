<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
        return view('admin.menus.edit', [
            'menu' => $menu->load('items'),
        ]);
    }

    public function storeItem(Request $request, Menu $menu): RedirectResponse
    {
        $data = $this->validateItem($request);
        $data['menu_id'] = $menu->id;
        $data['sort_order'] = $data['sort_order'] ?? ($menu->items()->max('sort_order') + 1);

        $item = MenuItem::create($data);
        ActivityLogger::log('created', $item, 'Added "' . $item->label . '" to ' . $menu->name);

        return back()->with('success', 'Menu item added.');
    }

    public function updateItem(Request $request, Menu $menu, MenuItem $item): RedirectResponse
    {
        abort_unless($item->menu_id === $menu->id, 404);

        $item->update($this->validateItem($request));
        ActivityLogger::log('updated', $item, 'Updated "' . $item->label . '" in ' . $menu->name, ActivityLogger::diff($item));

        return back()->with('success', 'Menu item updated.');
    }

    public function destroyItem(Menu $menu, MenuItem $item): RedirectResponse
    {
        abort_unless($item->menu_id === $menu->id, 404);

        ActivityLogger::log('deleted', $item, 'Removed "' . $item->label . '" from ' . $menu->name);
        $item->delete();

        return back()->with('success', 'Menu item removed.');
    }

    private function validateItem(Request $request): array
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'target' => ['nullable', 'in:_self,_blank'],
            'column_heading' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['target'] = $data['target'] ?? '_self';

        return $data;
    }
}
