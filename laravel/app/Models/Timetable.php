<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;
    /**
     * Get the treatment that belongs to the timetable.
     */
    public function treatment(){
        return $this->belongsTo('App\Models\Treatment');
    }


}
