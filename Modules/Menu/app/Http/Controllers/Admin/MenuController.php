<?php

namespace Modules\Menu\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Modules\Menu\Models\Entities\Menu;
use Yajra\DataTables\Facades\DataTables;
use Modules\PageBuilder\Models\Page;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Post;

class MenuController extends Controller
{
    /**
     * List menus with search and quick actions.
     */
    public function index(Request $request)
    {
        // AJAX for DataTables
        if ($request->ajax()) {
            $query = Menu::query()->withCount('items')->latest('updated_at');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('name', fn($m) => e($m->name))
                ->editColumn('location', fn($m) => '<code>' . e($m->location) . '</code>')
                ->addColumn('is_active', function ($m) {
                    return $m->is_active
                        ? '<span class="badge bg-success-subtle text-success">Active</span>'
                        : '<span class="badge bg-secondary-subtle text-secondary">Disabled</span>';
                })
                ->addColumn('action', function ($a) {
                    $editUrl   = route('admin.menus.edit', $a->id);
                    $toggleUrl = route('admin.menus.toggle', $a->id);
                    $deleteUrl = route('admin.menus.destroy', $a->id);

                    return view('menu::admin.partials.menu_actions', compact('a', 'editUrl', 'toggleUrl', 'deleteUrl'))->render();
                })
                ->rawColumns(['location', 'is_active', 'action'])
                ->make(true);
        }

        // First paint (blade only; DT will fetch via AJAX)
        return view('menu::admin.index');
    }
    /**
     * Create a new menu then jump straight to its edit page.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:120'],
            'location'  => ['required', 'string', 'max:80', 'alpha_dash', Rule::unique('menus', 'location')],
            'is_active' => ['nullable'],
        ]);

        $data['name']      = trim(preg_replace('/\s+/', ' ', $data['name']));
        $data['location']  = Str::slug($data['location'], '_');
        $data['is_active'] = $request->boolean('is_active');

        $menu = Menu::create($data);

        return redirect()->route('admin.menus.edit', $menu->id)
            ->with('success', 'Menu created');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->load('items.children');
        $pages      = Page::select('id', 'title')->latest()->get();

        return view('menu::admin.edit', compact('menu', 'pages'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->validate([
            'name'      => ['required', 'string', 'max:120'],
            'location'  => ['required', 'string', 'max:80', 'alpha_dash', Rule::unique('menus', 'location')->ignore($menu->id)],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['name']      = trim(preg_replace('/\s+/', ' ', $data['name']));
        $data['location']  = Str::slug($data['location'], '_');
        $data['is_active'] = $request->boolean('is_active');

        $oldLocation = $menu->location;
        $menu->fill($data)->save();

        $locale = app()->getLocale();
        cache()->forget("menu:{$oldLocation}:{$locale}");
        cache()->forget("menu:{$menu->location}:{$locale}");

        return back()->with('success', 'Menu updated');
    }

    public function destroy($id)
    {
        $menu   = Menu::findOrFail($id);
        $locale = app()->getLocale();

        cache()->forget("menu:{$menu->location}:{$locale}");
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted');
    }

    /**
     * Quick enable/disable toggle in index table.
     */
    public function toggle($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->is_active = ! $menu->is_active;
        $menu->save();

        cache()->forget("menu:{$menu->location}:" . app()->getLocale());

        return back()->with('success', 'Menu status updated');
    }
}
