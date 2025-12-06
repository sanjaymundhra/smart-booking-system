<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\WorkingTime;

class HairServiceSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed services

        $services = [];
        $services[] = Service::create([
            'name' => 'Haircut',
            'duration_minutes' => 30,
            'price' => 50.00,
            'description' => 'Professional haircut service'
        ]);
        
        $services[] = Service::create([
            'name' => 'Hair Coloring',
            'duration_minutes' => 60,
            'price' => 100.00,
            'description' => 'Full hair coloring service'
        ]);
        
        $services[] = Service::create([
            'name' => 'Hair Styling',
            'duration_minutes' => 45,
            'price' => 60.00,
            'description' => 'Professional styling for special occasions'
        ]);
        
        for ($day = 1; $day <= 5; $day++) {
            forEach($services as $service) {
                WorkingTime::create([
                    'service_id' => $service->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00',
                    'end_time' => '17:00',
                    'slot_interval_minutes' => $service->duration_minutes
                ]);
            }            
        }
    }
}
