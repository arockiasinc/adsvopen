<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $this->ensureAdmin();

        return view('menus.index', [
            'menus' => Menu::query()->ordered()->get(),
        ]);
    }

    public function store(MenuRequest $request): RedirectResponse
    {
        $this->ensureAdmin();

        Menu::create($request->validated());

        return redirect()
            ->route('menus.index')
            ->with('status', 'Menu item created successfully.');
    }

    public function update(MenuRequest $request, Menu $menu): RedirectResponse
    {
        $this->ensureAdmin();

        $menu->update($request->validated());

        return redirect()
            ->route('menus.index')
            ->with('status', 'Menu item updated successfully.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $this->ensureAdmin();

        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->with('status', 'Menu item deleted successfully.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'menu_ids' => ['required', 'array', 'min:1'],
            'menu_ids.*' => ['required', 'integer', 'distinct', 'exists:menus,id'],
        ]);

        foreach ($validated['menu_ids'] as $index => $menuId) {
            Menu::query()
                ->whereKey($menuId)
                ->update(['sort_order' => $index + 1]);
        }

        return redirect()
            ->route('menus.index')
            ->with('status', 'Menu order updated successfully.');
    }

    protected function ensureAdmin(): void
    {
        abort_unless(request()->user()?->isAdmin(), 403);
    }
}
