<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'admin')->latest()->paginate(15);
        return view('admin.employees.index', compact('employees'));
    }

    public function show(User $employee)
    {
        $this->ensureIsEmployee($employee);
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        $this->ensureIsEmployee($employee);

        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $this->ensureIsEmployee($employee);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($employee->id)],
            'role' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $employee->update($validated);

        return redirect()
            ->route('admin.employees.show', $employee)
            ->with('status', "Data {$employee->name} berhasil diperbarui.");
    }

    private function ensureIsEmployee(User $employee): void
    {
        abort_unless($employee->role === 'admin', 404);
    }
}