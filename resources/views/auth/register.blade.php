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
<body class="bg-[#F5F7F6] text-[#16232B] antialiased min-h-screen flex items-center justify-center px-4 py-6">

    <div class="w-full max-w-2xl">

        <a href="/" class="flex items-center justify-center gap-2 font-display font-bold text-lg mb-4">
            <span class="w-8 h-8 rounded-lg bg-[#2E6F7E] text-white flex items-center justify-center text-sm">LK</span>
            Laundry Kece
        </a>

        <div class="bg-white border border-[#DCE4E2] rounded-2xl p-6">

            <h1 class="font-display text-xl font-bold">Buat akun baru</h1>
            <p class="text-sm text-[#5B6D73] mb-4">Daftar untuk mulai pesan laundry lewat Laundry Kece.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="grid sm:grid-cols-2 gap-x-4 gap-y-3">

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-xs font-semibold mb-1">Nama</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="w-full px-3 py-2 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                        @error('name')<p class="mt-1 text-xs text-[#AD3B3B]">{{ $message }}</p>@enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="w-full px-3 py-2 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                        @error('email')<p class="mt-1 text-xs text-[#AD3B3B]">{{ $message }}</p>@enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-xs font-semibold mb-1">No. HP</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="0812-3456-7890"
                            class="w-full px-3 py-2 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                        @error('phone')<p class="mt-1 text-xs text-[#AD3B3B]">{{ $message }}</p>@enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label for="address" class="block text-xs font-semibold mb-1">Alamat <span class="font-normal text-[#5B6D73]">(opsional)</span></label>
                        <input id="address" type="text" name="address" value="{{ old('address') }}" autocomplete="street-address" placeholder="Jalan, nomor, kecamatan"
                            class="w-full px-3 py-2 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                        @error('address')<p class="mt-1 text-xs text-[#AD3B3B]">{{ $message }}</p>@enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-semibold mb-1">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full px-3 py-2 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                        @error('password')<p class="mt-1 text-xs text-[#AD3B3B]">{{ $message }}</p>@enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold mb-1">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full px-3 py-2 rounded-lg border border-[#DCE4E2] bg-[#F5F7F6] text-sm focus:outline-none focus:ring-2 focus:ring-[#2E6F7E] focus:border-[#2E6F7E]">
                        @error('password_confirmation')<p class="mt-1 text-xs text-[#AD3B3B]">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex items-center justify-between mt-5">
                    <a href="{{ route('login') }}" class="text-sm text-[#5B6D73] underline hover:text-[#2E6F7E]">Sudah punya akun?</a>

                    <button type="submit" class="px-6 py-2 rounded-lg bg-[#2E6F7E] text-white font-semibold text-sm hover:bg-[#245A67]">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>