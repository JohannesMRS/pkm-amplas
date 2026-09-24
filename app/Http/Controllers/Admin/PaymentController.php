<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('orders.user')
            ->latest('paid_at')
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }
}