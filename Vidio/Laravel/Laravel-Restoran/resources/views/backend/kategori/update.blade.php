@extends('backend.back')
@section('admincontent')
<div class="row">
    <div class="col-6">
        <form action="{{ url('admin/kategori/'.$kategori->idkategori) }}" method="post">
            @csrf
            @method('PUT')
            <div>
                <label class="form-label" for="">Kategori</label>
                <input class="form-control" value="{{ $kategori->kategori }}" type="text" name="kategori">
                <span class="text-danger">@error('kategori')
                    {{ $message }}
                @enderror</span>
            </div>
            <div>
                <button class="btn btn-primary mt-2" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection