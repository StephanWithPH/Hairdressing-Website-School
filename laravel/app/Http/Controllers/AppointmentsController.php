<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentMailer;
use App\Models\Appointment;
use App\Models\Timetable;
use App\Models\Treatment;
use App\Models\User;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use MessageBird;

class AppointmentsController extends Controller
{
    /* Api get request function for makeappointment modal to request all of the available weekdays for a treatment. */
    public function get(Request $request){
        /* Find treatment */
        $treatment = Treatment::find($request->id);
        /* Get timetables grouped by week day */
        $timetables = $treatment->timetables()->get()->groupBy('day')->toArray();
        return response()->json($timetables);
    }

    /* Api get request function for makeappointment modal to request all of the available times for a treatment with a selected date. */
    public function getTimes(Request $request){
        /* Explode incoming date into array */
        $dateArray = explode("-", $request->date);
        /* Create Carbon class from date */
        $dateCarbon = Carbon::createFromDate($dateArray[0], $dateArray[1], $dateArray[2]);
        /* Create new variable and format carbon date to full day */
        $day = strtolower($dateCarbon->format('l'));

        /* Find treatment with incoming id */
        $treatment = Treatment::find($request->id);
        /* Get the timetables that belong to the treatment with the incoming day. */
        $timetabletimes = $treatment->timetables()->where('day', $day)->get();
        /* Filter through the items and only return items when the reservation time is not fully booked by other persons. */
        $timetabletimesMap = $timetabletimes->filter(function ($item) use ($dateCarbon){
            if (Appointment::where('date', $dateCarbon->format('Y-m-d'))->whereBetween('time_from', [$item->time_from, $item->time_until])->count() < User::count()){
                return $item;
            }
        });

        return response()->json($timetabletimesMap->toArray());
    }

    /* Load page for customers to edit appointment */
    public function loadEditAppointmentPage($hash){
        $appointment = Appointment::where('hash', $hash)->first();
        if ($appointment){
            return view('pages.appointment', compact('appointment'));
        }
        else {
            flash(__('Deze afspraak bestaat niet. Mogelijk is deze al geannuleerd of heeft u geklikt op een ongeldige link. Voor vragen, neem contact op.'))->error();
            return redirect()->route('home');
        }
    }

    /* Function executed when a customer deletes their own appointment */
    public function deleteAppointment($hash){
        $appointment = Appointment::where('hash', $hash)->first();
        /* If sms is enabled, send sms */
        if (env('SMS_ENABLED')){
            $smsMessage = new SmsMessage();
            $smsMessage->originator = env('SMS_NAME');
            $smsMessage->recipients = [ $appointment->phone ];
            $smsMessage->body = __('Beste :firstname, uw afspraak bij :name is geannuleerd. U kunt deze afspraak niet meer bekijken.',['firstname' => $appointment->firstname, 'name' => env('APP_NAME')]);
            $smsMessage->send();
        }
        /* If mail is enabled, send maill */
        if(env('MAIL_ENABLED')) Mail::to($appointment->email)->send(new AppointmentMailer($appointment, "cancelled"));

        /* Various checks to check what message to display */
        if (!env('MAIL_ENABLED') && !env('SMS_ENABLED')) {
            flash(__('De afspraak is succesvol geannuleerd.'))->success();
        }
        else if(env('MAIL_ENABLED') && !env('SMS_ENABLED')){
            flash(__('De afspraak is succesvol geannuleerd. Een bevestiging is gestuurd naar het email adres'))->success();
        }
        else if (!env('MAIL_ENABLED') && env('SMS_ENABLED')){
            flash(__('De afspraak is succesvol geannuleerd. Een bevestiging is gestuurd naar het telefoonnummer'))->success();
        }
        else {
            flash(__('De afspraak is succesvol geannuleerd. Een bevestiging is gestuurd naar het email adres en telefoonnummer'))->success();
        }
        $appointment->delete();
        return redirect()->route('home');
    }

