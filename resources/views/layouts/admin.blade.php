<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>@yield('title', 'Dashboard') — Laundry Amplas Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="{{ asset('admin/style.css') }}">
@stack('styles')
</head>
<body>
<div class="layout">
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand"><span>LK</span>Laundry Amplas</a>

        <div class="navgroup">
            <a href="{{ route('admin.dashboard') }}" class="navlink {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard Utama</a>
        </div>

        <div class="navgroup">
            <div class="label">Manajemen Transaksi</div>
            <a href="{{ route('admin.orders.incoming') }}" class="navlink {{ request()->routeIs('admin.orders.incoming') ? 'active' : '' }}">Pesanan Masuk</a>
            <a href="{{ route('admin.orders.index') }}" class="navlink {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">Daftar Transaksi</a>
        </div>

        <div class="navgroup">
            <div class="label">Keuangan</div>
            <a href="{{ route('admin.payments.index') }}" class="navlink {{ request()->routeIs('admin.payments.index') ? 'active' : '' }}">Pembayaran</a>
            <a href="{{ route('admin.expenses.index') }}" class="navlink {{ request()->routeIs('admin.expenses.index') ? 'active' : '' }}">Pengeluaran</a>
            <a href="{{ route('admin.reports.index') }}" class="navlink {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">Laporan Keuangan</a>
        </div>

        <div class="navgroup">
            <div class="label">Manajemen Pengguna</div>
            <a href="{{ route('admin.customers.index') }}" class="navlink {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}">Data Pelanggan</a>
            <a href="{{ route('admin.employees.index') }}" class="navlink {{ request()->routeIs('admin.employees.index') ? 'active' : '' }}">Data Karyawan</a>
        </div>

        

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </div>

    <div class="main">
        <div class="topbar">
            <h1 style="font-size:18px;">@yield('title')</h1>
            <span class="who">
                <img src="{{ asset('images/user.svg') }}" alt="">
                <p>{{ auth()->user()->name ?? 'Admin' }}</p>
            </span>
        </div>
        @yield('content')
    </div>
</div>
@stack('scripts')
</body>
</html>
