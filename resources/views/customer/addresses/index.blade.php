@extends('layouts.customer')

@section('title', 'Alamat Saya')

@section('content')
<div class="pagehead">
    <h1>Alamat Saya</h1>
    <p>Alamat yang dipakai kurir untuk menjemput dan mengantar cucianmu.</p>
</div>

<div class="card" style="max-width:720px;">
    <div class="section-title">Tambah Alamat</div>
    <form method="POST" action="{{ route('customer.addresses.store') }}">
        @csrf

        <div class="field">
            <label for="label">Label</label>
            <input type="text" id="label" name="label" value="{{ old('label') }}" placeholder="Contoh: Rumah, Kos, Kantor" required>
        </div>

        <div class="field" style="position:relative;">
            <label for="map-search">Cari lokasi di peta</label>
            <div style="display:flex;gap:8px;">
                <input type="text" id="map-search" placeholder="Ketik nama jalan, tempat, atau kelurahan" autocomplete="off">
                <button type="button" class="btn primary" id="map-search-btn">Cari</button>
                <button type="button" class="btn" id="map-locate-btn" style="white-space:nowrap;">Lokasi Saya</button>
            </div>
            <div id="map-results"></div>
        </div>

        <div id="map"></div>
        <p id="map-status">Klik peta atau geser pin untuk menentukan titik penjemputan.</p>

        <div class="field">
            <label for="full_address">Alamat Lengkap</label>
            <textarea id="full_address" name="full_address" placeholder="Terisi otomatis dari peta, tambahkan nomor rumah atau patokan bila perlu" required>{{ old('full_address') }}</textarea>
        </div>

        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">

        <label style="display:flex;align-items:center;gap:8px;font-size:13.5px;margin-bottom:16px;">
            <input type="checkbox" name="is_primary" value="1" {{ old('is_primary') ? 'checked' : '' }} style="width:auto;">
            Jadikan alamat utama
        </label>

        <button type="submit" class="btn primary">Simpan Alamat</button>
    </form>
</div>

<div class="card">
    <div class="section-title">Daftar Alamat</div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Alamat</th>
                    <th>Koordinat</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($addresses as $address)
                    <tr>
                        <td style="white-space:nowrap;">
                            <b>{{ $address->label }}</b>
                            @if($address->is_primary)
                                <span class="badge" data-s="ready" style="margin-left:6px;">Utama</span>
                            @endif
                        </td>
                        <td>{{ $address->full_address }}</td>
                        <td style="white-space:nowrap;">
                            @if($address->latitude !== null && $address->longitude !== null)
                                <a href="https://www.google.com/maps?q={{ $address->latitude }},{{ $address->longitude }}" target="_blank" style="color:var(--primary);">
                                    {{ $address->latitude }}, {{ $address->longitude }}
                                </a>
                            @else
                                —
                            @endif
                        </td>
                        <td style="text-align:right;white-space:nowrap;">
                            @unless($address->is_primary)
                                <form method="POST" action="{{ route('customer.addresses.primary', $address) }}" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn">Jadikan Utama</button>
                                </form>
                            @endunless
                            <form method="POST" action="{{ route('customer.addresses.destroy', $address) }}" style="display:inline;"
                                  onsubmit="return confirm('Hapus alamat {{ $address->label }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty">Belum ada alamat tersimpan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
