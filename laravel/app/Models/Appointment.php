<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * Get the treatments for the appointment.
     */
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class);
    }

}
