<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function loadEmployeesPage() {
        $employees = Role::where('identifier', 'employee')->first()->users->all();
        return view('pages.dashboard.employees', compact('employees'));
    }

    public function deleteEmployee($id){
        $employee = User::find($id);
        if($employee->role->identifier == 'employee'){
            $employee->delete();
            flash(__('Medewerker succesvol verwijderd.'))->success();
        }
        return redirect()->back();
    }

    public function loadAddEmployeePage(){
        return view('pages.dashboard.employee');
    }

    public function loadEditEmployeePage($id){
        $employee = User::find($id);
        if($employee->role->identifier == 'employee'){
            return view('pages.dashboard.employee', compact('employee'));
        }
        else {
            return redirect()->back();
        }
    }


    public function submitEmployee(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', !$request->employee_id ? 'unique:users,email,' : null],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->employee_id){
            /*
             * Find employee if already exists
             * */
            $employee = User::find($request->employee_id);

            if($employee->role->identifier != 'employee'){
                return redirect()->back();
            }

        }
        else {
            /*
             * Create new treatment
             * */
            $employee = new User();
        }
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->password = Hash::make($request->password);

        $employee->save();

        flash($request->employee_id ? ('Medewerker succesvol bijgewerkt.') : __('Medewerker succesvol toegevoegd.'))->success();
        return redirect()->route('employees');

    }
}
