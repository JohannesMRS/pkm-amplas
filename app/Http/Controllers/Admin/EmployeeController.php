<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'admin')->latest()->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }
}