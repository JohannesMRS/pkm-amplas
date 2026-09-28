@extends('layouts.customer')

@section('title', 'Detail Pesanan')

@section('content')
@php
    $statusLabels = ['pending' => 'Pending', 'proccessing' => 'Diproses', 'ready' => 'Siap Diantar', 'completed' => 'Selesai', 'canceled' => 'Dibatalkan'];
    $paymentLabels = ['unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'refunded' => 'Dikembalikan'];
    $payment = $order->payments->last();
    $needsPayment = $order->status !== 'canceled' && $order->total_price > 0 && $order->payment_status === 'unpaid';
@endphp

<div class="pagehead" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:12px;">
    <div>
        <h1>{{ $order->order_numbers }}</h1>
        <p>Dibuat {{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('customer.orders.index') }}" class="btn">Kembali</a>
        @if($order->status === 'pending')
            <form method="POST" action="{{ route('customer.orders.cancel', $order) }}"
                  onsubmit="return confirm('Batalkan pesanan {{ $order->order_numbers }}?')">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn danger">Batalkan Pesanan</button>
            </form>
        @endif
    </div>
</div>

<div class="grid-2" style="align-items:start;">
    <div>
        <div class="card">
            <div class="section-title">Informasi Pesanan</div>
            <div class="rows">
                <div class="r"><span>Status</span><b><span class="badge" data-s="{{ $order->status }}">{{ $statusLabels[$order->status] }}</span></b></div>
                <div class="r"><span>Pembayaran</span><b style="color:var(--{{ $order->payment_status }})">{{ $paymentLabels[$order->payment_status] }}</b></div>
                <div class="r"><span>Jadwal Jemput</span><b>{{ \Carbon\Carbon::parse($order->pickup_date)->translatedFormat('d M Y') }}</b></div>
                <div class="r"><span>Estimasi Antar</span><b>{{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('d M Y') }}</b></div>
                <div class="r"><span>Catatan</span><b>{{ $order->note ?: '—' }}</b></div>
            </div>
        </div>

        <div class="card">
            <div class="section-title">Rincian Biaya</div>
            @if($order->orderDetails->isEmpty())
                <div class="empty" style="padding:10px 0;">Menunggu kurir menimbang cucianmu.</div>
            @else
                <div class="table-scroll">
                    <table>
                        <thead><tr><th>Layanan</th><th>Berat</th><th>Harga</th><th>Subtotal</th></tr></thead>
                        <tbody>
                            @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>{{ $detail->products->name ?? '—' }}</td>
                                    <td>{{ rtrim(rtrim(number_format($detail->quantity, 2, ',', '.'), '0'), ',') }} {{ $detail->products->unit ?? '' }}</td>
                                    <td>Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" style="text-align:right;font-weight:700;">Total</td>
                                <td style="font-weight:700;">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div>
        <div class="card">
            <div class="section-title">Riwayat Status</div>
            <div class="timeline">
                @forelse($order->order_status_histories as $history)
                    <div class="t">
                        <div class="dot"></div>
                        <div>
                            {{ $statusLabels[$history->status] ?? $history->status }}
                            <small>{{ $history->created_at->translatedFormat('d M Y, H:i') }}</small>
                        </div>
                    </div>
                @empty
                    <div class="t">
                        <div class="dot"></div>
                        <div>Pending<small>{{ $order->created_at->translatedFormat('d M Y, H:i') }}</small></div>
                    </div>
                @endforelse
            </div>
        </div>

        @if($needsPayment)
            <div class="card">
                <div class="section-title">Pembayaran</div>
                <p style="font-size:13.5px;margin:0 0 12px;">
                    Total tagihan <b>Rp{{ number_format($order->total_price, 0, ',', '.') }}</b>. Lakukan transfer, lalu unggah bukti pembayarannya di sini.
                </p>
                {{-- Tambahkan info rekening toko di sini, misalnya: <p>BCA 1234567890 a.n. Laundry Amplas</p> --}}

                @if($payment && $payment->proof)
                    <p style="font-size:13px;color:var(--ready);font-weight:600;margin:0 0 12px;">
                        Bukti sudah dikirim, menunggu konfirmasi admin.
                        <a href="{{ asset('storage/' . $payment->proof) }}" target="_blank" style="color:inherit;">Lihat bukti</a>
                    </p>
                @endif

                <form method="POST" action="{{ route('customer.orders.paymentProof', $order) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="field">
                        <label for="proof">{{ $payment && $payment->proof ? 'Ganti bukti transfer' : 'Bukti transfer (JPG, PNG, atau PDF, maks. 2 MB)' }}</label>
                        <input type="file" id="proof" name="proof" accept=".jpg,.jpeg,.png,.pdf" required>
                    </div>
                    <button type="submit" class="btn accent">Kirim Bukti</button>
                </form>
            </div>
        @elseif($order->payment_status === 'paid' && $payment && $payment->paid_at)
            <div class="card">
                <div class="section-title">Pembayaran</div>
                <p style="font-size:13.5px;margin:0;color:var(--paid);font-weight:600;">
                    Lunas pada {{ \Carbon\Carbon::parse($payment->paid_at)->translatedFormat('d M Y, H:i') }}.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection