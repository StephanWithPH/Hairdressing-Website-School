<?php

namespace App\Http\Controllers;

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

    public function submitAddTreatment(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = Treatment::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back();

    }
}
