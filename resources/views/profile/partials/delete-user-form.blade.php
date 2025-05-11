<p class="mb-3 text-muted">
    Setelah akun Anda dihapus, semua data akan dihapus secara permanen. Pastikan Anda telah mengunduh atau
    menyimpan informasi penting sebelum melanjutkan.
</p>

{{-- ALERT VALIDATION ERROR --}}
@if ($errors->userDeletion->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->userDeletion->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- FORM DELETE --}}
<form method="POST" action="{{ route('profile.destroy') }}">
    @csrf
    @method('DELETE')

    <div class="mb-3">
        <label for="password" class="form-label">Konfirmasi Password</label>
        <input id="password" name="password" type="password"
            class="form-control @error('password', 'userDeletion') is-invalid @enderror"
            placeholder="Masukkan password untuk konfirmasi" required>
        @error('password', 'userDeletion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
            Batal
        </a>

        <button type="submit" class="btn btn-danger">
            Hapus Akun
        </button>
    </div>
</form>