    /* Function executed when customer submits appointment edit */
    public function submitAppointmentEdit(Request $request){
        /* Validate form fields */
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required'],
            'comments' => ['max:300'],
        ]);

        /* If validator fails, return error message */
        if ($validator->fails()) {
            flash(__('Er is iets mis gegaan bij het maken van de afspraak. Probeer het later opnieuw!'))->error();
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        /* Create new appointment and fill all fields below*/
        $appointment = Appointment::where('hash', $request->appointment_hash)->first();
        $appointment->email = $request->email;
        $appointment->phone = $request->phone["full"];
        $appointment->comments = !empty($request->comments) ? $request->comments : null;

        /* Do a lot of checks if treatments are submitted, if it is only one treatment and check if the time is submitted */
        if ($request->appointmentmoment && $request->treatments && $request->treatmentanddatechange == "true" && $request->appointmenttime && $appointment->treatments()->count() < 2){
            /* Fill in date, but first create Carbon class to make sure the variable is saved in the correct format */
            $appointment->date = Carbon::createFromFormat('d/m/Y', $request->appointmentmoment);
            /* Find timetable by incoming timetable id */
            $timetable = Timetable::find($request->appointmenttime);
            /* Fill in values */
            $appointment->time_from = $timetable->time_from;
            $appointment->time_until = $timetable->time_until;

            /* Find treatment by incoming id */
            $treatment = Treatment::find($request->treatments);
            /* Attach incoming treatment to the appointment. */
            $appointment->treatments()->detach();
            $appointment->treatments()->attach($treatment);
        }
        $appointment->save();

        /* If sms is enabled, send sms */
        if (env('SMS_ENABLED')){
            $smsMessage = new SmsMessage();
            $smsMessage->originator = env('SMS_NAME');
            $smsMessage->recipients = [ $request->phone["full"] ];
            $smsMessage->body = __('Beste :firstname, uw afspraak bij :name is gewijzigd. Voor het bekijken en wijzigen van uw afspraak kunt u op de volgende link klikken. :link',['firstname' => $request->firstname, 'name' => env('APP_NAME'), 'link' => route('editappointment', $appointment->hash)]);
            $smsMessage->send();
        }
        /* If mail is enabled, send mail */
        if(env('MAIL_ENABLED')) Mail::to($appointment->email)->send(new AppointmentMailer($appointment, "changed"));

        /* Various checks to check what message to display */
        if (!env('MAIL_ENABLED') && !env('SMS_ENABLED')) {
            flash(__('De afspraak is succesvol bijgewerkt.'))->success();
        }
        else if(env('MAIL_ENABLED') && !env('SMS_ENABLED')){
            flash(__('De afspraak is succesvol bijgewerkt. Een bevestiging is gestuurd naar het email adres'))->success();
        }
        else if (!env('MAIL_ENABLED') && env('SMS_ENABLED')){
            flash(__('De afspraak is succesvol bijgewerkt. Een bevestiging is gestuurd naar het telefoonnummer'))->success();
        }
        else {
            flash(__('De afspraak is succesvol bijgewerkt. Een bevestiging is gestuurd naar het email adres en telefoonnummer'))->success();
        }
        return redirect()->back();
    }

    /* Function executed when makeappointment modal is submitted */
    public function submitAppointment(Request $request){
        /* Validate form fields */
        $validator = Validator::make($request->all(), [
            'appointmentmoment' => ['required', 'max:255'],
            'appointmenttime' => ['required'],
            'firstname' => ['required', 'max:40', 'string'],
            'lastname' => ['required', 'max:40', 'string'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required'],
            'comments' => ['max:300'],
            'treatments' => ['required']
        ]);

        /* If validator fails, return error message */
        if ($validator->fails()) {
            flash(__('Er is iets mis gegaan bij het maken van de afspraak. Probeer het later opnieuw!'))->error();
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        /* Find treatment by incoming id */
        $treatment = Treatment::find($request->treatments);
        /* Find timetable by incoming timetable id */
        $timetable = Timetable::find($request->appointmenttime);

        /* Create new appointment and fill all fields below*/
        $appointment = new Appointment();
        /* Generate unique hash for appointment and check if there are duplicates */
        $duplicates = true;
        while($duplicates){
            $hash = $this->generateHash();
            if (!$this->checkHashDuplicate($hash)){
                $duplicates = false;
                $appointment->hash = $hash;
            }
        }
        $appointment->firstname = $request->firstname;
        $appointment->lastname = $request->lastname;
        $appointment->email = $request->email;
        $appointment->phone = $request->phone["full"];
        /* Fill in date, but first create Carbon class to make sure the variable is saved in the correct format */
        $appointment->date = Carbon::createFromFormat('d/m/Y', $request->appointmentmoment);
        $appointment->time_from = $timetable->time_from;
        $appointment->time_until = $timetable->time_until;
        $appointment->comments = !empty($request->comments) ? $request->comments : null;
        $appointment->save();
        /* Attach incoming treatment to the appointment. */
        $appointment->treatments()->attach($treatment);

        /* If sms is enabled, send sms */
        if (env('SMS_ENABLED')){
            $smsMessage = new SmsMessage();
            $smsMessage->originator = env('SMS_NAME');
            $smsMessage->recipients = [ $request->phone["full"] ];
            $smsMessage->body = __('Beste :firstname, uw afspraak bij :name is aangemaakt. Voor het bekijken en wijzigen van uw afspraak kunt u op de volgende link klikken. :link',['firstname' => $request->firstname, 'name' => env('APP_NAME'), 'link' => route('editappointment', $appointment->hash)]);
            $smsMessage->send();
        }
        /* If mail is enabled, send mail */
        if(env('MAIL_ENABLED')) Mail::to($appointment->email)->send(new AppointmentMailer($appointment, "created"));

        /* Various checks to check what message to display */
        if (!env('MAIL_ENABLED') && !env('SMS_ENABLED')) {
            flash(__('De afspraak is succesvol gemaakt.'))->success();
        }
        else if(env('MAIL_ENABLED') && !env('SMS_ENABLED')){
            flash(__('De afspraak is succesvol gemaakt. Een bevestiging is gestuurd naar het email adres'))->success();
        }
        else if (!env('MAIL_ENABLED') && env('SMS_ENABLED')){
            flash(__('DE afspraak is succesvol gemaakt. Een bevestiging is gestuurd naar het telefoonnummer'))->success();
        }
        else {
            flash(__('De afspraak is succesvol gemaakt. Een bevestiging is gestuurd naar het email adres en telefoonnummer'))->success();
        }
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

    /* Load appointments (agenda) page for employees and owner */
    public function loadAppointmentsPage(){
        $appointments = Appointment::all();
        return view('pages.dashboard.appointments', compact('appointments'));
    }

    /* Load page for admins to edit appointment */
    public function loadEditAppointmentPageAdmin($id){
        $appointment = Appointment::find($id);
        return view('pages.dashboard.appointment', compact('appointment'));
    }

    /* Function executed when an employee or owner edits an appointment */
    public function submitAppointmentAdmin(Request $request){
        $validator = Validator::make($request->all(), [
            'appointmentmoment' => ['required', 'max:255'],
            'timefrom' => ['required'],
            'timeuntil' => ['required'],
            'comments' => ['max:300'],
            'firstname' => ['required', 'max:40', 'string'],
            'lastname' => ['required', 'max:40', 'string'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required'],
            'treatments' => ['required']
        ]);

        if ($validator->fails()) {
            flash(__('Er is iets mis gegaan bij het bijwerken van de afspraak. Probeer het later opnieuw!'))->error();
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $appointment = Appointment::find($request->appointment_id);
        $appointment->firstname = $request->firstname;
        $appointment->lastname = $request->lastname;
        $appointment->email = $request->email;
        $appointment->phone = $request->phone['full'];
        $appointment->time_from = $request->timefrom;
        $appointment->time_until = $request->timeuntil;
        $appointment->comments = !empty($request->comments) ? $request->comments : null;
        $appointment->date = Carbon::createFromFormat('d/m/Y', $request->appointmentmoment);
        $appointment->treatments()->detach();
        if (is_array($request->treatments)) {
            foreach ($request->treatments as $item) {
                $treatment = Treatment::find($item);
                $appointment->treatments()->attach($treatment);
            }
        }
        else{
            $treatment = Treatment::find($request->treatments);
            $appointment->treatments()->attach($treatment);
        }
        $appointment->save();
        /* If sms is enabled, send sms */
        if (env('SMS_ENABLED')){
            $smsMessage = new SmsMessage();
            $smsMessage->originator = env('SMS_NAME');
            $smsMessage->recipients = [ $request->phone["full"] ];
            $smsMessage->body = __('Beste :firstname, uw afspraak bij :name is gewijzigd. Bekijk of verander uw wijzigingen via de volgende link. :link',['firstname' => $request->firstname, 'name' => env('APP_NAME'), 'link' => route('editappointment', $appointment->hash)]);
            $smsMessage->send();
        }
        /* If mail is enabled, send mail */
        if(env('MAIL_ENABLED')) Mail::to($appointment->email)->send(new AppointmentMailer($appointment, "changed"));

        /* Various checks to check what message to display */
        if (!env('MAIL_ENABLED') && !env('SMS_ENABLED')) {
            flash(__('De afspraak is succesvol bijgewerkt.'))->success();
        }
        else if(env('MAIL_ENABLED') && !env('SMS_ENABLED')){
            flash(__('De afspraak is succesvol bijgewerkt. Een bevestiging is gestuurd naar het email adres'))->success();
        }
        else if (!env('MAIL_ENABLED') && env('SMS_ENABLED')){
            flash(__('De afspraak is succesvol bijgewerkt. Een bevestiging is gestuurd naar het telefoonnummer'))->success();
        }
        else {
            flash(__('De afspraak is succesvol bijgewerkt. Een bevestiging is gestuurd naar het email adres en telefoonnummer'))->success();
        }

        return redirect()->back();

    }

    /* Function executed when an employee or owner deletes an appointment */
    public function deleteAppointmentAdmin($id){
        $appointment = Appointment::find($id);
        /* If sms is enabled, send sms */
        if (env('SMS_ENABLED')){
            $smsMessage = new SmsMessage();
            $smsMessage->originator = env('SMS_NAME');
            $smsMessage->recipients = [ $appointment->phone ];
            $smsMessage->body = __('Beste :firstname, uw afspraak bij :name is geannuleerd. U kunt deze afspraak niet meer bekijken.',['firstname' => $appointment->firstname, 'name' => env('APP_NAME')]);
            $smsMessage->send();
        }
        /* If mail is enabled, send maill */
        if(env('MAIL_ENABLED')) Mail::to($appointment->email)->send(new AppointmentMailer($appointment, "cancelled"));

        /* Various checks to check what message to display */
        if (!env('MAIL_ENABLED') && !env('SMS_ENABLED')) {
            flash(__('De afspraak is succesvol geannuleerd.'))->success();
        }
        else if(env('MAIL_ENABLED') && !env('SMS_ENABLED')){
            flash(__('De afspraak is succesvol geannuleerd. Een bevestiging is gestuurd naar het email adres'))->success();
        }
        else if (!env('MAIL_ENABLED') && env('SMS_ENABLED')){
            flash(__('De afspraak is succesvol geannuleerd. Een bevestiging is gestuurd naar het telefoonnummer'))->success();
        }
        else {
            flash(__('De afspraak is succesvol geannuleerd. Een bevestiging is gestuurd naar het email adres en telefoonnummer'))->success();
        }
        $appointment->delete();
        return redirect()->route('appointments');
    }
}
