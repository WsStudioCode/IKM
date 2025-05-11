{{-- Verifikasi Email Ulang --}}
@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>
@endif

{{-- Notifikasi Berhasil --}}
@if (session('status') === 'profile-updated')
    <div class="alert alert-success">
        Data profil berhasil diperbarui.
    </div>
@endif

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    {{-- Nama --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-2 text-muted">
                Alamat email Anda belum diverifikasi.
                <button type="submit" form="send-verification" class="btn btn-link p-0 align-baseline">
                    Klik di sini untuk kirim ulang verifikasi.
                </button>
            </div>

            @if (session('status') === 'verification-link-sent')
                <div class="text-success mt-2">
                    Link verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif
        @endif
    </div>

    {{-- Tombol Simpan --}}
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
