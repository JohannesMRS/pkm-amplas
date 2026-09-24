@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
<div class="wrap">
    <div class="pagehead">
        <h1>Ringkasan Performa</h1>
        <p>Pantau performa harian toko dan status cucian yang sedang berjalan.</p>
    </div>

    <div class="stat-grid">
        <div class="stat">
            <div class="lbl">Pendapatan Hari Ini</div>
            <div class="val">Rp{{ number_format($todayRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat">
            <div class="lbl">Pesanan Hari Ini</div>
            <div class="val">{{ $todayOrdersCount }} <small style="font-size:12px;font-weight:600;color:var(--muted);">pesanan</small></div>
        </div>
        <div class="stat">
            <div class="lbl">Pending</div>
            <div class="val" style="color:var(--pending)">{{ $statusCounts['pending'] ?? 0 }}</div>
        </div>
        <div class="stat">
            <div class="lbl">Diproses</div>
            <div class="val" style="color:var(--processing)">{{ $statusCounts['proccessing'] ?? 0 }}</div>
        </div>
        <div class="stat">
            <div class="lbl">Siap Diantar</div>
            <div class="val" style="color:var(--ready)">{{ $statusCounts['ready'] ?? 0 }}</div>
        </div>
        <div class="stat">
            <div class="lbl">Selesai</div>
            <div class="val" style="color:var(--completed)">{{ $statusCounts['completed'] ?? 0 }}</div>
        </div>
    </div>

    <div class="two-col">
        <div class="card">
            <div class="section-title">Pendapatan 7 Hari Terakhir</div>
            @php $max = $revenueChart->max('value') ?: 1; @endphp
            <div class="chart">
                @foreach($revenueChart as $point)
                    <div class="bar-wrap">
                        <div class="bar" style="height:{{ max(($point['value'] / $max) * 130, 2) }}px" title="Rp{{ number_format($point['value'], 0, ',', '.') }}"></div>
                        <div class="day">{{ $point['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="section-title">Notifikasi Mendesak</div>
            @forelse($notifications as $n)
                <div class="notif">
                    <div class="dot"></div>
                    <div>{{ $n['message'] }}<span>{{ $n['time'] }}</span></div>
                </div>
            @empty
                <p style="color:var(--muted);font-size:13px;">Tidak ada pesanan yang melewati tenggat waktu.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
