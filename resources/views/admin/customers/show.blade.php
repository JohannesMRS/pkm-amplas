@extends('layouts.admin')

@section('title', 'Detail Pelanggan')

@section('content')
@php
    $statusLabels = ['pending' => 'Pending', 'proccessing' => 'Diproses', 'ready' => 'Siap Diantar', 'completed' => 'Selesai', 'canceled' => 'Dibatalkan'];
    $paymentLabels = ['unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'refunded' => 'Dikembalikan'];
@endphp

<div class="wrap">
    <div class="pagehead" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:12px;">
        <div>
            <h1>{{ $customer->name }}</h1>
            <p>Terdaftar sejak {{ $customer->created_at->translatedFormat('d M Y') }}</p>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.customers.index') }}" class="btn">Kembali</a>
            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn primary">Edit</a>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Informasi Akun</div>
        <div class="rows">
            <div class="r"><span>Nama</span><b>{{ $customer->name }}</b></div>
            <div class="r"><span>Email</span><b>{{ $customer->email }}</b></div>
            <div class="r"><span>No. HP</span><b>{{ $customer->phone ?: '—' }}</b></div>
            <div class="r"><span>Alamat</span><b>{{ $customer->address ?: '—' }}</b></div>
            <div class="r">
                <span>Status</span>
                <b>
                    <span class="badge" data-s="{{ $customer->is_active ? 'ready' : 'canceled' }}">
                        {{ $customer->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </b>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.customers.toggleActive', $customer) }}" style="margin-top:16px;"
              onsubmit="return confirm('{{ $customer->is_active ? 'Nonaktifkan' : 'Aktifkan kembali' }} akun {{ $customer->name }}?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn {{ $customer->is_active ? 'danger' : 'primary' }}">
                {{ $customer->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Kembali' }}
            </button>
        </form>
        @if(!$customer->is_active)
            <p style="font-size:12.5px;color:var(--muted);margin:8px 0 0;">
                Akun ini tidak bisa login. Data dan riwayat pesanan tetap tersimpan.
            </p>
        @endif
    </div>

    <div class="card">
        <div class="section-title">Riwayat Pesanan</div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
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
                            <td>{{ $order->created_at->translatedFormat('d M Y') }}</td>
                            <td>{{ $order->total_price > 0 ? 'Rp' . number_format($order->total_price, 0, ',', '.') : '—' }}</td>
                            <td><span class="badge" data-s="{{ $order->status }}">{{ $statusLabels[$order->status] }}</span></td>
                            <td><b style="color:var(--{{ $order->payment_status }})">{{ $paymentLabels[$order->payment_status] }}</b></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:26px;">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $orders->links() }}</div>
    </div>
</div>
@endsection