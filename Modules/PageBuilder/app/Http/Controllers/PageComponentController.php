<?php

namespace Modules\PageBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;
use Modules\Language\Models\Language;
use Modules\PageBuilder\Models\PageComponent;
use Modules\PageBuilder\Services\ComponentService;
use Modules\PageBuilder\Traits\FileManageTrait;

class PageComponentController extends Controller
{
    use FileManageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = PageComponent::query();
        $categories = $sections->pluck('category')->unique();
        $display = ['grid' => __('Grid'), 'list' => __('List')];
        $currentDisplay = request()->get('component_display', 'grid');
        $currentCategory = request()->get('component_category', 'all');
        $filterRequest = request()->all();
        if (! empty($filterRequest['component_category']) && $filterRequest['component_category'] !== 'all') {
            $sections->where('category', $filterRequest['component_category']);
        }

        $sections = $sections->get()->sortBy('sort');

        return view('pagebuilder::component.index', compact('sections', 'categories', 'display', 'currentDisplay', 'currentCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::where('status', 1)->pluck('name', 'short_code');

        return view('pagebuilder::component.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|unique:page_components',
            'icon' => 'required|mimes:png,jpg,jpeg,avif,webp',
            'content' => 'required',
            'status' => 'boolean'
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withInput()->with('error', $validated->errors()->first());
        }

        $input = $validated->getData();
        $content = Purifier::clean(htmlspecialchars_decode($input['content']));

        $data['type'] = 'dynamic';
        $data['section'] = 'dynamic';
        $data['name'] = $input['name'];
        $data['icon'] = self::uploadImage($input['icon']);
        $data['content'] = json_encode([config('app.static_default_language') => $content]);
        $data['status'] = $input['status'] ?? 0;

        PageComponent::create($data);

        return redirect()->back()->with('success', __('Component Created Successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $component = PageComponent::with('items')->findOrFail($id);

        $currentDisplay = $request->get('component_display', 'grid');
        $currentCategory = $request->get('component_category', 'all');
        $languages = Language::where('status', 1)->pluck('name', 'short_code');

        $data = $this->prepareComponentData($component, $languages);

        return view('pagebuilder::component.edit', compact('data', 'languages', 'currentDisplay', 'currentCategory'));
    }

    private function prepareComponentData($component, $languages)
    {
        $modifiedComponentMainData = $this->modifyComponentDataForTranslation($component, $languages);

        $filteredContentFields = null;
        $filteredComponentListContent = [];

        if ($component->content_fields !== null) {
            $filteredContentFields = $this->filterContentFields($component->content_fields);

            $filteredComponentListContent = $this->filterComponentListContent($component->items);
        }

        return [
            'id' => $component->id,
            'content_id' => $component->content_id,
            'icon' => $component->icon,
            'preview' => $component->preview,
            'type' => $component->type,
            'section' => $component->section,
            'content' => $modifiedComponentMainData,
            'name' => $component->name,
            'status' => $component->status,
            'content_fields' => $component->content_fields !== null ? json_decode($component->content_fields) : null,
            'content_items' => $component->componentContent,
            'with_modal' => $component->with_modal,
            'item_list_level' => $filteredContentFields,
            'item_list_value' => $filteredComponentListContent,
        ];
    }

    private function modifyComponentDataForTranslation($component, $languages)
    {
        $componentMainData = json_decode($component->content ?? '{}');

        // Fallback: use 'en' if available, otherwise use the first language or empty array
        $defaultOtherLanguageComponentMainData = $componentMainData->en ?? [];

        if ($component->type === 'static') {
            $defaultOtherLanguageComponentMainData = collect($defaultOtherLanguageComponentMainData)
                ->reject(function ($item) {
                    return (isset($item->type) && $item->type === 'img') ||
                        (isset($item->trans) && $item->trans === false);
                })->all();
        }

        return $languages->map(function ($name, $code) use ($defaultOtherLanguageComponentMainData, $componentMainData) {
            return $componentMainData->{$code} ?? $defaultOtherLanguageComponentMainData;
        });
    }



    private function filterContentFields($contentFields)
    {
        $contentFields = json_decode($contentFields, true);

        return array_filter($contentFields, function ($value) {
            return isset($value['type']) && $value['type'] === 'text';
        });
    }

    // private function filterComponentListContent($items)
    // {
    //     return $items->filter(function ($value) {
    //         $decodedContent = json_decode($value->content, true)[config('app.static_default_language')];

    //         return collect($decodedContent)->contains('type', 'text');
    //     })->map(function ($value) {
    //         $decodedContent = json_decode($value->content, true)[config('app.static_default_language')];
    //         $filteredContent = collect($decodedContent)->filter(function ($item) {
    //             return isset($item['type']) && $item['type'] === 'text';
    //         });

    //         return ['id' => $value->id, 'content' => $filteredContent];
    //     });
    // }

    private function filterComponentListContent($items)
    {
        $defaultLang = config('app.static_default_language', 'en');

        return $items->filter(function ($value) use ($defaultLang) {
            $contentArray = json_decode($value->content ?? '{}', true);

            // Safely check if language key exists and is an array
            if (!isset($contentArray[$defaultLang]) || !is_array($contentArray[$defaultLang])) {
                return false;
            }

            return collect($contentArray[$defaultLang])->contains('type', 'text');
        })->map(function ($value) use ($defaultLang) {
            $contentArray = json_decode($value->content ?? '{}', true);
            $langContent = $contentArray[$defaultLang] ?? [];

            $filteredContent = collect($langContent)->filter(function ($item) {
                return isset($item['type']) && $item['type'] === 'text';
            });

            return ['id' => $value->id, 'content' => $filteredContent];
        });
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ComponentService $componentService)
    {
        // dd($request->all());
        // Validate request inputs
        $validated = Validator::make($request->all(), [
            'name' => 'unique:page_components,name,' . $id,
            'icon' => 'nullable|mimes:png,jpg,jpeg,gif,svg,webp,bmp,avif',
            'preview' => 'nullable|mimes:png,jpg,jpeg,avif,webp,bmp,avif',
            'status' => 'nullable|boolean',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withInput()->with('error', $validated->errors()->first());
        }

        try {
            DB::beginTransaction(); // Begin transaction

            $component = PageComponent::findOrFail($id);
            $lang = $request->lang ?? config('app.static_default_language');
            $data = $request->except(['_token', '_method', 'status', 'name', 'lang', 'preview']);

            // Modify translation data
            $content = modify_trans_data($component->content);

            if ($component->type === 'static') {
                $modifyData = $componentService->updateDataModify($request, $data, $content, $lang);
            } else {
                $requestContent = Purifier::clean(htmlspecialchars_decode($request->input('content', '')));
                $modifyData = Arr::set($content, $lang, $requestContent);

                // Upload icon if provided
                if ($request->hasFile('icon')) {
                    $component->icon = self::uploadImage($request->file('icon'), $component->icon);
                }
            }


            // Upload preview image if provided
            if ($request->hasFile('preview')) {
                $component->preview = self::uploadImage($request->file('preview'));
            }

            // Update component details
            $component->name = $request->name ?? $component->name;
            $component->content = $modifyData;
            $component->status = ($request->filled('status') || $lang !== config('app.static_default_language')) ? 1 : 0;
            $component->save();


            DB::commit(); // Commit transaction

            return redirect()->back()->with('success', __('Component Updated Successfully'));
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on error

            Log::error('Component Update Failed: ' . $e->getMessage()); // Log error details

            return redirect()->back()->withInput()->with('error', __('Failed to update component. Please try again.'));
        }

        return redirect()->back();
    }


    public function componentFilter(Request $request)
    {
        $category = $request->category;
        $pageId = $request->page_id;
        $componentIds = json_decode($request->component_ids, true);

        $query = PageComponent::where('status', 1);

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $components = $query->get();

        $componentsAvailable = $components->reject(function ($component) use ($componentIds) {
            return in_array($component->id, $componentIds);
        })->sortBy('sort');

        return view('pagebuilder::component.partial._filter_component', compact('componentsAvailable', 'pageId'))->render();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $component = PageComponent::find($id);

        if (! $component) {
            return response()->json(['status' => 'error', 'message' => 'Component not found.'], 404);
        }

        if ($component->type !== 'dynamic') {
            return response()->json(['status' => 'error', 'message' => 'Only dynamic components can be deleted.'], 403);
        }

        // Delete icon image
        $this->deleteImage($component->icon);

        // Delete component
        $component->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Component deleted successfully.',
        ]);
    }
}
