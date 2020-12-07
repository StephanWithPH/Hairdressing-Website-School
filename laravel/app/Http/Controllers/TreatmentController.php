<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TreatmentController extends Controller
{
    public function loadTreatmentsPage(){
        $treatments = Treatment::all();
        return view('pages.dashboard.treatments', compact('treatments'));
    }

    public function deleteTreatment($id){
        $treatment = Treatment::find($id);
        $treatment->delete();
        return redirect()->back();

    }

    public function loadAddTreatmentPage(){
        return view('pages.dashboard.treatment');
    }

    public function loadEditTreatmentPage($id){
        $treatment = Treatment::find($id);
        return view('pages.dashboard.treatment', compact('treatment'));
    }

    public function submitTreatment(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required'],
            'description' => ['required', 'string', 'min:20', 'max:300'],
            'image' => ['image', 'file'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        /*
         * Create new treatment
         * */
        $treatment = Treatment::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => 'data:image/jpeg;base64,' . base64_encode(file_get_contents($request->file('image')->getRealPath()))
        ]);
        /*
         * Save teatment to database
         * */
        $treatment->save();


        /*
         * Create new array with all of the days in a week
         * */
        $days = [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday'
        ];

        /*
         * Loop though the days
         * */
        for($i = 0; $i < count($days); $i++){

            /*
             * Create array with the time on each separate line
             * */
            $daytimes = explode(PHP_EOL, $request->{$days[$i]});
            /*
             * Check if there are no times filled in
             * */
            if($request->{$days[$i]} != ""){
                /*
                 * Loop through the times
                 * */
                for ($j = 0; $j < count($daytimes); $j++){
                    /*
                     * Create new timetible
                     * */
                    $timetable = new Timetable();
                    $timetable->treatment()->associate($treatment);
                    $timetable->day = $days[$i];

                    /*
                     * Split the time from and the time until
                     * */
                    $times = explode('-', $daytimes[$j]);
                    $timetable->time_from = $times[0];
                    $timetable->time_until = $times[1];
                    $timetable->save();
                }
            }


        }
        return redirect()->back();

    }
}
