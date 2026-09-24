@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <h1>Pembayaran</h1>
        <p>Riwayat pembayaran dari setiap transaksi pelanggan.</p>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Metode</th>
                    <th>Jumlah</th>
                    <th>Tgl Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td class="mono">{{ $payment->orders->order_numbers }}</td>
                        <td>{{ $payment->orders->user->name }}</td>
                        <td style="text-transform:capitalize;">{{ $payment->method }}</td>
                        <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->translatedFormat('d M Y') : '—' }}</td>
                        <td>
                            <span style="font-weight:700;color:var(--{{ $payment->orders->payment_status }})">
                                {{ ['unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'refunded' => 'Dikembalikan'][$payment->orders->payment_status] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:26px;">Belum ada pembayaran tercatat</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $payments->links() }}</div>
</div>
@endsection
