<?php

namespace Modules\PageBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\PageBuilder\Models\Page;
use Modules\PageBuilder\Models\PageComponent;

class PageBuilderController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', 1)
            ->firstOrFail();

        $componentIds = json_decode($page->component_id ?? '[]');

        $components = PageComponent::whereIn('id', $componentIds)
            ->with('items')
            ->orderByRaw("FIELD(id, " . implode(',', $componentIds) . ")")
            ->get();

        return view('pagebuilder::layouts.master', compact('page', 'components'));
    }
}
