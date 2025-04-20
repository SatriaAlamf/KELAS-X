@extends('backend.back')
@section('admincontent')
<div>
    <h2>insertMenu</h2>
</div>
<div class="row">
    <div class="col-6">
        <form action="{{ url('admin/menu') }}" method="post" enctype="multipart/form-data">
            @csrf
                   <select class="form-select" name="idkategori">
              @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->idkategori }}">{{ $kategori->kategori }}</option>
        @endforeach
            </select>
            div>
                <label class="form-label" for="">Menu</label>
                <input class="form-control" type="text" name="menu">
              <span class="text-danger">@error('menu')
                    {{ $message }}
              @enderror</span>
            </div>
            <div>
                <label class="form-label" for="">deskripsi</label>
                <input class="form-control" type="text" name="deskripsi">
                <span class="text-danger">@error('deskripsi')
                    {{ $message }}
                @enderror</span>
          </div>
            <div>
                <label class="form-label" for="">Harga</label>
                <input class="form-control" type="number" name="harga">
                <span class="text-danger">@error('harga')
                    {{ $message }}
                @enderror</span>
            </div>
            <div>
                <label class="form-label" for="">Menu</label>
                <input class="form-control" type="file" name="gambar">
                <span class="text-danger">@error('gambar')
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