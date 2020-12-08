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
        $employee->delete();
        flash(__('Medewerker succesvol verwijderd.'))->success();
        return redirect()->back();

    }

    public function loadAddEmployeePage(){
        return view('pages.dashboard.employee');
    }
    public function submitAddEmployee(Request $request){
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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        flash(__('Medewerker succesvol toegevoegd.'))->success();
        return redirect()->route('employees');

    }
}
