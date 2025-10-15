<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Blog\Models\Tag;
use Modules\Blog\Models\Post;
use Modules\Blog\Models\Category;
use App\Http\Controllers\Controller;
use Modules\Blog\Helpers\ImageHelper;
use Yajra\DataTables\Facades\DataTables;
use Modules\Blog\Http\Requests\PostsRequest;

class PostController extends Controller
{
    private const IMAGE_PATH = 'blogs/posts/images';

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::with('categories')->latest()->get();

            return DataTables::of($posts)
                ->addIndexColumn()
                ->addColumn('image', function ($post) {
                    $imageUrl = $post->image ? asset($post->image) : '';
                    return '<img src="' . $imageUrl . '" alt="Post Image" width="60" height="60" style="object-fit:cover;border-radius:5px;">';
                })
                ->addColumn('name', fn($post) => $post->name)
                // ->addColumn('name', fn($post) => humanize_string($post->name))
                ->addColumn('categories', function ($post) {
                    return $post->categories->map(fn($cat) => "<span class='badge bg-info bg-opacity-10 text-info fw-semibold me-1 mb-1'>{$cat->name}</span>")->implode(' ');
                })
                ->addColumn('status', fn($post) => $post->status ?? '-')
                ->addColumn('action', function ($post) {
                    $editUrl = route('posts.edit', $post->id);
                    return <<<HTML
                        <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="{$post->id}" data-edit-url="{$editUrl}"><i class="bi bi-pencil-square me-1"></i></button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{$post->id}" data-name="{$post->name}"><i class="bi bi-trash me-1"></i></button>
                    HTML;
                })
                ->rawColumns(['image', 'categories', 'action'])
                ->make(true);
        }

        return view('blog::posts.index');
    }

    public function create()
    {
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->get();
        $tags = Tag::all();

        return view('blog::posts.create', compact('categories', 'tags'));
    }

    public function edit(Post $post)
    {
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->get();
        $tags = Tag::all();

        return view('blog::posts.edit', compact('post', 'categories', 'tags'));
    }

    public function store(PostsRequest $request)
    {
        $data = $request->validated();

        // Handle main image
        if ($request->hasFile('image')) {
            $data['image'] = ImageHelper::upload($request->file('image'), self::IMAGE_PATH);
        } elseif ($request->filled('image')) {
            $data['image'] = str_replace(url('/') . '/', '', $request->input('image'));
        }

        // Handle doctor image
        if ($request->hasFile('dr_image')) {
            $data['dr_image'] = ImageHelper::upload($request->file('dr_image'), self::IMAGE_PATH);
        }

        // Key points array → JSON
        $data['key_points'] = $request->has('key_points') ? array_filter($request->key_points) : [];

        $post = Post::create($data);

        // SEO meta
        if ($request->has('seo')) {
            $post->setSeoData($request->input('seo'));
        }

        // Sync relations
        $post->categories()->sync($request->input('categories', []));
        $tagIds = [];
        foreach ($request->input('tags', []) as $tagInput) {
            if (is_numeric($tagInput)) {
                $tagIds[] = $tagInput;
            } else {
                $tag = Tag::firstOrCreate(['name' => trim($tagInput), 'status' => 'published']);
                $tagIds[] = $tag->id;
            }
        }
        $post->tags()->sync($tagIds);

        $keywordIds = [];
        foreach ($request->input('keywords', []) as $tagInput) {
            if (is_numeric($tagInput)) {
                $keywordIds[] = $tagInput;
            } else {
                $tag = Tag::firstOrCreate(['name' => trim($tagInput), 'status' => 'published']);
                $keywordIds[] = $tag->id;
            }
        }
        $post->keywords()->sync($keywordIds);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function update(PostsRequest $request, Post $post)
    {
        $data = $request->validated();

        // Handle main image
        if ($request->hasFile('image')) {
            ImageHelper::delete($post->image, self::IMAGE_PATH);
            $data['image'] = ImageHelper::upload($request->file('image'), self::IMAGE_PATH);
        } elseif ($request->filled('image')) {
            $data['image'] = str_replace(url('/') . '/', '', $request->input('image'));
        } elseif ($request->input('remove_image') === '1') {
            ImageHelper::delete($post->image, self::IMAGE_PATH);
            $data['image'] = null;
        }

        // Handle doctor image
        if ($request->hasFile('dr_image')) {
            ImageHelper::delete($post->dr_image, self::IMAGE_PATH);
            $data['dr_image'] = ImageHelper::upload($request->file('dr_image'), self::IMAGE_PATH);
        }

        // Key points
        $data['key_points'] = $request->has('key_points') ? array_filter($request->key_points) : [];

        $post->update($data);

        // SEO meta
        if ($request->has('seo')) {
            $post->setSeoData($request->input('seo'));
        }

        // Sync relations
        $post->categories()->sync($request->input('categories', []));
        // ✅ Tags (create if not exists)
        $tagIds = [];
        foreach ($request->input('tags', []) as $tagInput) {
            if (is_numeric($tagInput)) {
                $tagIds[] = $tagInput;
            } else {
                $tag = Tag::firstOrCreate(['name' => trim($tagInput), 'status' => 'published']);
                $tagIds[] = $tag->id;
            }
        }
        $post->tags()->sync($tagIds);

        $keywordIds = [];
        foreach ($request->input('keywords', []) as $tagInput) {
            if (is_numeric($tagInput)) {
                $keywordIds[] = $tagInput;
            } else {
                $tag = Tag::firstOrCreate(['name' => trim($tagInput), 'status' => 'published']);
                $keywordIds[] = $tag->id;
            }
        }
        $post->keywords()->sync($keywordIds);

        return redirect()->back()->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        // Delete images
        ImageHelper::delete($post->image, self::IMAGE_PATH);
        ImageHelper::delete($post->dr_image, self::IMAGE_PATH);

        // Detach relations
        $post->categories()->detach();
        $post->tags()->detach();

        // Delete post
        $post->delete();

        return response()->json(['success' => true, 'message' => 'Post deleted successfully.']);
    }
}
