<?php

namespace Modules\Conversations\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Modules\Users\Models\User;

class Conversation extends Model
{
    protected $fillable = ['user_id', 'title', 'llm_model', 'meta'];
    protected $casts = ['meta' => 'array'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
