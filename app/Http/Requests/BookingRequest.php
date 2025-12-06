<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'notes' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'date.after_or_equal' => 'Booking date must be today or in the future.',
            'service_id.exists' => 'Selected service does not exist.',
            'email.email' => 'Please provide a valid email address.'
        ];
    }
}