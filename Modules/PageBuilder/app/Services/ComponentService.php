<?php

namespace Modules\PageBuilder\Services;

use Illuminate\Support\Arr;
use Mews\Purifier\Facades\Purifier;
use Modules\Language\Models\Language;
use Modules\PageBuilder\Models\ComponentContent;
use Modules\PageBuilder\Models\PageComponent;
use Modules\PageBuilder\Traits\FileManageTrait;

class ComponentService
{
    use FileManageTrait;

    /**
     * Update and modify the data based on the provided request and old data.
     *
     * @param  mixed  $request  The request object
     * @param  array  $requestData  The data to be modified
     * @param  array  $oldData  The original data
     * @return array|bool|string
     */
    public function updateDataModify($request, array $requestData, array $oldData, $lang)
    {
        $modifyData = $oldData;

        $defaultOtherLanguageComponentMainData = collect($modifyData[config('app.static_default_language')] ?? $modifyData)
            ->reject(function ($item) {
                return isset($item['type']) && $item['type'] === 'img' || isset($item['trans']) && $item['trans'] === false;
            });

        $specificLangModifyData = Arr::get($oldData, $lang, $defaultOtherLanguageComponentMainData->all());

        foreach ($requestData as $key => $value) {
            if ($request->hasFile($key)) {

                $value = self::uploadImage($value, Arr::get($modifyData[config('app.static_default_language')] ?? $modifyData, "$key.value", ''));
            }

            if ($value === 'coevs-remove') {
                $oldValue = Arr::get($modifyData[config('app.static_default_language')] ?? $modifyData, "$key.value", '');
                self::deleteImage($oldValue);
                $value = null;
            }

            if (Arr::get($specificLangModifyData, "$key.type") === 'rich_text') {
                $value = Purifier::clean(htmlspecialchars_decode($value));
            }

            $specificLangModifyData[$key] = [
                'type' => Arr::get($specificLangModifyData, "$key.type"),
                'value' => $value,
                'class' => Arr::get($specificLangModifyData, "$key.class"),
            ];
        }

        Arr::set($modifyData, $lang, $specificLangModifyData);
        if (! is_null($lang)) {
            return json_encode($modifyData);
        }

        return $modifyData;
    }

    public static function getComponent($componentIds)
    {

        $lang = session('locale') ?? config('app.locale');
        $languages = Language::where('status', 1)->pluck('name', 'short_code');
        $modifyContent = function ($content, $languages, $enContent, $lang) {
            $modifiedContent = $languages->map(function ($name, $code) use ($content, $enContent) {
                $merged = array_merge((array) $enContent, (array) ($content->$code ?? []));

                return (object) $merged;
            });

            return $modifiedContent[$lang] ?? $enContent;
        };

        $modifyItems = function ($items, $languages, $lang) use ($modifyContent) {
            return $items->map(function ($item) use ($languages, $lang, $modifyContent) {
                $content = json_decode($item->content);
                $enContent = $content->en;
                $item->content = $modifyContent($content, $languages, $enContent, $lang);

                return $item;
            });
        };

        return PageComponent::with('items')
            ->whereIn('id', $componentIds)
            ->orderByRaw('FIELD(id, ' . implode(',', $componentIds) . ')')
            ->get(['id', 'content_id', 'section', 'content'])
            ->map(function ($data) use ($languages, $lang, $modifyContent, $modifyItems) {
                // Modify content
                $content = json_decode($data->content);

                $enContent = $content->en;
                $data->content = $modifyContent($content, $languages, $enContent, $lang);

                if ($data->section === 'dynamic') {
                    $data->content = $content->$lang ?? $enContent;
                }

                if ($data->content_id !== null) {
                    $data->items = ComponentContent::where('component_id', $data->content_id)->get();
                }

                // Modify items
                $data->items = $modifyItems($data->items, $languages, $lang);

                return $data;
            });
    }
}
