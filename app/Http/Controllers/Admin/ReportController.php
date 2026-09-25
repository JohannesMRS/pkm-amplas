<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));

        $data = $this->summarize($month);

        return view('admin.reports.index', $data + ['month' => $month]);
    }

    public function export(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));

        $data = $this->summarize($month);

        $pdf = Pdf::loadView('admin.reports.pdf', $data);

        return $pdf->download('laporan-keuangan-' . $month . '.pdf');
    }

    private function summarize(string $month): array
    {
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $paidPayments = Payment::with('orders.user')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$start, $end])
            ->latest('paid_at')
            ->get();

        $expenses = Expense::whereBetween('created_at', [$start, $end])
            ->latest()
            ->get();

        return [
            'periode' => $start->translatedFormat('F Y'),
            'totalIncome' => $paidPayments->sum('amount'),
            'totalExpense' => $expenses->sum('amount'),
            'paidPayments' => $paidPayments,
            'expenses' => $expenses,
        ];
    }
}