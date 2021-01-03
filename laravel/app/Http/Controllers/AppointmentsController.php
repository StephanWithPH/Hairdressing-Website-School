<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Timetable;
use App\Models\Treatment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentsController extends Controller
{
    public function get(Request $request){
        $treatment = Treatment::find($request->id);
        $timetables = $treatment->timetables()->get()->groupBy('day')->toArray();
        return response()->json($timetables);
    }

    public function getTimes(Request $request){
        $dateArray = explode("-", $request->date);
        $dateCarbon = Carbon::createFromDate($dateArray[0], $dateArray[1], $dateArray[2]);
        $day = strtolower($dateCarbon->format('l'));

        $treatment = Treatment::find($request->id);
        $timetabletimes = $treatment->timetables()->where('day', $day)->get();
        $timetabletimesMap = $timetabletimes->filter(function ($item) use ($dateCarbon){
            if (Appointment::where('date', $dateCarbon->format('Y-m-d'))->where('time_from', $item->time_from)->where('time_until', $item->time_until)->count() < User::count()){
                return $item;
            }
        });

        return response()->json($timetabletimesMap->toArray());
    }

    public function submitAppointment(Request $request){
        $validator = Validator::make($request->all(), [
            'appointmentmoment' => ['required', 'max:255'],
            'appointmenttime' => ['required'],
            'firstname' => ['required', 'max:40', 'string'],
            'lastname' => ['required', 'max:40', 'string'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required'],
            'treatments' => ['required']
        ]);

        if ($validator->fails()) {
            flash(__('Er is iets mis gegaan bij het maken van de afspraak. Probeer het later opnieuw!'))->error();
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $treatment = Treatment::find($request->treatments);
        $timetable = Timetable::find($request->appointmenttime);

        $appointment = new Appointment();
        $appointment->firstname = $request->firstname;


        // Generate unique hash for appointment and check if there are duplicates
        $duplicates = true;
        while($duplicates){
            $hash = $this->generateHash();
            if (!$this->checkHashDuplicate($hash)){
                $duplicates = false;
                $appointment->hash = $hash;
            }
        }
        $appointment->lastname = $request->lastname;
        $appointment->email = $request->email;
        $appointment->phone = $request->phone["full"];
        $appointment->date = Carbon::createFromFormat('d/m/Y', $request->appointmentmoment);
        $appointment->time_from = $timetable->time_from;
        $appointment->time_until = $timetable->time_until;
        $appointment->save();
        $appointment->treatments()->attach($treatment);


        flash(__('Uw afspraak is succesvol gemaakt. Een bevestiging is gestuurd naar uw email adres en telefoonnummer'))->success();
        return redirect()->back();
    }

    public function generateHash(){
        return sha1(time());
    }

    public function checkHashDuplicate($hashparam){
        $duplicatecount = Appointment::where('hash', $hashparam)->count();
        if ($duplicatecount == 0){
            return false;
        }
        else {
            return true;
        }
    }

    public function loadEditAppointmentPage($id){
        $appointment = Appointment::find($id);
        return view('pages.dashboard.editAppointment', compact('appointment'));
    }
}
