<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — Laundry Kece</title>
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

            <h1 class="font-display text-2xl font-bold mb-1">Buat akun baru</h1>
            <p class="text-sm text-[#5B6D73] mb-6">Daftar untuk mulai pesan laundry lewat Laundry Kece.</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-semibold mb-1.5">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="w-full px-4 py-2.5 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                    @error('name')
                        <p class="mt-1.5 text-sm text-[#AD3B3B]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="w-full px-4 py-2.5 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                    @error('email')
                        <p class="mt-1.5 text-sm text-[#AD3B3B]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold mb-1.5">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-2.5 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                    @error('password')
                        <p class="mt-1.5 text-sm text-[#AD3B3B]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold mb-1.5">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-2.5 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                    @error('password_confirmation')
                        <p class="mt-1.5 text-sm text-[#AD3B3B]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-1">
                    <a href="{{ route('login') }}" class="text-sm text-[#5B6D73] underline hover:text-[#2E6F7E]">
                        Sudah punya akun?
                    </a>

                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-[#2E6F7E] text-white font-semibold text-sm hover:bg-[#245A67]">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>