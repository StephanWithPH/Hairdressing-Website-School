<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    public function get(Request $request){
        $treatment = Treatment::find($request->id);
        $timetables = $treatment->timetables()->get()->groupBy('day')->toArray();
        return response()->json($timetables);
    }

    public function getTimes(Request $request){
        $dateArray = explode("-", $request->date);
        $day = strtolower(Carbon::createFromDate($dateArray[0], $dateArray[1], $dateArray[2])->format('l'));

        $treatment = Treatment::find($request->id);
        $timetabletimes = $treatment->timetables()->where('day', $day)->get()->toArray();

        return response()->json($timetabletimes);
    }
}
