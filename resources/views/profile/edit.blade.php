@extends('layouts.customer')

@section('title', 'Profil')

@section('content')
    <div class="card">
        <h3>Informasi Profil</h3>
        <p class="desc">Perbarui nama, email, dan kontak akunmu.</p>
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="card">
        <h3>Ubah Password</h3>
        <p class="desc">Gunakan password yang panjang dan acak supaya akunmu tetap aman.</p>
        @include('profile.partials.update-password-form')
    </div>

    <div class="card danger-zone">
        <h3>Hapus Akun</h3>
        <p class="desc">Setelah akun dihapus, seluruh data terkait tidak dapat dikembalikan. Pastikan sudah yakin sebelum melanjutkan.</p>
        @include('profile.partials.delete-user-form')
    </div>
@endsection