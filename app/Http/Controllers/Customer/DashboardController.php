<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Pesanan yang masih berjalan
        $activeOrders = Order::where('user_id', $userId)
            ->whereIn('status', ['pending', 'proccessing', 'ready'])
            ->latest()
            ->get();

        // Tagihan yang sudah ada harganya tapi belum dibayar
        $unpaidCount = Order::where('user_id', $userId)
            ->where('payment_status', 'unpaid')
            ->where('total_price', '>', 0)
            ->where('status', '!=', 'canceled')
            ->count();

        $completedCount = Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        $hasAddress = Address::where('user_id', $userId)->exists();

        return view('customer.dashboard', compact('activeOrders', 'unpaidCount', 'completedCount', 'hasAddress'));
    }
}