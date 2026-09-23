<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Laundry Kece</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .font-display { font-family: 'Space Grotesk', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-[#F5F7F6] text-[#16232B] antialiased min-h-screen flex items-center justify-center px-6 py-12">

    <div class="w-full max-w-md">

        <a href="/" class="flex items-center justify-center gap-2 font-display font-bold text-lg mb-8">
            <span class="w-8 h-8 rounded-lg bg-[#2E6F7E] text-white flex items-center justify-center text-sm">LK</span>
            Laundry Kece
        </a>

        <div class="bg-white border border-[#DCE4E2] rounded-2xl p-8">

            <h1 class="font-display text-2xl font-bold mb-1">Masuk ke akunmu</h1>
            <p class="text-sm text-[#5B6D73] mb-6">Pantau dan pesan laundry lewat akunmu.</p>

            @if (session('status'))
                <div class="mb-5 text-sm font-medium text-[#3E7F52] bg-[#E5F1E7] border border-[#C9E1CD] rounded-lg px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="w-full px-4 py-2.5 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                    @error('email')
                        <p class="mt-1.5 text-sm text-[#AD3B3B]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold mb-1.5">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-2.5 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                    @error('password')
                        <p class="mt-1.5 text-sm text-[#AD3B3B]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <label for="remember_me" class="flex items-center gap-2 text-sm text-[#5B6D73]">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-[#DCE4E2] text-[#2E6F7E] focus:ring-[#2E6F7E]">
                    Ingat saya
                </label>

                <div class="flex items-center justify-between pt-1">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-[#5B6D73] underline hover:text-[#2E6F7E]">
                            Lupa password?
                        </a>
                    @else
                        <span></span>
                    @endif

                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-[#2E6F7E] text-white font-semibold text-sm hover:bg-[#245A67]">
                        Masuk
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-sm text-[#5B6D73] mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-[#2E6F7E] hover:underline">Daftar sekarang</a>
        </p>
    </div>

</body>
</html>