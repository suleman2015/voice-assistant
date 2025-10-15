<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Modules\Blog\Models\Post;
use Modules\Blog\Models\Tag;

class BlogController extends Controller
{

    public function check(Request $request)
    {
        $slug = Str::slug($request->get('slug', ''));

        $model = $request->get('model');
        $id = $request->get('id');

        if (!$model || !class_exists($model)) {
            return response()->json(['slug' => $slug]);
        }

        $instance = new $model;
        $table = $instance->getTable();

        $original = $slug;
        $counter = 1;

        // Ensure uniqueness
        while (DB::table($table)
            ->where('slug', $slug)
            ->when($id, fn($q) => $q->where('id', '!=', $id))
            ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return response()->json(['slug' => $slug]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('blog::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('blog::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function get_suggestions($keywords)
    {
        $query = trim($keywords);
        if (empty($query)) {
            return Response::json(['suggestions' => '']);
        }
        $query = preg_replace('/[^A-Za-z0-9 ]/', '', $query);

        $searchTerms = explode(' ', $query);
        $searchQuery = '';

        foreach ($searchTerms as $term) {
            $term = rtrim($term, '*');
            if (strlen($term) >= 3) {
                $searchQuery .= $term . '* ';
            } else {
                $searchQuery .= $term . ' ';
            }
        }

        $searchQuery = trim($searchQuery);
        $cacheKey = 'search_suggestions_' . md5($searchQuery);

        $suggestions = Cache::remember($cacheKey, now()->addMinutes(1), function () use ($searchQuery) {

            $posts = Post::select('name', 'description', 'content')
                ->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$searchQuery])
                ->get()
                ->map(function ($post) use ($searchQuery) {
                    $score = 0;
                    if (stripos($post->name, rtrim($searchQuery, '*')) !== false) {
                        $score += 5;
                    }
                    $post->score = $score;
                    return $post;
                })
                ->sortByDesc('score')
                ->take(10)
                ->values();

            $tags = Tag::select('name', 'description')
                ->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$searchQuery])
                ->orderBy('id', 'asc')
                ->get()
                ->map(function ($tag) use ($searchQuery) {
                    $score = 0;
                    if (stripos($tag->name, rtrim($searchQuery, '*')) !== false) {
                        $score += 5;
                    }
                    $tag->score = $score;
                    return $tag;
                })
                ->sortByDesc('score')
                ->take(10)
                ->values();

            return [
                'posts' => $posts,
                'tags' => $tags,
            ];
        });
        $suggestion = $suggestions['posts'];
        $tags = $suggestions['tags'];
        $suggestion_view = view('frontend.suggestion', compact('tags', 'suggestion'))->render();
        return Response::json([
            'view' => $suggestion_view,
            'suggestions' => $suggestions,
        ]);
    }
    public function get_blogs($keywords)
    {
        $query = trim($keywords);

        if (empty($query)) {
            return Response::json(['view' => '']);
        }
        $query = preg_replace('/[^A-Za-z0-9 ]/', '', $query);
        $searchTerms = explode(' ', $query);
        $searchQuery = '';

        foreach ($searchTerms as $term) {
            $term = rtrim($term, '*');
            if (strlen($term) >= 3) {
                $searchQuery .= $term . '* ';
            } else {
                $searchQuery .= $term . ' ';
            }
        }

        $searchQuery = trim($searchQuery);
        $cacheKey = 'blog_search_' . md5($searchQuery);
        $suggestions = Cache::remember($cacheKey, now()->addMinutes(1), function () use ($searchQuery) {
            $posts = Post::select('*')
                ->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$searchQuery])
                ->take(10)
                ->with('categories')
                ->get()
                ->map(function ($post) use ($searchQuery) {
                    $score = 0;
                    if (stripos($post->name, rtrim($searchQuery, '*')) !== false) {
                        $score += 5;
                    }

                    if (stripos($post->description, rtrim($searchQuery, '*')) !== false) {
                        $score += 3;
                    }
                    $post->score = $score;
                    return $post;
                })
                ->sortByDesc('score')
                ->take(10)
                ->values();

            $tags = Tag::select('*')
                ->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$searchQuery])
                ->take(10)
                ->get()
                ->map(function ($tag) use ($searchQuery) {
                    $score = 0;
                    if (stripos($tag->name, rtrim($searchQuery, '*')) !== false) {
                        $score += 5;
                    }
                    $tag->score = $score;
                    return $tag;
                })
                ->sortByDesc('score')
                ->take(10)
                ->values();
            $postIdsByTags = DB::table('post_tags')
                ->whereIn('tag_id', $tags->pluck('id'))
                ->pluck('post_id')
                ->toArray();

            $postsByTags = Post::whereIn('id', $postIdsByTags)
                ->orderBy('id', 'desc')
                ->take(10)
                ->get()
                ->map(function ($post) use ($searchQuery) {
                    $score = 0;
                    if (stripos($post->name, rtrim($searchQuery, '*')) !== false) {
                        $score += 4;
                    }
                    $post->score = $score;
                    return $post;
                })
                ->sortByDesc('score')
                ->take(10)
                ->values();

            return [
                'posts' => $posts,
                'tags' => $tags,
                'postsByTags' => $postsByTags,
            ];
        });

        $posts = $suggestions['posts'];
        $tags = $suggestions['tags'];
        $postsByTags = $suggestions['postsByTags'];
        $suggestion = null;
        $postsView = view('frontend.search', compact('posts', 'suggestion', 'keywords'))->render();

        return response()->json([
            'view' => $postsView,
            'suggestions' => $suggestions,
        ]);
    }
}
