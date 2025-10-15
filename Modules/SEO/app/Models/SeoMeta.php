<?php

namespace Modules\SEO\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ActivityLog\Traits\LogsActivity;

class SeoMeta extends Model
{
    use LogsActivity, HasFactory;

    protected $table = 'seo_meta';

    protected $fillable = ['seo_data', 'reference_model', 'reference_id'];

    protected $casts = [
        'seo_data' => 'array',
    ];

    public function reference()
    {
        return $this->morphTo(__FUNCTION__, 'reference_model', 'reference_id');
    }

    public static function updateOrCreateFor($model, array $seoFields)
    {
        return self::updateOrCreate(
            [
                'reference_model' => $model::class,
                'reference_id' => $model->getKey()
            ],
            [
                'seo_data' => $seoFields
            ]
        );
    }

    public static function getFor($model)
    {
        return self::where('reference_model', $model::class)
            ->where('reference_id', $model->getKey())
            ->first();
    }
}
