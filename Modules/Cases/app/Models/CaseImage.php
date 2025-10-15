<?php

namespace Modules\Cases\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CaseImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'file_path',
        'image_type',
        'date_taken',
    ];

    protected $casts = [
        'date_taken' => 'date',
    ];

    public function case()
    {
        return $this->belongsTo(UserCase::class, 'case_id');
    }
}
