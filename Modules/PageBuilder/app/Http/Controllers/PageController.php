<?php

namespace Modules\PageBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\PageBuilder\Models\Page;
use Modules\PageBuilder\Models\PageComponent;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        breadcrumb()->reset()
            ->add('Dashboard', route('dashboard'))
            ->add('Pages', route('pages.index'));

        if ($request->ajax()) {
            $data = Page::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return <<<HTML
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" {$checked} disabled>
                </div>
            HTML;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('pages.edit', $row->id);
                    $pageName = e($row->name);

                    return <<<HTML
                <a href="{$editUrl}" class="btn btn-sm btn-primary">Edit</a>
                <button type="button"
                        class="btn btn-sm btn-danger delete-btn"
                        data-id="{$row->id}"
                        data-name="{$pageName}">
                    Delete
                </button>
            HTML;
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }


        return view('pagebuilder::pages.index');
    }

    /**
     * Renders the page create view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('pagebuilder::pages.create');
    }

    /**
     * Creates a new page.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ([
            'title' => 'required',
            'slug' => 'required|unique:pages',
            'content' => 'nullable',
            'is_active' => 'boolean',
        ]));

        if ($validator->fails()) {

            return redirect()->back()->withInput()->with('error', $validator->errors()->first());
        }

        $validateData = $validator->getData();
        $page = new Page;
        if ($page->where('slug', $validateData['slug'])->exists()) {

            return redirect()->back()->withInput()->with('error', __('Page slug already exists'));
        }
        $page->is_breadcrumb = $validateData['is_breadcrumb'] ?? 0;
        $page->title = $validateData['title'];
        $page->slug = Str::slug($validateData['slug']);
        $page->content = $validateData['content'] ?? null;
        $page->save();

        if ($request->has('seo')) {
            $page->setSeoData($request->input('seo'));
        }

        return redirect()->route('pages.index')->with('success', __('Page Created Successfully'));
    }

    /**
     * Renders the page edit view.
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $page = Page::find($id);


        return view('pagebuilder::pages.edit', compact('page'));
    }

    /**
     * Updates the page.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), ([
            'title' => 'required',
        ]));

        if ($validator->fails()) {

            return redirect()->back()->withInput()->with('error', $validator->errors()->first());
        }

        $validateData = $validator->getData();

        $page = Page::find($id);
        $page->title = $validateData['title'];
        $page->content = json_encode($validateData['content']);
        $page->is_active = $request->is_active ?? 0;
        $page->slug = $page->slug != '/' ? Str::slug($validateData['slug']) : $page->slug;
        $page->save();

        /**
         * ✅ Handle SEO update:
         * - If SEO fields exist in the request
         * - Use the HasSeoMeta trait method to update
         */
        if ($request->has('seo')) {
            $page->setSeoData($request->input('seo'));
        }

        return redirect()->back()->with('success', __('Page Updated Successfully'));
    }

    public function destroy($id)
    {
        $page = Page::find($id);
        if ($page->slug == '/') {

            return redirect()->back()->with('error', __('Cannot delete the home page'));
        }
        $page->delete();

        return redirect()->back()->with('success', __('Page Deleted Successfully'));
    }



    public function error404()
    {
        return view('pagebuilder::pages.404');
    }
}
