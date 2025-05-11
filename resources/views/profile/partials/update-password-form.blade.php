<p class="mb-3 text-muted">
    Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.
</p>

@if (session('status') === 'password-updated')
    <div class="alert alert-success">
        Password berhasil diperbarui.
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    {{-- Current Password --}}
    <div class="mb-3">
        <label for="current_password" class="form-label">Password Saat Ini</label>
        <input type="password" name="current_password" id="current_password"
            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
            autocomplete="current-password" required>
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- New Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input type="password" name="password" id="password"
            class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password"
            required>
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
            class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
            autocomplete="new-password" required>
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Submit --}}
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
