<?php

namespace Modules\Contact\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'country' => 'nullable|string|max:255',
            'city'    => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }
}
