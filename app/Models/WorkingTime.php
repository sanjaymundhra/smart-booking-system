<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingTime extends Model
{
    use HasFactory;

     protected $fillable = [
        'service_id',
        'day_of_week',
        'date',
        'start_time',
        'end_time',
        'slot_interval_minutes',
        'notes',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getStartTimeAttribute($value)
    {
        return substr($value, 0, 5);
    }

    public function getEndTimeAttribute($value)
    {
        return substr($value, 0, 5);
    }
}
