@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="wrap">
    <div class="pagehead" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:12px;">
        <div>
            <h1>Laporan Keuangan</h1>
            <p>Ringkasan pemasukan dan pengeluaran toko bulan berjalan.</p>
        </div>
        <a href="{{ route('admin.reports.export', request()->query()) }}" class="btn primary">Export PDF</a>
    </div>

    <div class="stat-grid">
        <div class="stat">
            <div class="lbl">Total Pemasukan</div>
            <div class="val" style="color:var(--ready)">Rp{{ number_format($totalIncome, 0, ',', '.') }}</div>
        </div>
        <div class="stat">
            <div class="lbl">Total Pengeluaran</div>
            <div class="val" style="color:var(--canceled)">Rp{{ number_format($totalExpense, 0, ',', '.') }}</div>
        </div>
        <div class="stat">
            <div class="lbl">Laba Bersih</div>
            <div class="val">Rp{{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Rincian Pembayaran Masuk</div>
        <table>
            <thead>
                <tr><th>No. Pesanan</th><th>Metode</th><th>Jumlah</th><th>Tanggal</th></tr>
            </thead>
            <tbody>
                @forelse($paidPayments as $payment)
                    <tr>
                        <td class="mono">{{ $payment->orders->order_numbers }}</td>
                        <td style="text-transform:capitalize;">{{ $payment->method }}</td>
                        <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->paid_at)->translatedFormat('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:26px;">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
