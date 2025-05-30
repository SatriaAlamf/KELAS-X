@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Login</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <form action="{{ route('login') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label">Ingat Saya</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p class="text-center mt-3">Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a></p>
    </form>
</div>
@endsection
