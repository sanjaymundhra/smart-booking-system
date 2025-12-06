<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

     protected $fillable = [
        'service_id',
        'date',
        'time',
        'email',
        'name',
        'status',
        'notes',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getTimeAttribute($value)
    {
        return substr($value, 0, 5);
    }
}
