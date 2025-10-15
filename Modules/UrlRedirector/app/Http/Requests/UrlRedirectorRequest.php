<?php

namespace Modules\UrlRedirector\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UrlRedirectorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $urlredirector = $this->route('urlredirector');

        return [
            'original_url' => [
                'required',
                'max:255',
                'url',
                Rule::unique('url_redirects', 'original_url')
                    ->ignore($urlredirector?->id),
            ],
            'target_url' => [
                'required',
                'max:255',
                'url',
                'different:original_url',
            ],
            'is_active' => ['required', 'boolean'],
            'expires_at' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'original_url.required' => 'The original URL is required.',
            'original_url.url'      => 'The original URL must be valid.',
            'original_url.unique'   => 'This original URL already exists.',
            'target_url.required'   => 'The target URL is required.',
            'target_url.url'        => 'The target URL must be valid.',
            'target_url.different'  => 'The target URL must be different from the original URL.',
        ];
    }
}
