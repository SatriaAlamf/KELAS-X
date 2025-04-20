@extends('backend.back')
@section('admincontent')
<div class="row">
    <div class="col-6">
        <form action="{{ url('admin/user') }}" method="post">
            @csrf
            <div >
                <label class="form-label" for="">Level</label>
                <select name="level" id="" class="form-select">
                    <option value="manager">manager</option>
                    <option value="kasir">kasir</option>
                    <option value="admin">admin</option>
                </select>
                @error('name')
                    {{ $message }}
                @enderror</span>
            </div>
            <div>
                <label class="form-label" for="">Nama</label>
                <input class="form-control" value="{{ old('name') }}" type="text" name="name">
                <span class="text-danger">@error('name')
                    {{ $message }}
                @enderror</span>
            </div>
            <div>
                <label class="form-label" for="">email</label>
                <input class="form-control" value="{{ old('email') }}" type="text" name="email">
                <span class="text-danger">@error('email')
                    {{ $message }}
                @enderror</span>
            </div>
            <div>
                <label class="form-label" for="">pasword</label>
                <input class="form-control" value="{{ old('password') }}" type="password" name="password">
                <span class="text-danger">@error('password')
                    {{ $message }}
                @enderror</span>
            </div>
            <div>
                <button class="btn btn-primary mt-2" type="submit">simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection