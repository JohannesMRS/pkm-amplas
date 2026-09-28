<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>@yield('title', 'Dashboard') — Laundry Amplas</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="{{ asset('customer/style.css') }}">
@stack('styles')
</head>
<body>
<div class="layout">
    <div class="sidebar">
        <a href="{{ route('customer.dashboard') }}" class="brand"><span>LK</span>Laundry Amplas</a>

        <div class="navgroup">
            <a href="{{ route('customer.dashboard') }}" class="navlink {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">Dashboard</a>
        </div>

        <div class="navgroup">
            <div class="label">Pesanan</div>
            <a href="{{ route('customer.orders.create') }}" class="navlink {{ request()->routeIs('customer.orders.create') ? 'active' : '' }}">Buat Pesanan</a>
            <a href="{{ route('customer.orders.index') }}" class="navlink {{ request()->routeIs('customer.orders.index', 'customer.orders.show') ? 'active' : '' }}">Pesanan Saya</a>
        </div>

        <div class="navgroup">
            <div class="label">Akun</div>
            <a href="{{ route('customer.addresses.index') }}" class="navlink {{ request()->routeIs('customer.addresses.*') ? 'active' : '' }}">Alamat Saya</a>
            <a href="{{ route('profile.edit') }}" class="navlink {{ request()->routeIs('profile.*') ? 'active' : '' }}">Profil</a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="logout">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </div>

    <div class="main">
        <div class="topbar">
            <h1 style="font-size:18px;">@yield('title')</h1>
            <span class="who">{{ auth()->user()->name }} · Pelanggan</span>
        </div>

        <div class="wrap">
            @if (session('status'))
                <div class="flash ok">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="flash err">
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>