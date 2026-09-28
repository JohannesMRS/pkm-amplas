@extends('layouts.customer')

@section('title', 'Pesanan Saya')

@section('content')
@php
    $statusLabels = ['pending' => 'Pending', 'proccessing' => 'Diproses', 'ready' => 'Siap Diantar', 'completed' => 'Selesai', 'canceled' => 'Dibatalkan'];
    $paymentLabels = ['unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'refunded' => 'Dikembalikan'];
@endphp

<div class="pagehead" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:12px;">
    <div>
        <h1>Pesanan Saya</h1>
        <p>Seluruh riwayat pesanan laundry milikmu.</p>
    </div>
    <a href="{{ route('customer.orders.create') }}" class="btn primary">+ Buat Pesanan</a>
</div>

<div class="card">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Jadwal Jemput</th>
                    <th>Jadwal Antar</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_numbers }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->pickup_date)->translatedFormat('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('d M Y') }}</td>
                        <td>{{ $order->total_price > 0 ? 'Rp' . number_format($order->total_price, 0, ',', '.') : 'Menunggu ditimbang' }}</td>
                        <td><span class="badge" data-s="{{ $order->status }}">{{ $statusLabels[$order->status] }}</span></td>
                        <td><b style="color:var(--{{ $order->payment_status }})">{{ $paymentLabels[$order->payment_status] }}</b></td>
                        <td style="text-align:right;white-space:nowrap;">
                            <a href="{{ route('customer.orders.show', $order) }}" class="btn">Detail</a>
                            @if($order->status === 'pending')
                                <form method="POST" action="{{ route('customer.orders.cancel', $order) }}" style="display:inline;"
                                      onsubmit="return confirm('Batalkan pesanan {{ $order->order_numbers }}?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn danger">Batalkan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty">Belum ada pesanan. Buat pesanan pertamamu sekarang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">{{ $orders->links() }}</div>
@endsection