@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('stock.pdf') }}" class="btn btn-danger">Cetak PDF</a>
    <a href="{{ route('stock.excel') }}" class="btn btn-success">Export ke Excel</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stok as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kodebrg }}</td>
                    <td>{{ $item->barang->namabrg }}</td>
                    <td>{{ $item->qty }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
