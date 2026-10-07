<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laundry Berkah — Laundry Cepat, Bersih, Terpercaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .font-display { font-family: 'Space Grotesk', system-ui, sans-serif; }

        /* Scroll-reveal: elemen tersembunyi sampai masuk viewport, lalu JS menambah class .reveal-in */
        .reveal { opacity: 0; transform: translateY(18px); transition: opacity .6s ease, transform .6s ease; }
        .reveal-in { opacity: 1; transform: translateY(0); }

        @keyframes float-slow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-14px); }
        }
        .float-slow { animation: float-slow 6s ease-in-out infinite; }

        #navbar.scrolled { box-shadow: 0 1px 0 rgba(0,0,0,.02), 0 8px 20px -14px rgba(22,35,43,.25); }

        .service-card { transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease; }
        .service-card:hover { transform: translateY(-6px); border-color: #2E6F7E; box-shadow: 0 16px 32px -20px rgba(46,111,126,.35); }

        .stat-card { transition: transform .25s ease, border-color .25s ease; }
        .stat-card:hover { transform: translateY(-4px); border-color: #2E6F7E; }

        #mobile-menu { max-height: 0; overflow: hidden; transition: max-height .3s ease; }
        #mobile-menu.open { max-height: 320px; }
    </style>
</head>
<body class="bg-[#F5F7F6] text-[#16232B] antialiased">

    {{-- Navbar --}}
    <header id="navbar" class="sticky top-0 z-30 bg-[#F5F7F6]/90 backdrop-blur border-b border-[#DCE4E2] transition-shadow">
        <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 font-display font-bold text-lg">
                <span class="w-8 h-8 rounded-lg bg-[#2E6F7E] text-white flex items-center justify-center text-sm">LA</span>
                Laundry Berkah
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-[#3F4F55]">
                <a href="/" class="hover:text-[#2E6F7E] transition-colors">Home</a>
                <a href="#layanan" class="hover:text-[#2E6F7E] transition-colors">Layanan</a>
                <a href="#tentang" class="hover:text-[#2E6F7E] transition-colors">Tentang Kami</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    {{-- <a href="{{ route('dashboard') }}" class="text-sm font-semibold px-4 py-2 rounded-lg bg-[#2E6F7E] text-white hover:bg-[#245A67]">Dashboard</a> --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-block text-sm font-semibold px-4 py-2 rounded-lg bg-[#2E6F7E] text-white hover:bg-[#245A67] transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('customer.dashboard') }}" class="hidden sm:inline-block text-sm font-semibold px-4 py-2 rounded-lg bg-[#2E6F7E] text-white hover:bg-[#245A67] transition-colors">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline text-sm font-semibold text-[#3F4F55] hover:text-[#2E6F7E] transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="hidden sm:inline-block text-sm font-semibold px-4 py-2 rounded-lg bg-[#D9781E] text-white hover:bg-[#C06A18] transition-colors">Pesan Sekarang</a>
                @endauth

                {{-- Tombol menu mobile --}}
                <button id="menu-toggle" class="md:hidden w-9 h-9 flex items-center justify-center rounded-lg border border-[#DCE4E2]" aria-label="Buka menu">
                    <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </nav>

        {{-- Menu mobile --}}
        <div id="mobile-menu" class="md:hidden border-t border-[#DCE4E2] bg-[#F5F7F6]">
            <div class="px-6 py-4 flex flex-col gap-3 text-sm font-medium text-[#3F4F55]">
                <a href="/" class="hover:text-[#2E6F7E]">Home</a>
                <a href="#layanan" class="hover:text-[#2E6F7E]">Layanan</a>
                <a href="#tentang" class="hover:text-[#2E6F7E]">Tentang Kami</a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="font-semibold text-[#2E6F7E]">Dashboard</a>
                    @else
                        <a href="{{ route('customer.dashboard') }}" class="font-semibold text-[#2E6F7E]">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="hover:text-[#2E6F7E]">Masuk</a>
                    <a href="{{ route('register') }}" class="font-semibold text-[#D9781E]">Pesan Sekarang</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Hero / Home --}}
    <section id="home" class="relative overflow-hidden">
        {{-- Dekorasi latar, warna tetap dari palet yang sama --}}
        <div class="pointer-events-none absolute -top-24 -right-24 w-80 h-80 bg-[#2E6F7E]/10 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute top-40 -left-24 w-72 h-72 bg-[#D9781E]/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-6 pt-20 pb-16 grid md:grid-cols-2 gap-12 items-center">
            <div class="reveal">
                <span class="inline-block text-xs font-semibold tracking-wide text-[#2E6F7E] bg-[#E4EFF0] px-3 py-1 rounded-full">Laundry kiloan &amp; satuan</span>
                <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight mt-5">
                    Cucian bersih, wangi, diantar tepat waktu ke depan pintumu.
                </h1>
                <p class="text-[#5B6D73] text-base md:text-lg mt-5 max-w-md">
                    Laundry Berkah menjemput, mencuci, dan mengantar kembali cucianmu tanpa ribet. Tinggal pesan lewat aplikasi, sisanya biar kami yang urus.
                </p>
                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-[#2E6F7E] text-white font-semibold text-sm hover:bg-[#245A67] transition-colors hover:shadow-lg hover:shadow-[#2E6F7E]/20">Pesan Sekarang</a>
                    <a href="#layanan" class="px-6 py-3 rounded-lg border border-[#DCE4E2] font-semibold text-sm hover:border-[#2E6F7E] hover:text-[#2E6F7E] transition-colors">Lihat Harga Layanan</a>
                </div>
                <div class="flex gap-8 mt-10 text-sm">
                    <div><div class="font-display font-bold text-xl">2 Hari</div><div class="text-[#5B6D73]">Estimasi selesai</div></div>
                    <div><div class="font-display font-bold text-xl">10rb+</div><div class="text-[#5B6D73]">Pesanan diproses</div></div>
                    <div><div class="font-display font-bold text-xl">4.9/5</div><div class="text-[#5B6D73]">Rating pelanggan</div></div>
                </div>
            </div>

            <div class="reveal bg-white border border-[#DCE4E2] rounded-2xl p-6 float-slow shadow-xl shadow-[#16232B]/5">
                <p class="text-xs font-semibold uppercase tracking-wide text-[#5B6D73] mb-4">Perkiraan biaya layanan</p>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-[#EEF2F1]">
                        <span class="text-sm font-medium">Cuci Kering <span class="text-[#5B6D73] font-normal">/7kg</span></span>
                        <span class="font-display font-semibold">Rp15.000</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-[#EEF2F1]">
                        <span class="text-sm font-medium">Cuci Kering + Lipat <span class="text-[#5B6D73] font-normal">/7kg</span></span>
                        <span class="font-display font-semibold">Rp20.000</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-[#EEF2F1]">
                        <span class="text-sm font-medium">Cuci Setrika <span class="text-[#5B6D73] font-normal">/7kg</span></span>
                        <span class="font-display font-semibold">Rp25.000</span>
                    </div>
                </div>
                <p class="text-xs text-[#5B6D73] mt-4">*Harga dapat berubah sesuai berat aktual saat penimbangan oleh kurir.</p>
            </div>
        </div>
    </section>

    {{-- Layanan --}}
    <section id="layanan" class="bg-white border-y border-[#DCE4E2]">
        <div class="max-w-6xl mx-auto px-6 py-20">
            <div class="max-w-lg mb-12 reveal">
                <h2 class="font-display text-3xl font-bold">Layanan kami</h2>
                <p class="text-[#5B6D73] mt-3">Pilih jenis layanan sesuai kebutuhan cucianmu, harga transparan tanpa biaya tersembunyi.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="service-card reveal border border-[#DCE4E2] rounded-xl p-6">
                    <span class="w-11 h-11 rounded-lg bg-[#E4EFF0] flex items-center justify-center text-xl">🧺</span>
                    <h3 class="font-display font-semibold mt-4">Cuci Kering</h3>
                    <p class="text-sm text-[#5B6D73] mt-2">Cuci bersih dan pengeringan, cocok untuk pakaian harian.</p>
                    <p class="font-display font-bold mt-4">Rp15.000<span class="text-sm font-normal text-[#5B6D73]">/7kg</span></p>
                </div>
                <div class="service-card reveal border border-[#DCE4E2] rounded-xl p-6">
                    <span class="w-11 h-11 rounded-lg bg-[#E4EFF0] flex items-center justify-center text-xl">🧴</span>
                    <h3 class="font-display font-semibold mt-4">Cuci Kering + Lipat</h3>
                    <p class="text-sm text-[#5B6D73] mt-2">Sudah dicuci, dikeringkan, dan dilipat rapi siap simpan.</p>
                    <p class="font-display font-bold mt-4">Rp20.000<span class="text-sm font-normal text-[#5B6D73]">/7kg</span></p>
                </div>
                <div class="service-card reveal border border-[#DCE4E2] rounded-xl p-6">
                    <span class="w-11 h-11 rounded-lg bg-[#E4EFF0] flex items-center justify-center text-xl">👔</span>
                    <h3 class="font-display font-semibold mt-4">Cuci Setrika</h3>
                    <p class="text-sm text-[#5B6D73] mt-2">Dicuci, dikeringkan, dan disetrika rapi untuk baju kerja.</p>
                    <p class="font-display font-bold mt-4">Rp25.000<span class="text-sm font-normal text-[#5B6D73]">/7kg</span></p>
                </div>
            </div>
        </div>
    </section>

    {{-- Tentang Kami --}}
    <section id="tentang" class="max-w-6xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12 items-center">
        <div class="reveal">
            <h2 class="font-display text-3xl font-bold">Tentang Laundry Berkah</h2>
            <p class="text-[#5B6D73] mt-4 leading-relaxed">
                Laundry Berkah hadir sejak 2021 untuk membantu warga sekitar mencuci pakaian tanpa buang waktu. Kami menjemput cucian dari rumahmu, mencucinya dengan deterjen berkualitas, lalu mengantarnya kembali sesuai jadwal.
            </p>
            <p class="text-[#5B6D73] mt-4 leading-relaxed">
                Setiap pesanan bisa dipantau statusnya secara langsung, mulai dari dijemput, ditimbang, dicuci, sampai diantar kembali.
            </p>
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div class="stat-card reveal border border-[#DCE4E2] rounded-xl p-6 bg-white">
                <div class="font-display font-bold text-2xl text-[#2E6F7E]"><span class="counter" data-target="5">0</span>+</div>
                <div class="text-sm text-[#5B6D73] mt-1">Tahun beroperasi</div>
            </div>
            <div class="stat-card reveal border border-[#DCE4E2] rounded-xl p-6 bg-white">
                <div class="font-display font-bold text-2xl text-[#2E6F7E]"><span class="counter" data-target="10000">0</span>+</div>
                <div class="text-sm text-[#5B6D73] mt-1">Pesanan selesai</div>
            </div>
            <div class="stat-card reveal border border-[#DCE4E2] rounded-xl p-6 bg-white">
                <div class="font-display font-bold text-2xl text-[#2E6F7E]"><span class="counter" data-target="4.9" data-decimal="1">0</span>/5</div>
                <div class="text-sm text-[#5B6D73] mt-1">Rating pelanggan</div>
            </div>
            <div class="stat-card reveal border border-[#DCE4E2] rounded-xl p-6 bg-white">
                <div class="font-display font-bold text-2xl text-[#2E6F7E]"><span class="counter" data-target="3">0</span></div>
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
                    Laundry Berkah
                </div>
                <p class="text-sm mt-4 text-[#8FA0A4]">Laundry kiloan dan satuan dengan layanan jemput-antar untuk kebutuhan harianmu.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="#layanan" class="hover:text-white transition-colors">Layanan</a></li>
                    <li><a href="#tentang" class="hover:text-white transition-colors">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Kontak</h4>
                <ul class="space-y-2 text-sm text-[#8FA0A4]">
                    <li>Berkah, Medan Denai</li>
                    <li>0812-3456-7890</li>
                    <li>halo@laundryBerkah.id</li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Ikuti Kami</h4>
                <ul class="space-y-2 text-sm text-[#8FA0A4]">
                    <li><a href="#" class="hover:text-white transition-colors">Instagram</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">WhatsApp</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">TikTok</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-5 text-center text-xs text-[#8FA0A4]">
            © {{ date('Y') }} Laundry Berkah. Semua hak cipta dilindungi.
        </div>
    </footer>

    {{-- Tombol kembali ke atas --}}
    <button id="back-to-top" aria-label="Kembali ke atas"
        class="fixed bottom-6 right-6 w-11 h-11 rounded-full bg-[#2E6F7E] text-white shadow-lg shadow-[#16232B]/20 flex items-center justify-center opacity-0 translate-y-3 pointer-events-none transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
    </button>

    <script>
        // Menu mobile
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        menuToggle?.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });
        mobileMenu?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('open');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            });
        });

        // Navbar bayangan saat discroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 8);

            const backToTop = document.getElementById('back-to-top');
            const show = window.scrollY > 500;
            backToTop.classList.toggle('opacity-0', !show);
            backToTop.classList.toggle('pointer-events-none', !show);
            backToTop.classList.toggle('translate-y-3', !show);
        }, { passive: true });

        document.getElementById('back-to-top')?.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Scroll-reveal sederhana pakai IntersectionObserver
        const revealEls = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('reveal-in');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        revealEls.forEach((el) => revealObserver.observe(el));

        // Angka berjalan (count-up) untuk statistik Tentang Kami
        const counters = document.querySelectorAll('.counter');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const target = parseFloat(el.dataset.target);
                const decimals = parseInt(el.dataset.decimal || '0', 10);
                const duration = 1200;
                const start = performance.now();

                function tick(now) {
                    const progress = Math.min((now - start) / duration, 1);
                    const value = target * progress;
                    el.textContent = decimals ? value.toFixed(decimals) : Math.round(value).toLocaleString('id-ID');
                    if (progress < 1) requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
                counterObserver.unobserve(el);
            });
        }, { threshold: 0.4 });
        counters.forEach((el) => counterObserver.observe(el));
    </script>

</body>
</html>