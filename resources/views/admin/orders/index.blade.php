@extends('layouts.admin')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <h1>Daftar Transaksi</h1>
        <p>Seluruh transaksi pesanan yang tercatat di sistem.</p>
    </div>

    @if (session('status'))
        <div style="margin-bottom:16px;font-size:13.5px;font-weight:600;color:var(--ready);background:var(--ready-bg);border-radius:8px;padding:10px 14px;">
            {{ session('status') }}
        </div>
    @endif

    <div class="toolbar">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach(['pending' => 'Pending', 'proccessing' => 'Diproses', 'ready' => 'Siap Diantar', 'completed' => 'Selesai', 'canceled' => 'Dibatalkan'] as $value => $label)
                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="mono">{{ $order->order_numbers }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->orderDetails->pluck('products.name')->filter()->implode(', ') ?: '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->pickup_date)->translatedFormat('d M Y') }}</td>
                        <td>{{ $order->total_price ? 'Rp' . number_format($order->total_price, 0, ',', '.') : '—' }}</td>
                        <td><span class="badge" data-s="{{ $order->status }}">
                            {{ ['pending' => 'Pending', 'proccessing' => 'Diproses', 'ready' => 'Siap Diantar', 'completed' => 'Selesai', 'canceled' => 'Dibatalkan'][$order->status] }}
                        </span></td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.updatePaymentStatus', $order) }}">
                                @csrf
                                @method('PATCH')
                                <select name="payment_status" onchange="this.form.submit()"
                                    style="color:var(--{{ $order->payment_status }});font-weight:700;border-color:transparent;background:transparent;">
                                    @foreach(['unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'refunded' => 'Dikembalikan'] as $value => $label)
                                        <option value="{{ $value }}" {{ $order->payment_status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:26px;">Belum ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $orders->appends(request()->query())->links() }}</div>
</div>
@endsection