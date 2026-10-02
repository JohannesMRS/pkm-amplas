<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>@yield('title', 'Akun') — Laundry Amplas</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
:root{
  --bg:#F3F6F5; --surface:#FFFFFF; --ink:#16232B; --muted:#66787F; --line:#DCE4E2;
  --primary:#2E6F7E; --accent:#D9781E;
  --canceled:#AD3B3B; --canceled-bg:#F7E7E7; --ready:#3E7F52; --ready-bg:#E5F1E7;
}
*{box-sizing:border-box;}
body{margin:0;background:var(--bg);color:var(--ink);font-family:system-ui,sans-serif;}
h1,h2{font-family:'Space Grotesk',system-ui,sans-serif;margin:0;font-weight:600;}
.topbar{background:var(--surface);border-bottom:1px solid var(--line);padding:16px 26px;display:flex;justify-content:space-between;align-items:center;}
.brand{display:flex;align-items:center;gap:9px;font-family:'Space Grotesk';font-weight:700;font-size:16px;text-decoration:none;color:var(--ink);}
.brand span{width:28px;height:28px;border-radius:8px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;}
.topbar-right{display:flex;align-items:center;gap:14px;}
.topbar-right a, .topbar-right button{font-size:13px;font-weight:600;color:var(--muted);text-decoration:none;background:none;border:none;cursor:pointer;font-family:inherit;}
.topbar-right a:hover, .topbar-right button:hover{color:var(--primary);}
.wrap{max-width:640px;margin:0 auto;padding:36px 20px 60px;}
.pagehead{margin-bottom:22px;}
.pagehead p{color:var(--muted);margin:4px 0 0;font-size:14px;}
.card{background:var(--surface);border:1px solid var(--line);border-radius:14px;padding:26px;margin-bottom:20px;}
.card h3{font-size:16px;}
.card .desc{color:var(--muted);font-size:13.5px;margin:4px 0 18px;}
.field{display:flex;flex-direction:column;gap:5px;margin-bottom:14px;}
.field label{font-size:12.5px;color:var(--muted);font-weight:600;}
.field input,.field textarea{padding:9px 11px;border-radius:8px;border:1px solid var(--line);background:var(--bg);font-size:13.5px;font-family:inherit;width:100%;}
.field textarea{min-height:70px;resize:vertical;}
.field .error{color:var(--canceled);font-size:12.5px;margin:0;}
.btn{border:1px solid var(--line);background:var(--surface);color:var(--ink);padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-block;font-family:inherit;}
.btn.primary{background:var(--primary);border-color:var(--primary);color:#fff;}
.btn.danger{background:var(--canceled);border-color:var(--canceled);color:#fff;}
.flash{font-size:13px;font-weight:600;color:var(--ready);background:var(--ready-bg);border-radius:8px;padding:8px 12px;margin-bottom:14px;display:inline-block;}
.card.danger-zone{border-color:var(--canceled);}
.card.danger-zone h3{color:var(--canceled);}
</style>
@stack('styles')
</head>
<body>
    <div class="topbar">
        @php
            $backRoute = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('customer.dashboard');
        @endphp
        <a href="{{ $backRoute }}" class="brand"><span>LA</span>Laundry Amplas</a>
        <div class="topbar-right">
            <span style="color:var(--muted);">{{ auth()->user()->name }}</span>
            <a href="{{ $backRoute }}">Kembali ke Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Keluar</button>
            </form>
        </div>
    </div>

    <div class="wrap">
        <div class="pagehead">
            <h1>@yield('title')</h1>
            <p>Kelola informasi akun dan keamanan password kamu.</p>
        </div>

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>