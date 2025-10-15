<?php

namespace Modules\PageBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Language\Models\Language;
use Modules\PageBuilder\Models\ComponentContent;
use Modules\PageBuilder\Models\PageComponent;
use Modules\PageBuilder\Services\ComponentService;
use Modules\PageBuilder\Traits\FileManageTrait;

class PageComponentItemController extends Controller
{
    use FileManageTrait;
    
    public function create(Request $request)
    {

        $componentId = $request->component_id;
        $component = PageComponent::find($componentId);

        $fields = json_decode($component->content_fields);

        return view('pagebuilder::component.item.create', compact('fields', 'componentId'));
    }

    public function store(Request $request, ComponentService $componentService)
    {
        $validatedData = Validator::make($request->all(), [
            'component_id' => 'required',
            'fields' => 'required',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withInput()->with('error', $validatedData->errors()->first());
        }

        try {
            DB::beginTransaction();

            $input = $validatedData->getData();

            $componentId = $request->component_id;
            $fieldData = (array) json_decode($input['fields'], true);
            $filteredRequestData = Arr::except($input, ['_token', 'component_id', 'fields', 'files']);

            $modifyData = $componentService->updateDataModify($request, $filteredRequestData, $fieldData, null);

            $componentContent = new ComponentContent;
            $componentContent->component_id = $componentId;
            $componentContent->content = json_encode([config('app.static_default_language') => $modifyData]);

            $componentContent->save();

            DB::commit();

            return redirect()->back()->with('success', __('Page Component Item Created Successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Component Content Creation Failed: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', __('Failed to create component item. Please try again.'));
        }

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $componentContent = ComponentContent::findOrFail($id);
        $data = json_decode($componentContent->content);

        $languages = Language::where('status', 1)->pluck('name', 'short_code');
        $defaultOtherLanguageComponentMainData = collect($data->en)->reject(function ($item) {
            return isset($item->type) && $item->type === 'img' || isset($item->trans) && $item->trans === false;
        })->all();

        $modifiedData = $languages->map(function ($name, $code) use ($defaultOtherLanguageComponentMainData, $data) {
            return $data->$code ?? $defaultOtherLanguageComponentMainData;
        });

        $componentId = $componentContent->component_id;

        if (request()->ajax()) {
            return view('pagebuilder::component.partial._edit_item', compact('modifiedData', 'id', 'languages'))->render();
        }

        return view('pagebuilder::component.item.edit', compact('modifiedData', 'id', 'componentId', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ComponentService $componentService)
    {
        $requestData = $request->except(['_token', '_method', 'files', 'lang']);
        $lang = $request->lang;

        try {
            DB::beginTransaction();

            $component = ComponentContent::find($id);
            if (! $component) {
                throw new \Exception('Component not found.');
            }

            $oldData = modify_trans_data($component->content);
            $modifyData = $componentService->updateDataModify($request, $requestData, $oldData, $lang);

            $component->content = $modifyData;

            $component->save();

            DB::commit();

            return redirect()->back()->with('success', __('Page Component Item Updated Successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Component Update Failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', __('Failed to update component item. Please try again.'));
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $component = ComponentContent::find($id);
        $items = json_decode($component->content, true)[config('app.static_default_language')];
        foreach ($items as $item) {
            if ($item['type'] == 'img') {
                $this->deleteImage($item['value'] ?? '');
            }
        }
        $component->delete();

        return response(['status' => 'success', 'message' => __('Page Component Item Deleted Successfully')], 200);
    }
}
