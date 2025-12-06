<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkingTimeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'day_of_week' => 'required_without:date|nullable|integer|min:0|max:6',
            'date' => 'required_without:day_of_week|nullable|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_interval_minutes' => 'required|integer|in:15,30,45,60',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'end_time.after' => 'End time must be after start time.',
            'day_of_week.between' => 'Day of week must be between 0 (Sunday) and 6 (Saturday).'
        ];
    }
}
