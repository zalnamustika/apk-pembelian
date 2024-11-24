@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Barang</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Harga Beli</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $item)
                <tr>
                    <td>{{ $item->kodebrg }}</td>
                    <td>{{ $item->namabrg }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>Rp {{ number_format($item->hargabeli, 0, ',', '.') }}</td>
                    <td>{{ $item->stok ? $item->stok->qty : 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
