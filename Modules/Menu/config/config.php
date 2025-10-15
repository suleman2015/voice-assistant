<?php

use Illuminate\Support\Facades\Route;
use Modules\PageBuilder\Models\Page;

return [
    'locations' => ['main','footer'],

    'resolvers' => [
        'page' => function ($item) {
            if (!$item->reference_id) return '#';

            $page = Page::find($item->reference_id);
            if (!$page) return '#';

            $slug = trim($page->slug, '/');

            // home page
            if ($slug === '' || $slug === '/') {
                return url('/');
            }

            // Prefer named routes if present
            if (Route::has('page.detail')) {
                return route('page.detail', ['slug' => $slug]);
            }
            if (Route::has('page.show')) {
                return route('page.show', ['slug' => $slug]);
            }

            // Fallback to the concrete path you actually expose
            return url('test/'.$slug);
        },

        'category' => function ($item) {
            return Route::has('blog.category')
                ? route('blog.category', $item->reference_id)
                : '#';
        },

        'post' => function ($item) {
            return Route::has('blog.detail')
                ? route('blog.detail', $item->reference_id)
                : '#';
        },

        'route' => function ($item) {
            return $item->route_name && Route::has($item->route_name)
                ? route($item->route_name, $item->route_params ?? [])
                : '#';
        },

        'custom' => fn($item) => $item->url ?: '#',
    ],
];
