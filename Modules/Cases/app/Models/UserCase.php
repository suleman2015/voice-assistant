<?php

namespace Modules\Cases\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCase extends Model
{
    use HasFactory;

    protected $table = 'cases';

    protected $fillable = [
        'name',
        'is_anonymous',
        'profession',
        'specialty',
        'case_date',
        'description',
        'terms_agreed',
        'status',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'terms_agreed' => 'boolean',
        'case_date' => 'date',
    ];

    public function images()
    {
        return $this->hasMany(CaseImage::class, 'case_id');
    }
}
