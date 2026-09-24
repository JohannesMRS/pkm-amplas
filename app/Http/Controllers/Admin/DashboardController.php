<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Pendapatan hari ini: total pembayaran yang lunas hari ini
        $todayRevenue = Payment::whereDate('paid_at', $today)->sum('amount');

        // Jumlah pesanan yang masuk hari ini
        $todayOrdersCount = Order::whereDate('created_at', $today)->count();

        // Jumlah pesanan per status
        $statusCounts = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Grafik pendapatan 7 hari terakhir
        $revenueChart = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            return [
                'label' => $date->translatedFormat('D'),
                'value' => Payment::whereDate('paid_at', $date)->sum('amount'),
            ];
        });

        // Notifikasi mendesak: pesanan yang melewati tenggat waktu
        $notifications = collect();

        Order::with('user')
            ->where('status', 'pending')
            ->whereDate('pickup_date', '<', $today)
            ->get()
            ->each(function ($order) use ($today, $notifications) {
                $daysLate = Carbon::parse($order->pickup_date)->diffInDays($today);
                $notifications->push([
                    'message' => "Pesanan {$order->order_numbers} ({$order->user->name}) belum dijemput, sudah lewat {$daysLate} hari dari jadwal.",
                    'time' => Carbon::parse($order->pickup_date)->translatedFormat('d M, H:i'),
                ]);
            });

        Order::with('user')
            ->whereIn('status', ['proccessing', 'ready'])
            ->whereDate('delivery_date', '<', $today)
            ->get()
            ->each(function ($order) use ($today, $notifications) {
                $daysLate = Carbon::parse($order->delivery_date)->diffInDays($today);
                $notifications->push([
                    'message' => "Pesanan {$order->order_numbers} ({$order->user->name}) melewati estimasi antar {$daysLate} hari.",
                    'time' => Carbon::parse($order->delivery_date)->translatedFormat('d M, H:i'),
                ]);
            });

        $notifications = $notifications->sortByDesc('time')->values();

        return view('admin.dashboard', compact(
            'todayRevenue',
            'todayOrdersCount',
            'statusCounts',
            'revenueChart',
            'notifications'
        ));
    }
}