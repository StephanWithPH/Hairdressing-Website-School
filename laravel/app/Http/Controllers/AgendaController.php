<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function loadAgendaPage(){
        return view('pages.dashboard.agenda');
    }
}
