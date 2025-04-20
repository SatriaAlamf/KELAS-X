@extends('backend.back')
@section('admincontent')
<div class="row">
    <div class="col-6">
        <form action="{{ url('admin/user/'.$user->id) }}" method="post">
            @csrf
            @method('PUT')
            <div>
                <label class="form-label" for="">pasword</label>
                <input class="form-control" type="password" name="password">
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