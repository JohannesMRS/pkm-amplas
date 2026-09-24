<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total_price')
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }
}