@if (session('status') === 'profile-updated')
    <p class="flash">Profil berhasil diperbarui.</p>
@endif

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="field">
        <label for="name">Nama</label>
        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email') <p class="error">{{ $message }}</p> @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <p style="font-size:12.5px;color:var(--muted);margin-top:6px;">
                Emailmu belum terverifikasi.
                <button form="send-verification" style="color:var(--primary);text-decoration:underline;background:none;border:none;cursor:pointer;font:inherit;padding:0;">
                    Kirim ulang email verifikasi
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="flash" style="margin-top:8px;">Link verifikasi baru sudah dikirim ke emailmu.</p>
            @endif
        @endif
    </div>

    <div class="field">
        <label for="phone">No. HP</label>
        <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}" required autocomplete="tel" placeholder="0812-3456-7890">
        @error('phone') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="address">Alamat <span style="font-weight:400;color:var(--muted);">(opsional)</span></label>
        <textarea id="address" name="address" autocomplete="street-address" placeholder="Jalan, nomor, kelurahan, kecamatan">{{ old('address', $user->address) }}</textarea>
        @error('address') <p class="error">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="btn primary">Simpan</button>
</form>

@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}"></form>
@endif