<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laundry Amplas — Laundry Cepat, Bersih, Terpercaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .font-display { font-family: 'Space Grotesk', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-[#F5F7F6] text-[#16232B] antialiased">

    {{-- Navbar --}}
    <header class="sticky top-0 z-30 bg-[#F5F7F6]/90 backdrop-blur border-b border-[#DCE4E2]">
        <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 font-display font-bold text-lg">
                <span class="w-8 h-8 rounded-lg bg-[#2E6F7E] text-white flex items-center justify-center text-sm">LA</span>
                Laundry Amplas
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-[#3F4F55]">
                <a href="/" class="hover:text-[#2E6F7E]">Home</a>
                <a href="#layanan" class="hover:text-[#2E6F7E]">Layanan</a>
                <a href="#tentang" class="hover:text-[#2E6F7E]">Tentang Kami</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold px-4 py-2 rounded-lg bg-[#2E6F7E] text-white hover:bg-[#245A67]">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline text-sm font-semibold text-[#3F4F55] hover:text-[#2E6F7E]">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold px-4 py-2 rounded-lg bg-[#D9781E] text-white hover:bg-[#C06A18]">Pesan Sekarang</a>
                @endauth
            </div>
        </nav>
    </header>

    {{-- Hero / Home --}}
    <section id="home" class="max-w-6xl mx-auto px-6 pt-20 pb-16 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <span class="inline-block text-xs font-semibold tracking-wide text-[#2E6F7E] bg-[#E4EFF0] px-3 py-1 rounded-full">Laundry kiloan &amp; satuan</span>
            <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight mt-5">
                Cucian bersih, wangi, diantar tepat waktu ke depan pintumu.
            </h1>
            <p class="text-[#5B6D73] text-base md:text-lg mt-5 max-w-md">
                Laundry Amplas menjemput, mencuci, dan mengantar kembali cucianmu tanpa ribet. Tinggal pesan lewat aplikasi, sisanya biar kami yang urus.
            </p>
            <div class="flex flex-wrap gap-3 mt-8">
                <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-[#2E6F7E] text-white font-semibold text-sm hover:bg-[#245A67]">Pesan Sekarang</a>
                <a href="#layanan" class="px-6 py-3 rounded-lg border border-[#DCE4E2] font-semibold text-sm hover:border-[#2E6F7E]">Lihat Harga Layanan</a>
            </div>
            <div class="flex gap-8 mt-10 text-sm">
                <div><div class="font-display font-bold text-xl">2 Hari</div><div class="text-[#5B6D73]">Estimasi selesai</div></div>
                <div><div class="font-display font-bold text-xl">10rb+</div><div class="text-[#5B6D73]">Pesanan diproses</div></div>
                <div><div class="font-display font-bold text-xl">4.9/5</div><div class="text-[#5B6D73]">Rating pelanggan</div></div>
            </div>
        </div>

        <div class="bg-white border border-[#DCE4E2] rounded-2xl p-6">
            <p class="text-xs font-semibold uppercase tracking-wide text-[#5B6D73] mb-4">Perkiraan biaya layanan</p>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-[#EEF2F1]">
                    <span class="text-sm font-medium">Cuci Kering <span class="text-[#5B6D73] font-normal">/ kg</span></span>
                    <span class="font-display font-semibold">Rp7.000</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-[#EEF2F1]">
                    <span class="text-sm font-medium">Cuci Kering + Lipat <span class="text-[#5B6D73] font-normal">/ kg</span></span>
                    <span class="font-display font-semibold">Rp9.000</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-[#EEF2F1]">
                    <span class="text-sm font-medium">Cuci Setrika <span class="text-[#5B6D73] font-normal">/ kg</span></span>
                    <span class="font-display font-semibold">Rp12.000</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium">Cuci Sepatu <span class="text-[#5B6D73] font-normal">/ pasang</span></span>
                    <span class="font-display font-semibold">Rp25.000</span>
                </div>
            </div>
            <p class="text-xs text-[#5B6D73] mt-4">*Harga dapat berubah sesuai berat aktual saat penimbangan oleh kurir.</p>
        </div>
    </section>

    {{-- Layanan --}}
    <section id="layanan" class="bg-white border-y border-[#DCE4E2]">
        <div class="max-w-6xl mx-auto px-6 py-20">
            <div class="max-w-lg mb-12">
                <h2 class="font-display text-3xl font-bold">Layanan kami</h2>
                <p class="text-[#5B6D73] mt-3">Pilih jenis layanan sesuai kebutuhan cucianmu, harga transparan tanpa biaya tersembunyi.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="border border-[#DCE4E2] rounded-xl p-6">
                    <h3 class="font-display font-semibold mt-4">Cuci Kering</h3>
                    <p class="text-sm text-[#5B6D73] mt-2">Cuci bersih dan pengeringan, cocok untuk pakaian harian.</p>
                    <p class="font-display font-bold mt-4">Rp7.000<span class="text-sm font-normal text-[#5B6D73]">/kg</span></p>
                    {{-- <button class="bg-[#2E6F7E] text-white p-1.5 rounded cursor-pointer mt-6">Pesan sekarang</button> --}}
                </div>
                <div class="border border-[#DCE4E2] rounded-xl p-6">
                    <h3 class="font-display font-semibold mt-4">Cuci Kering + Lipat</h3>
                    <p class="text-sm text-[#5B6D73] mt-2">Sudah dicuci, dikeringkan, dan dilipat rapi siap simpan.</p>
                    <p class="font-display font-bold mt-4">Rp9.000<span class="text-sm font-normal text-[#5B6D73]">/kg</span></p>
                    {{-- <button class="bg-[#2E6F7E] text-white p-1.5 rounded cursor-pointer mt-6">Pesan sekarang</button> --}}

                </div>
                <div class="border border-[#DCE4E2] rounded-xl p-6">
                    <h3 class="font-display font-semibold mt-4">Cuci Setrika</h3>
                    <p class="text-sm text-[#5B6D73] mt-2">Dicuci, dikeringkan, dan disetrika rapi untuk baju kerja.</p>
                    <p class="font-display font-bold mt-4">Rp12.000<span class="text-sm font-normal text-[#5B6D73]">/kg</span></p>
                    {{-- <button class="bg-[#2E6F7E] text-white p-1.5 rounded cursor-pointer mt-6">Pesan sekarang</button> --}}

                </div>
                {{-- <div class="border border-[#DCE4E2] rounded-xl p-6">
                    <h3 class="font-display font-semibold mt-4">Cuci Sepatu</h3>
                    <p class="text-sm text-[#5B6D73] mt-2">Pembersihan khusus sepatu, dicuci per pasang.</p>
                    <p class="font-display font-bold mt-4">Rp25.000<span class="text-sm font-normal text-[#5B6D73]">/pasang</span></p>
                </div> --}}
            </div>
        </div>
    </section>

    {{-- Tentang Kami --}}
    <section id="tentang" class="max-w-6xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="font-display text-3xl font-bold">Tentang Laundry Amplas</h2>
            <p class="text-[#5B6D73] mt-4 leading-relaxed">
                Laundry Amplas hadir sejak 2021 untuk membantu warga sekitar mencuci pakaian tanpa buang waktu. Kami menjemput cucian dari rumahmu, mencucinya dengan deterjen berkualitas, lalu mengantarnya kembali sesuai jadwal.
            </p>
            <p class="text-[#5B6D73] mt-4 leading-relaxed">
                Setiap pesanan bisa dipantau statusnya secara langsung, mulai dari dijemput, ditimbang, dicuci, sampai diantar kembali.
            </p>
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div class="border border-[#DCE4E2] rounded-xl p-6">
                <div class="font-display font-bold text-2xl text-[#2E6F7E]">5+</div>
                <div class="text-sm text-[#5B6D73] mt-1">Tahun beroperasi</div>
            </div>
            <div class="border border-[#DCE4E2] rounded-xl p-6">
                <div class="font-display font-bold text-2xl text-[#2E6F7E]">10.000+</div>
                <div class="text-sm text-[#5B6D73] mt-1">Pesanan selesai</div>
            </div>
            <div class="border border-[#DCE4E2] rounded-xl p-6">
                <div class="font-display font-bold text-2xl text-[#2E6F7E]">4.9/5</div>
                <div class="text-sm text-[#5B6D73] mt-1">Rating pelanggan</div>
            </div>
            <div class="border border-[#DCE4E2] rounded-xl p-6">
                <div class="font-display font-bold text-2xl text-[#2E6F7E]">3</div>
                <div class="text-sm text-[#5B6D73] mt-1">Cabang aktif</div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-[#16232B] text-[#C6D2D3]">
        <div class="max-w-6xl mx-auto px-6 py-14 grid sm:grid-cols-2 md:grid-cols-4 gap-10">
            <div>
                <div class="flex items-center gap-2 font-display font-bold text-lg text-white">
                    <span class="w-8 h-8 rounded-lg bg-[#2E6F7E] flex items-center justify-center text-sm">LA</span>
                    Laundry Amplas
                </div>
                <p class="text-sm mt-4 text-[#8FA0A4]">Laundry kiloan dan satuan dengan layanan jemput-antar untuk kebutuhan harianmu.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-white">Home</a></li>
                    <li><a href="#layanan" class="hover:text-white">Layanan</a></li>
                    <li><a href="#tentang" class="hover:text-white">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Kontak</h4>
                <ul class="space-y-2 text-sm text-[#8FA0A4]">
                    <li>Jl. Melati No. 12, Jakarta</li>
                    <li>0812-3456-7890</li>
                    <li>halo@laundryAmplas.id</li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Ikuti Kami</h4>
                <ul class="space-y-2 text-sm text-[#8FA0A4]">
                    <li><a href="#" class="hover:text-white">Instagram</a></li>
                    <li><a href="#" class="hover:text-white">WhatsApp</a></li>
                    <li><a href="#" class="hover:text-white">TikTok</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-5 text-center text-xs text-[#8FA0A4]">
            © {{ date('Y') }} Laundry Amplas. Semua hak cipta dilindungi.
        </div>
    </footer>

</body>
</html>