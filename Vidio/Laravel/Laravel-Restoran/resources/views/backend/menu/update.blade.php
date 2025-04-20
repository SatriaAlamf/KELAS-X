@extends('backend.back')
@section('admincontent')
<div>
    <h2>Update Menu</h2>
</div>
<div class="row">
    <div class="col-6">
        <form action="{{ url('admin/postmenu/'.$menu->idmenu) }}" method="post" enctype="multipart/form-data">
          @csrf
            <select class="form-select" name="idkategori">
                @foreach ($kategoris as $kategori)
                    <option @selected($kategori->idkategori==$menu->idkategori) value="{{ $kategori->idkategori }}">{{ $kategori->kategori }}</option>
                @endforeach
            </select>
            <div>
             <label class="form-label" for="">Menu</label>
                <input class="form-control" type="text" value="{{ $menu->menu }}" name="menu">
                <span class="text-danger">@error('menu')
                    {{ $message }}
                @enderror</span>
            </div>
            <div>
         <label class="form-label" for="">deskripsi</label>
                <input class="form-control" type="text" value="{{ $menu->deskripsi }}" name="deskripsi">
                <span class="text-danger">@error('deskripsi')
                    {{ $message }}
                @enderror</span>
            </div>
            <div>
                <label class="form-label" for="">Harga</label>
                <input class="form-control" type="number" value="{{ $menu->harga }}" name="harga">
         <span class="text-danger">@error('harga')
                    {{ $message }}
                @enderror</span>
            </div>
            <div>
                <label class="form-label" for="">Menu</label>
                <input class="form-control" type="file" value="{{ $menu->gambar }}" name="gambar">
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