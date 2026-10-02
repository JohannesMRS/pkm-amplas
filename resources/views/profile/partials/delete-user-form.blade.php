<form method="POST" action="{{ route('profile.destroy') }}"
      onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')">
    @csrf
    @method('delete')

    <div class="field">
        <label for="password">Konfirmasi Password</label>
        <input id="password" type="password" name="password" placeholder="Masukkan password untuk konfirmasi">
        @error('password', 'userDeletion') <p class="error">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="btn danger">Hapus Akun</button>
</form>