@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Registrasi</h2>

    <form action="{{ route('register') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="form-group mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-3">
            <label>No. HP</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Daftar</button>
        <p class="text-center mt-3">Sudah punya akun? <a href="{{ route('login') }}">Login disini</a></p>
    </form>
</div>
@endsection
