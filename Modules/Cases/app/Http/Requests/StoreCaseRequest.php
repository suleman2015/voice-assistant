<?php

namespace Modules\Cases\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Common / header fields (apply to all cases being created)
            'name'          => 'nullable|string|max:255',
            'is_anonymous'  => 'boolean',
            'profession'    => 'required|string|max:150',

            // You can send ONE case via these single fields:
            'specialty'     => 'nullable|string|max:150|required_without:speciality',
            'description'   => 'nullable|string|min:20|required_without:content',

            // Or send MULTIPLE cases via these array fields (the form uses these):
            'speciality'    => 'nullable|array|required_without:specialty|min:1',
            'speciality.*'  => 'nullable|string|max:150',
            'content'       => 'nullable|array|required_without:description|min:1',
            'content.*'     => 'nullable|string|min:20',

            // Optional per-request date (you can also ignore for multi)
            'case_date'     => 'nullable|date',

            // Accept terms (kept exactly as your logic)
            'terms_agreed'  => 'nullable|boolean|in:1',

            // Optional images (kept as-is)
            'images'        => 'nullable|array',
            'images.*'      => 'file|mimes:jpg,jpeg,png|max:5120',
            'image_types'   => 'nullable|array',
            'image_types.*' => 'nullable|string|max:150',
            'dates_taken'   => 'nullable|array',
            'dates_taken.*' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'terms_agreed.in'            => 'You must agree to the terms and conditions.',
            'specialty.required_without' => 'Please provide at least one case (single specialty or speciality[]).',
            'description.required_without' => 'Please provide description or content[] for at least one case.',
            'speciality.required_without' => 'Please provide at least one case (speciality[] or single specialty).',
            'content.required_without'   => 'Please provide description or content[] for at least one case.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => false,
            'message' => 'Validation failed.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
