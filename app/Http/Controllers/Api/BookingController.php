<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookingAvailabilityService;
use App\Http\Requests\BookingRequest;
use App\Jobs\ProcessBookingJob;
use App\Models\Booking;

class BookingController extends Controller
{

    protected $availabilityService;
    
    public function __construct(BookingAvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function index()
    {
        $bookings = Booking::with('service')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ], 200);
    }


    public function store(BookingRequest $request)
    {
        $data = $request->validated();
        info('booking payload',$data);
        if (!$this->availabilityService->isSlotAvailable($data['date'], $data['start_time'], $data['service_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'Slot not available'
            ], 422);
        }

        dispatch(new ProcessBookingJob($data));

        return response()->json([
            'success' => true,
            'message' => 'Booking is being processed. You will soon get confirmation on Email.'
        ], 202);
    }
}
