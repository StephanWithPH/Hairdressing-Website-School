<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TreatmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*
         * Create new array with the days in a week
         * */
        $this->days = [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday'
        ];
    }


    public function loadTreatmentsPage(){
        $treatments = Treatment::all();
        return view('pages.dashboard.treatments', compact('treatments'));
    }

    public function deleteTreatment($id){
        $treatment = Treatment::find($id);
        $treatment->delete();
        flash(__('Behandeling succesvol verwijderd.'))->success();
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
        if ($request->treatment_id){
            /*
             * Find treatment if already exists
             * */
            $treatment = Treatment::find($request->treatment_id);
        }
        else {
            /*
             * Create new treatment
             * */
            $treatment = new Treatment();
        }

        $treatment->name = $request->name;
        $treatment->price = $request->price;
        $treatment->description = $request->description;
        $treatment->image = $request->image ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($request->file('image')->getRealPath())) : $treatment->image;
        $treatment->timetables()->delete();
        /*
         * Save teatment to database
         * */
        $treatment->save();

        /*
         * Loop though the days
         * */
        for($i = 0; $i < count($this->days); $i++){

            /*
             * Create array with the time on each separate line
             * */
            $daytimes = explode(PHP_EOL, $request->{$this->days[$i]});
            /*
             * Check if there are no times filled in
             * */
            if($request->{$this->days[$i]} != ""){
                /*
                 * Loop through the times
                 * */
                for ($j = 0; $j < count($daytimes); $j++){
                    /*
                     * Create new timetible
                     * */
                    $timetable = new Timetable();
                    $timetable->treatment()->associate($treatment);
                    $timetable->day = $this->days[$i];

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
        flash($request->treatment_id? __('Behandeling succesvol bewerkt.') : __('Behandeling succesvol toegevoegd.'))->success();
        return redirect()->route('treatments');

    }
}
