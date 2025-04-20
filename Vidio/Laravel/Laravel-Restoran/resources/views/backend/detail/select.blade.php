@extends('backend.back')

@section('admincontent')
    <div>
        <h1>Order Detail</h1>
    </div>
        <form action="{{ url('admin/orderdetail/create') }}" method="get">
            <div class="row">
            <div class="col-4">
                <label class="form-label" for="">Tanggalawal</label>
         <input class="form-control" type="date" name="tglmulai">
      </div>
            <div class="col-4">
                <label class="form-label" for="">TanggalAkhir</label>
                <input class="form-control" type="date" name="tglakhir">
      </div>
            <div class="col-4 mt-4">
                <button class="btn btn-primary mt-2" type="submit">Cari</button>
            </div>
        </div>
        </form>
            <div>
                 <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            @php
                $no=1;
            @endphp
            <tbody>
                @foreach ($details as $detail)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $detail->tglorder }}</td>
                        <td>{{ $detail->pelanggan }}</td>
                     <td>{{ $detail->menu }}</td>
                        <td>{{ $detail->harga }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>{{ $detail->total}}</td>
                    </tr>
                @endforeach
       </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center ">
        {{ $details->withQueryString()->links() }}
    </div>
@endsection