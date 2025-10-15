<?php

namespace Modules\Events\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust if you want authorization logic
    }

    public function rules(): array
    {
        $eventId = $this->route('id') ?? null;

        return [
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:events,slug,' . $eventId,
            'event_date'  => 'nullable|date',
            'description' => 'nullable|string',
            'link'        => 'nullable|url',
            'image_url'   => 'nullable|string',
            'status'      => 'required|in:draft,published',
            'images.*'    => 'nullable|string',
            'event_dates.*.name' => 'nullable|string',
            'event_dates.*.date' => 'nullable|date',
            'event_dates.*.link' => 'nullable|url',
        ];
    }
}
