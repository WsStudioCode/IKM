@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
        </ol>
    </nav>

    {{-- INFORMASI PROFIL --}}
    <div class="card mb-4">
        <div class="card-header">Informasi Profil</div>
        <div class="card-body">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    {{-- GANTI PASSWORD --}}
    <div class="card mb-4">
        <div class="card-header">Ganti Password</div>
        <div class="card-body">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    {{-- HAPUS AKUN --}}
    <div class="card mb-4">
        <div class="card-header">Hapus Akun</div>
        <div class="card-body">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
