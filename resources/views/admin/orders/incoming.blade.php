@extends('layouts.admin')

@section('title', 'Pesanan Masuk')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <h1>Pesanan Masuk</h1>
        <p>Pesanan baru dari pelanggan yang menunggu dijemput, ditimbang, dan diberi harga.</p>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Jadwal Jemput</th>
                    <th>Catatan</th>
                    <th style="min-width:260px;">Timbang &amp; Tentukan Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="mono">{{ $order->order_numbers }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->pickup_date)->translatedFormat('d M Y') }}</td>
                        <td>{{ $order->note ?: '—' }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.process', $order) }}" style="display:flex;gap:6px;">
                                @csrf
                                <select name="product_id" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} (Rp{{ number_format($product->price, 0, ',', '.') }}/{{ $product->unit }})</option>
                                    @endforeach
                                </select>
                                <input type="number" name="quantity" step="0.1" min="0.1" placeholder="Berat" style="width:80px;" required>
                                <button type="submit" class="btn primary">Proses</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:26px;">Tidak ada pesanan baru</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $orders->links() }}</div>
</div>
@endsection
