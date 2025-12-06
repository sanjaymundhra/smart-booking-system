<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\Service;
use App\Services\BookingAvailabilityService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingConfirmedMail;

class ProcessBookingJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(BookingAvailabilityService $availabilityService)
    {
        $data = $this->data;

        $availableSlots = collect(
            $availabilityService->getAvailableSlots($data['date'], $data['service_id'])
        )->pluck('time')->toArray();

        if (!in_array($data['start_time'], $availableSlots)) {
            info('Slot not available for booking', [
                'service_id' => $data['service_id'],
                'date' => $data['date'],
                'selected_slot' => $data['start_time'],
                'checked_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            return;
        }

        try {
            $booking = DB::transaction(function () use ($data) {

                $service = Service::find($data['service_id']);
                $start = Carbon::parse($data['date'] . ' ' . $data['start_time']);

                $isBooked = Booking::where([
                    'date' => $data['date'],
                    'time' => $start->format('H:i'),
                    'service_id' => $service->id
                ])->exists();

                if ($isBooked) { 
                    throw new \Exception("Slot became unavailable during booking attempt"); 
                }

                return Booking::create([
                    'service_id' => $service->id,
                    'date' => $data['date'],
                    'time' => $start->format('H:i'),
                    'email' => $data['email'],
                    'name' => $data['name'] ?? '',
                    'status' => 'booked',
                    'notes' => $data['notes']
                ]);
            });

        } catch (\Exception $e) {
            Log::warning('Booking failed inside transaction', [
                'error' => $e->getMessage(),
                'service_id' => $data['service_id'],
                'date' => $data['date'],
                'time' => $data['start_time'],
            ]);
            return;
        }

        try {
            Mail::to($booking->email)->send(new BookingConfirmedMail($booking));
            Log::info('Booking confirmation email sent successfully', [
                'booking_id' => $booking->id
            ]);
        } catch (\Exception $e){
            Log::error('Error in sending Booking email', [
                'booking_id' => $booking->id,
                'message' => $e->getMessage()
            ]);
        }
    }
}
