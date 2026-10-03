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
            <h1>{{ $employee->name }}</h1>
            <p>Terdaftar sejak {{ $employee->created_at->translatedFormat('d M Y') }}</p>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.employees.index') }}" class="btn">Kembali</a>
            <a href="{{ route('admin.employees.edit', $employee) }}" class="btn primary">Edit</a>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Informasi Akun</div>
        <div class="rows">
            <div class="r"><span>Nama</span><b>{{ $employee->name }}</b></div>
            <div class="r"><span>Email</span><b>{{ $employee->email }}</b></div>
            <div class="r"><span>No. HP</span><b>{{ $employee->phone ?: '—' }}</b></div>
            <div class="r"><span>Alamat</span><b>{{ $employee->address ?: '—' }}</b></div>
            <div class="r">
                <span>Status</span>
                <b>
                    <span class="badge" data-s="{{ $employee->is_active ? 'ready' : 'canceled' }}">
                        {{ $employee->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </b>
            </div>
        </div>

        {{-- <form method="POST" action="{{ route('admin.employees.toggleActive', $customer) }}" style="margin-top:16px;"
              onsubmit="return confirm('{{ $cemployee->is_active ? 'Nonaktifkan' : 'Aktifkan kembali' }} akun {{ $customer->name }}?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn {{ $customer->is_active ? 'danger' : 'primary' }}">
                {{ $customer->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Kembali' }}
            </button>
        </form> --}}
        @if(!$employee->is_active)
            <p style="font-size:12.5px;color:var(--muted);margin:8px 0 0;">
                Akun ini tidak bisa login. Data dan riwayat pesanan tetap tersimpan.
            </p>
        @endif
    </div>
</div>
@endsection