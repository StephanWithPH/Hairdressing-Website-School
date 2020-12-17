<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Treatment;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    public function get(Request $request){
        $treatment = Treatment::find($request->id);
        $timetables = $treatment->timetables()->get()->groupBy('day')->toArray();
        return response()->json($timetables);
    }
}
