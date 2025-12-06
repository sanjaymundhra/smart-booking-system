<?php

namespace App\Services;

use App\Models\WorkingTime;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BookingAvailabilityService
{
    public function getAvailableSlots(string $date, int $serviceId): array
    {
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = $carbonDate->dayOfWeek;

        $dateRules = WorkingTime::where([
                'date' => $carbonDate->format('Y-m-d'),
                'service_id' => $serviceId
            ])->get();

        if ($dateRules->isNotEmpty()) {
            $workingHours = $dateRules;
        } else {
            $workingHours = WorkingTime::where([
                'day_of_week' => $dayOfWeek,
                'service_id' => $serviceId
            ])->get();
        }
            
        if ($workingHours->isEmpty()) {
            return [];
        }
        Log::info('service Id', [$serviceId]);
        $service = Service::findOrFail($serviceId);
        $serviceDuration = $service->duration_minutes;
        
        $existingBookings = Booking::where([
            'date' => $date,
            'service_id' => $service->id
            ])
            ->pluck('time')
            ->toArray();
        
        Log::info('existing bookings', [$existingBookings]);
        $availableSlots = [];
        
        foreach ($workingHours as $workingHour) {
            Log::info('$workingHour->slot_interval_minutes', [$workingHour->slot_interval_minutes]);
            $slots = $this->generateSlots(
                $workingHour->start_time,
                $workingHour->end_time,
                $workingHour->slot_interval_minutes,                
                $serviceDuration,
                $existingBookings,
                $carbonDate
            );
            
            $availableSlots = array_merge($availableSlots, $slots);
        }
        
        return $availableSlots;
    }
    
    private function generateSlots(
        string $startTime,
        string $endTime,
        int $slotDuration,
        int $serviceDuration,
        array $existingBookings,
        Carbon $date
    ): array {
        $slots = [];
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);
        $now = Carbon::now();
        Log::info('slot duration', [$slotDuration]);
        while ($start->copy()->addMinutes($serviceDuration) <= $end) {
            $slotTime = $start->format('H:i');
            $slotDateTime = $date->copy()->setTimeFromTimeString($slotTime);
            
            if ($slotDateTime <= $now) {
                $start->addMinutes($slotDuration);
                continue;
            }
            
            $slots[] = [
                'time' => $slotTime,
                'available' => !in_array($slotTime, $existingBookings)
            ];
            
            $start->addMinutes($slotDuration);
        }
        
        return $slots;
    }

    public function isSlotAvailable(string $date, string $startTime, int $serviceId): bool
    {
        $service = Service::findOrFail($serviceId);
        $duration = $service->duration_minutes;

        $start = Carbon::parse("$date $startTime");
        $end   = $start->copy()->addMinutes($duration);

        $bookings = Booking::where([
            'date' => $date,
            'service_id' => $serviceId           
        ])->get();

        foreach ($bookings as $booking) {
            $bookedStart = Carbon::parse("$date {$booking->time}");
            $bookedEnd = $bookedStart->copy()->addMinutes($duration);

            if ($start < $bookedEnd && $end > $bookedStart) {
                Log::info('when is it rejected', [$start, $bookedEnd, $end, $bookedStart]);
                return false;
            }
        }

        return true;
    }
}
