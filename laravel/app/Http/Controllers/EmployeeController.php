<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
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
        return redirect()->back();

    }
}
