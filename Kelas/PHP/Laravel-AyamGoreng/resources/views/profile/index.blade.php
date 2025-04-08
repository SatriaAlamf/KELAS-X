@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Profil Saya</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Update Profil --}}
    <div class="card mb-4">
        <div class="card-header">Update Profil</div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- Ganti Password --}}
    <div class="card">
        <div class="card-header">Ganti Password</div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf

                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control" required>
                    @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-warning">Ganti Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
