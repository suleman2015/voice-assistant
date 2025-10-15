<?php

use Modules\Menu\Models\Entities\Menu;
use Illuminate\Support\Facades\Cache;

if (! function_exists('menu_url')) {
    function menu_url($item): string {
        $resolver = config('menu.resolvers')[$item->type] ?? null;
        if (is_callable($resolver)) return $resolver($item);
        return '#';
    }
}

/**
 * Get or render a menu.
 *
 * Usage:
 *   // get model:
 *   $menu = menu('main');
 *
 *   // render with a view:
 *   {!! menu('main', 'menu::frontend.desktop') !!}
 */
if (! function_exists('menu')) {
    function menu(string $location, ?string $view = null, ?string $locale = null)
    {
        $locale ??= app()->getLocale();
        $key = "menu:{$location}:{$locale}";

        $menu = Cache::remember($key, now()->addMinutes(30), function () use ($location) {
            return Menu::where('location', $location)
                ->where('is_active', true)
                ->with(['items' => function ($q) {
                    $q->orderBy('order');
                }, 'items.children' => function ($q) {
                    $q->orderBy('order');
                }, 'items.children.children' => function ($q) {
                    $q->orderBy('order');
                }])
                ->first();
        });

        if (! $menu) return $view ? '' : null;

        return $view ? view($view, compact('menu'))->render() : $menu;
    }
}
