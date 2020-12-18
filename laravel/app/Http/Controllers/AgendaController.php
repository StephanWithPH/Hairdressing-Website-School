<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function loadAgendaPage(){
        $appointments = Appointment::all();
        return view('pages.dashboard.agenda', compact('appointments'));
    }
}
