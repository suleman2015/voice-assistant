<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            // Basic info
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                Rule::unique('posts', 'slug')->ignore(optional($this->route('post'))->id),
            ],
            'description' => 'nullable|string|max:1000',
            'content' => 'nullable|string',

            // Links
            'apple_link' => 'nullable|url|max:255',
            'spotify_link' => 'nullable|url|max:255',
            'yt_link' => 'nullable|url|max:255',

            // Doctor info
            'dr_name' => 'nullable|string|max:255',
            'dr_image' => 'nullable|string',

            // Key points
            'key_points' => 'nullable|array',
            'key_points.*' => 'nullable|string|max:255',

            // Flags
            'is_featured' => 'required|boolean',
            'is_trending_onc_update' => 'required|boolean',

            // Status & type
            'status' => 'nullable|in:published,draft,pending,scheduled',
            'type' => 'nullable|in:post,blog,article',

            // Author
            'author_name' => 'nullable|string|max:255',

            // Relations
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags'   => ['nullable', 'array'],
            'tags.*' => ['nullable', 'string', 'max:100'],

            // Main images
            'image' => 'nullable|string',
        ];

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
