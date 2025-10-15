<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Blog\Http\Requests\TagsRequest;
use Modules\Blog\Models\Tag;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        if ($request->ajax()) {
            $tags = Tag::query()->latest();

            return DataTables::of($tags)
                ->addIndexColumn()
                ->addColumn('status', function ($tag) {
                    $badgeClass = $tag->status === 'published'
                        ? 'success'
                        : ($tag->status === 'draft' ? 'warning' : 'secondary');

                    return "<span class='badge bg-{$badgeClass}'>"
                         . ucfirst($tag->status ?? '-') . "</span>";
                })
                ->addColumn('action', function ($tag) {
                    $editUrl = route('tags.edit', $tag->id);
                    $deleteUrl = route('tags.destroy', $tag->id);

                    return <<<HTML
                        <button type="button" class="btn btn-sm btn-primary edit-btn" data-edit-url="{$editUrl}" data-id="{$tag->id}">
                            <i class="bi bi-pencil-square me-1"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{$tag->id}" data-name="{$tag->name}">
                            <i class="bi bi-trash me-1"></i>
                        </button>
                    HTML;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('blog::tags.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog::tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagsRequest $request)
    {
        $validated = $request->validated();

        Tag::create($validated);

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);

        return view('blog::tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagsRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validated = $request->validated();
        $tag->update($validated);

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag deleted successfully.');
    }
}
