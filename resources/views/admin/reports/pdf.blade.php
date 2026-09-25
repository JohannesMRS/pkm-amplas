<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body {
        font-family: sans-serif;
        olor: #16232B;
        ont-size: 12px;
    }
    h1 {
        font-size: 18px;
        argin-bottom: 2px;
    }
    h2 {
        font-size: 13px;
        argin: 22px 0 6px;
    }
    p.sub {
        color: #66787F;
        argin-top: 0;
        argin-bottom: 20px;
    }
    table {
        width: 100%;
        order-collapse: collapse;
        argin-top: 6px;
    }
    th, td {
        border: 1px solid #DCE4E2;
        adding: 6px 8px;
        ext-align: left;
    }
    th {
        background: #F3F6F5;
        ont-size: 11px;
        ext-transform: uppercase;
    }
    .summary {
        width: 100%;
        argin-bottom: 10px;
    }
    .summary td {
        border: none;
        adding: 4px 0;
    }
    .summary .label {
        color: #66787F;
    }
    .summary .value {
        font-weight: bold;
        ext-align: right;
    }
</style>
</head>
<body>
    <h1>Laporan Keuangan — Laundry Kece</h1>
    <p class="sub">Periode: {{ $periode }}</p>

    <table class="summary">
        <tr><td class="label">Total Pemasukan</td><td class="value">Rp{{ number_format($totalIncome, 0, ',', '.') }}</td></tr>
        <tr><td class="label">Total Pengeluaran</td><td class="value">Rp{{ number_format($totalExpense, 0, ',', '.') }}</td></tr>
        <tr><td class="label">Laba Bersih</td><td class="value">Rp{{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</td></tr>
    </table>

    <h2>Rincian Pemasukan</h2>
    <table>
        <thead>
            <tr><th>No. Pesanan</th><th>Pelanggan</th><th>Metode</th><th>Jumlah</th><th>Tanggal</th></tr>
        </thead>
        <tbody>
            @forelse($paidPayments as $payment)
                <tr>
                    <td>{{ $payment->orders->order_numbers }}</td>
                    <td>{{ $payment->orders->user->name }}</td>
                    <td>{{ ucfirst($payment->method) }}</td>
                    <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->paid_at)->translatedFormat('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Tidak ada pemasukan pada periode ini</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Rincian Pengeluaran</h2>
    <table>
        <thead>
            <tr><th>Kategori</th><th>Jumlah</th><th>Tanggal</th><th>Keterangan</th></tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                <tr>
                    <td>{{ $expense->category }}</td>
                    <td>Rp{{ number_format($expense->amount, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->created_at)->translatedFormat('d M Y') }}</td>
                    <td>{{ $expense->note ?: '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Tidak ada pengeluaran pada periode ini</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>