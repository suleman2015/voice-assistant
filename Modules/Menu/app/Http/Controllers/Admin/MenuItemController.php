<?php

namespace Modules\Menu\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Models\Entities\Menu;
use Modules\Menu\Models\Entities\MenuItem;
use Illuminate\Validation\Rule;

class MenuItemController extends Controller
{
    public function store(Menu $menu, Request $request)
    {
        $type = $request->input('type');

        // Bulk add for page/category/post
        if (in_array($type, ['page', 'category', 'post']) && $request->filled('references')) {
            $request->validate([
                'references'   => 'array|min:1',
                'references.*' => 'integer',
            ]);

            foreach ((array) $request->input('references') as $refId) {
                MenuItem::create([
                    'menu_id'        => $menu->id,
                    'parent_id'      => null,
                    'order'          => $menu->items()->count(),
                    'title'          => $this->defaultTitle($type, (int) $refId, $request->input('title')),
                    'type'           => $type,
                    'reference_type' => $this->mapReferenceType($type), // ✅ set mapped class
                    'reference_id'   => (int) $refId,
                ]);
            }

            cache()->forget("menu:{$menu->location}:" . app()->getLocale());
            return back()->with('success', 'Items added');
        }

        // Single add (custom, route, or single reference)
        $data = $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'type'          => ['required', Rule::in(['custom', 'page', 'category', 'post', 'route'])],
            'url'           => ['nullable', 'string', 'max:255'], // Only for 'custom' type
            'reference_id'  => ['nullable', 'integer'],
            'route_name'    => ['nullable', 'string'],
            'route_params'  => ['nullable', 'array'],
            'icon_class'    => ['nullable', 'string', 'max:100'],
            'css_class'     => ['nullable', 'string', 'max:100'],
            'is_new_tab'    => ['boolean'],
            'locale'        => ['nullable', 'string', 'max:5'],
        ]);

        $data['menu_id']        = $menu->id;
        $data['order']          = $menu->items()->count();
        $data['reference_type'] = $this->mapReferenceType($data['type']); // ✅ set mapped class

        $item = MenuItem::create($data);

        cache()->forget("menu:{$menu->location}:" . app()->getLocale());

        // If the form came via AJAX, return JSON so the UI can update without reload
        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'item' => $item]);
        }

        return back()->with('success', 'Item added');
    }

    public function update(MenuItem $item, Request $request)
    {
        // Inline edit for title + url (only for custom)
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'url'   => ['nullable', 'string', 'max:255'], // Only meaningful when $item->type === 'custom'
        ]);

        $item->title = $data['title'];
        if ($item->type === 'custom') {
            $item->url = $data['url'] ?? $item->url;
        }
        $item->save();

        cache()->forget("menu:{$item->menu->location}:" . app()->getLocale());

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'item' => $item]);
        }

        return back()->with('success', 'Item updated');
    }

    public function syncTree(Menu $menu, Request $request)
    {
        $tree = $request->validate(['tree' => 'required|array'])['tree'];

        foreach ($tree as $node) {
            $menuItem = MenuItem::find($node['id']); // 👈 fetch model

            if ($menuItem) {
                $menuItem->parent_id      = $node['parent_id'];
                $menuItem->order          = $node['order'];
                $menuItem->reference_type = $this->mapReferenceType($menuItem->type); // 👈 map class
                $menuItem->save();
            }
        }

        cache()->forget("menu:{$menu->location}:" . app()->getLocale());
        return response()->json(['ok' => true]);
    }

    public function destroy(MenuItem $item)
    {
        $location = $item->menu->location;
        $item->delete();
        cache()->forget("menu:{$location}:" . app()->getLocale());
        return back()->with('success', 'Item deleted');
    }

    private function defaultTitle(string $type, int $id, ?string $override): string
    {
        if ($override) return $override;

        if ($type === 'page') {
            return optional(\Modules\PageBuilder\Models\Page::find($id))->title ?? 'Page';
        }
        if ($type === 'category') {
            return optional(\Modules\Blog\Models\Category::find($id))->name ?? 'Category';
        }
        if ($type === 'post') {
            return optional(\Modules\Blog\Models\Post::find($id))->name ?? 'Post';
        }
        return 'Item';
    }

    private function mapReferenceType(string $type): ?string
    {
        return match ($type) {
            'page'     => \Modules\PageBuilder\Models\Page::class,
            'category' => \Modules\Blog\Models\Category::class,
            'post'     => \Modules\Blog\Models\Post::class,
            default    => null,
        };
    }
}
