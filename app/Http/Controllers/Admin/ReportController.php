<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        [$totalIncome, $totalExpense, $paidPayments] = $this->summarize();

        return view('admin.reports.index', compact('totalIncome', 'totalExpense', 'paidPayments'));
    }

    public function export()
    {
        [$totalIncome, $totalExpense, $paidPayments] = $this->summarize();

        $pdf = Pdf::loadView('admin.reports.pdf', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'paidPayments' => $paidPayments,
            'periode' => Carbon::now()->translatedFormat('F Y'),
        ]);

        return $pdf->download('laporan-keuangan-' . now()->format('Y-m') . '.pdf');
    }

    private function summarize(): array
    {
        $paidPayments = Payment::with('orders.user')
            ->whereNotNull('paid_at')
            ->latest('paid_at')
            ->get();

        $totalIncome = $paidPayments->sum('amount');
        $totalExpense = Expense::sum('amount');

        return [$totalIncome, $totalExpense, $paidPayments];
    }
}