<style>
    #map{height:280px;border-radius:10px;border:1px solid var(--line);}
    #map-status{font-size:12.5px;color:var(--muted);margin:6px 0 14px;}
    #map-results{display:none;position:absolute;left:0;right:0;top:100%;z-index:1100;background:var(--surface);border:1px solid var(--line);border-radius:8px;max-height:220px;overflow-y:auto;box-shadow:0 6px 18px rgba(0,0,0,.12);}
    .map-result{padding:9px 12px;font-size:13px;cursor:pointer;border-bottom:1px solid var(--line);}
    .map-result:last-child{border-bottom:none;}
    .map-result:hover{background:var(--bg);}
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
(function () {
    // Titik awal peta sebelum pengguna memilih lokasi, sesuaikan dengan area layananmu
    const DEFAULT_CENTER = [3.5952, 98.6722];
    const NOMINATIM = 'https://nominatim.openstreetmap.org';

    const latEl = document.getElementById('latitude');
    const lngEl = document.getElementById('longitude');
    const addrEl = document.getElementById('full_address');
    const searchEl = document.getElementById('map-search');
    const resultsEl = document.getElementById('map-results');
    const statusEl = document.getElementById('map-status');

    const initialLat = parseFloat(latEl.value);
    const initialLng = parseFloat(lngEl.value);
    const hasInitial = !isNaN(initialLat) && !isNaN(initialLng);

    // Alamat yang sudah diketik manual tidak ditimpa otomatis oleh hasil peta
    let addressEdited = addrEl.value.trim() !== '';
    addrEl.addEventListener('input', () => { addressEdited = addrEl.value.trim() !== ''; });

    const map = L.map('map').setView(hasInitial ? [initialLat, initialLng] : DEFAULT_CENTER, hasInitial ? 17 : 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = null;
    let reverseController = null;

    const setStatus = (text) => { statusEl.textContent = text; };
    const pointText = () => 'Titik dipilih: ' + latEl.value + ', ' + lngEl.value;

    function setPoint(lat, lng, opts) {
        const zoom = opts && opts.zoom;
        const reverse = !opts || opts.reverse !== false;

        if (!marker) {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', () => {
                const p = marker.getLatLng();
                setPoint(p.lat, p.lng);
            });
        } else {
            marker.setLatLng([lat, lng]);
        }

        latEl.value = lat.toFixed(7);
        lngEl.value = lng.toFixed(7);
        if (zoom) map.setView([lat, lng], zoom);
        setStatus(pointText());

        if (reverse) reverseGeocode(lat, lng);
    }

    async function reverseGeocode(lat, lng) {
        if (addressEdited) return;
        if (reverseController) reverseController.abort();
        reverseController = new AbortController();
        setStatus('Mencari alamat...');
        try {
            const res = await fetch(NOMINATIM + '/reverse?format=jsonv2&accept-language=id&lat=' + lat + '&lon=' + lng, { signal: reverseController.signal });
            if (!res.ok) throw new Error('reverse failed');
            const data = await res.json();
            if (data.display_name && !addressEdited) addrEl.value = data.display_name;
            setStatus(pointText());
        } catch (e) {
            if (e.name !== 'AbortError') setStatus(pointText() + '. Alamat tidak bisa diambil otomatis, silakan isi manual.');
        }
    }

    async function search() {
        const q = searchEl.value.trim();
        if (q.length < 3) { setStatus('Ketik minimal 3 huruf untuk mencari.'); return; }
        setStatus('Mencari...');
        try {
            const res = await fetch(NOMINATIM + '/search?format=jsonv2&limit=5&countrycodes=id&accept-language=id&q=' + encodeURIComponent(q));
            if (!res.ok) throw new Error('search failed');
            renderResults(await res.json());
        } catch (e) {
            setStatus('Pencarian gagal, coba lagi sebentar lagi atau klik langsung di peta.');
        }
    }

    function renderResults(items) {
        resultsEl.innerHTML = '';
        if (!items.length) {
            resultsEl.style.display = 'none';
            setStatus('Lokasi tidak ditemukan. Coba kata kunci lain atau klik langsung di peta.');
            return;
        }
        items.forEach((item) => {
            const div = document.createElement('div');
            div.className = 'map-result';
            div.textContent = item.display_name;
            div.addEventListener('click', () => {
                resultsEl.style.display = 'none';
                setPoint(parseFloat(item.lat), parseFloat(item.lon), { zoom: 17, reverse: false });
                if (!addressEdited) addrEl.value = item.display_name;
            });
            resultsEl.appendChild(div);
        });
        resultsEl.style.display = 'block';
        setStatus('Pilih salah satu hasil pencarian di bawah kolom.');
    }

    map.on('click', (e) => setPoint(e.latlng.lat, e.latlng.lng));

    document.getElementById('map-search-btn').addEventListener('click', search);
    searchEl.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') { e.preventDefault(); search(); }
    });
    document.addEventListener('click', (e) => {
        if (!resultsEl.contains(e.target) && e.target !== searchEl) resultsEl.style.display = 'none';
    });

    document.getElementById('map-locate-btn').addEventListener('click', () => {
        if (!navigator.geolocation) { setStatus('Browser tidak mendukung deteksi lokasi.'); return; }
        setStatus('Mengambil lokasi...');
        navigator.geolocation.getCurrentPosition(
            (pos) => setPoint(pos.coords.latitude, pos.coords.longitude, { zoom: 17 }),
            () => setStatus('Lokasi tidak bisa diambil. Izinkan akses lokasi di browser, atau cari manual.'),
            { enableHighAccuracy: true, timeout: 10000 }
        );
    });

    // Tampilkan kembali titik yang sudah terisi (misalnya setelah validasi gagal)
    if (hasInitial) setPoint(initialLat, initialLng, { reverse: false });
})();
</script>
@endpush