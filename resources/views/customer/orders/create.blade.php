@extends('layouts.customer')

@section('title', 'Buat Pesanan')

@section('content')
<div class="pagehead">
    <h1>Buat Pesanan</h1>
    <p>Pilih layanan dan jadwal, kurir akan menjemput dan menimbang cucianmu.</p>
</div>

@if($addresses->isEmpty())
    <div class="notice">
        Kamu belum punya alamat penjemputan. <a href="{{ route('customer.addresses.index') }}">Tambah alamat</a> terlebih dahulu.
    </div>
@else
    <div class="card" style="max-width:560px;">
        <form method="POST" action="{{ route('customer.orders.store') }}">
            @csrf

            <div class="field">
                <label for="product_id">Jenis Layanan</label>
                <select id="product_id" name="product_id" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (Rp{{ number_format($product->price, 0, ',', '.') }} untuk {{ config('laundry.min_weight') }}kg pertama)
                        </option>
                    @endforeach
                </select>
                <p style="font-size:12px;color:var(--muted);margin:4px 0 0;">
                    Berlaku minimal {{ config('laundry.min_weight') }}kg. Kelebihan berat dikenai tambahan Rp{{ number_format(config('laundry.extra_rate_per_kg'), 0, ',', '.') }}/kg, dihitung otomatis setelah ditimbang kurir.
                </p>
            </div>

            <div class="field">
                <label for="address_id">Alamat Penjemputan</label>
                <select id="address_id" name="address_id" required>
                    @foreach($addresses as $address)
                        <option value="{{ $address->id }}" {{ old('address_id') == $address->id ? 'selected' : '' }}>
                            {{ $address->label }}{{ $address->is_primary ? ' (Utama)' : '' }}: {{ \Illuminate\Support\Str::limit($address->full_address, 60) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label for="pickup_date">Tanggal Jemput</label>
                    <input type="date" id="pickup_date" name="pickup_date" value="{{ old('pickup_date') }}" min="{{ now()->toDateString() }}" required>
                </div>
                <div class="field">
                    <label for="delivery_date">Estimasi Antar</label>
                    <input type="date" id="delivery_date" name="delivery_date" value="{{ old('delivery_date') }}" min="{{ now()->toDateString() }}" required>
                </div>
            </div>

            <div class="field">
                <label for="note">Catatan (opsional)</label>
                <textarea id="note" name="note" placeholder="Contoh: titip satpam blok C">{{ old('note') }}</textarea>
            </div>

            <p style="font-size:12.5px;color:var(--muted);margin:0 0 14px;">
                Berat cucian ditimbang kurir saat penjemputan. Harga final muncul di halaman pesananmu setelah itu.
            </p>

            <button type="submit" class="btn primary">Kirim Pesanan</button>
            <a href="{{ route('customer.orders.index') }}" class="btn">Batal</a>
        </form>
    </div>
@endif
@endsection