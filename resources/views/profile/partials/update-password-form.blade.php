@if (session('status') === 'password-updated')
    <p class="flash">Password berhasil diperbarui.</p>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="field">
        <label for="update_password_current_password">Password Saat Ini</label>
        <input id="update_password_current_password" type="password" name="current_password" autocomplete="current-password">
        @error('current_password', 'updatePassword') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="update_password_password">Password Baru</label>
        <input id="update_password_password" type="password" name="password" autocomplete="new-password">
        @error('password', 'updatePassword') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="update_password_password_confirmation">Konfirmasi Password Baru</label>
        <input id="update_password_password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
        @error('password_confirmation', 'updatePassword') <p class="error">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="btn primary">Simpan Password</button>
</form>