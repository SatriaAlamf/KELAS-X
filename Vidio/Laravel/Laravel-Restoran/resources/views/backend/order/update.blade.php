@extends('backend.back')
@section('admincontent')
<div class="row">
    <div>
        <h1>{{ number_format($order->total) }}</h1>
    </div>
    <div class="col-6">
        <form action="{{ url('admin/order/'.$order->idorder) }}" method="post">
            @csrf
        @method('PUT')
        <div>
                <label class="form-label" for="">Total</label>
        <input class="form-control" min="{{ $order->total }}" value="{{ $order->total }}" type="number" name="bayar">
             <span class="text-danger">@error('kategori')
                 {{ $message }}
                @enderror</span>
            </div>
            <div>
                <button class="btn btn-primary mt-2" type="submit">Bayar</button>
            </div>
        </form>
    </div>
</div>
@endsection