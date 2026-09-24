<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->paginate(15);

        return view('admin.expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        Expense::create($validated);

        return redirect()
            ->route('admin.expenses.index')
            ->with('status', 'Pengeluaran berhasil dicatat.');
    }
}