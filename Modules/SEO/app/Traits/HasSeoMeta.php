<?php

namespace Modules\SEO\Traits;

use Illuminate\Support\Facades\File;
use Modules\SEO\Models\SeoMeta;

trait HasSeoMeta
{
    public function seoMeta()
    {
        return $this->hasOne(SeoMeta::class, 'reference_id')
            ->where('reference_model', static::class);
    }

    public function getSeoField(string $key)
    {
        return optional($this->seoMeta)->seo_data[$key] ?? null;
    }

    /**
     * Save SEO data and handle direct image upload/removal
     */
    public function setSeoData(array $fields)
    {
        // ✅ Decode keywords and schema if JSON strings
        foreach (['meta_keywords', 'schema'] as $key) {
            if (isset($fields[$key]) && is_string($fields[$key])) {
                $decoded = json_decode($fields[$key], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    if ($key === 'meta_keywords') {
                        $fields[$key] = collect($decoded)->pluck('value')->filter()->values()->toArray();
                    } else {
                        $fields[$key] = $decoded;
                    }
                }
            }
        }

        $existingMeta = $this->seoMeta()->first();
        $existingSeoData = $existingMeta?->seo_data ?? [];

        // 🟢 If a new image is uploaded
        if (request()->hasFile('seo_image_file')) {
            $file = request()->file('seo_image_file');

            // Delete old image if exists
            if (!empty($existingSeoData['seo_image']) && File::exists(public_path($existingSeoData['seo_image']))) {
                File::delete(public_path($existingSeoData['seo_image']));
            }

            // Make sure folder exists
            $uploadPath = public_path('uploads/seo');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Generate unique name
            $filename = uniqid('seo_') . '.' . $file->getClientOriginalExtension();

            // Move file to /public/uploads/seo
            $file->move($uploadPath, $filename);

            // Save relative path
            $fields['seo_image'] = 'uploads/seo/' . $filename;
        } else {
            // 🟡 If image removed
            if (empty($fields['seo_image']) && !empty($existingSeoData['seo_image'])) {
                if (File::exists(public_path($existingSeoData['seo_image']))) {
                    File::delete(public_path($existingSeoData['seo_image']));
                }
                $fields['seo_image'] = null;
            } else {
                // Keep existing image if not changed
                $fields['seo_image'] = $existingSeoData['seo_image'] ?? null;
            }
        }

        // 🔵 Create or update SeoMeta
        SeoMeta::updateOrCreate(
            [
                'reference_model' => static::class,
                'reference_id'    => $this->getKey(),
            ],
            [
                'seo_data' => $fields,
            ]
        );
    }
}
