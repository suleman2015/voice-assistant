<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Helpers\ImageHelper;
use Modules\Blog\Http\Requests\CategoriesRequest;
use Modules\Blog\Models\Category;

class CategoryController extends Controller
{
    private const IMAGE_PATH = 'blogs/categories/images';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        // for dropdown, we need all categories flattened
        $allCategories = Category::orderBy('parent_id')
            ->orderBy('order')
            ->get();

        return view('blog::categories.index', compact('categories', 'allCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        $allCategories = Category::orderBy('parent_id')
            ->orderBy('order')
            ->get();

        $editCategory = Category::findOrFail($id);

        return view('blog::categories.index', compact('categories', 'allCategories', 'editCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriesRequest $request)
    {
        $validated = $request->validated();
        $validated['is_featured'] = $request->has('is_featured');
        if ($request->hasFile('image')) {
            $validated['image'] = ImageHelper::upload($request->file('image'), self::IMAGE_PATH);
        } elseif ($request->filled('image')) {
            $validated['image'] = str_replace(url('/') . '/', '', $request->input('image'));
        }
        $category = Category::create($validated);
        if ($request->has('seo')) {
            $category->setSeoData($request->input('seo'));
        }

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriesRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validated();
        $validated['is_featured'] = $request->has('is_featured');
        if ($request->hasFile('image')) {
            ImageHelper::delete($category->image, self::IMAGE_PATH);
            $validated['image'] = ImageHelper::upload($request->file('image'), self::IMAGE_PATH);
        } elseif ($request->filled('image')) {
            $validated['image'] = str_replace(url('/') . '/', '', $request->input('image'));
        } elseif ($request->input('remove_image') === '1') {
            ImageHelper::delete($category->image, self::IMAGE_PATH);
            $validated['image'] = null;
        }
        if ($request->has('seo')) {
            $category->setSeoData($request->input('seo'));
        }
        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Optionally, also delete children recursively
        if ($category->children()->count()) {
            foreach ($category->children as $child) {
                $child->delete();
            }
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
