@extends('backend.back')
@section('admincontent')
<div class="row">
    <div class="col-6">
        <form action="{{ url('admin/kategori') }}" method="post">
            @csrf
            <div>
                <label class="form-label" for="">kategori</label>
                <input class="form-control" value="{{ old('kategori') }}" type="text" name="kategori">
                <span class="text-danger">@error('kategori')
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