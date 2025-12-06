<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BookingAvailabilityService;

class BookingAvailabilityController extends Controller
{
    public function index(Request $request, BookingAvailabilityService $availability)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'service_id' => 'required|exists:services,id'
        ]);

        return [
            'slots' => $availability->getAvailableSlots($data['date'], $data['service_id'])
        ];
    }
}
