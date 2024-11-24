@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Daftar Supplier</div>
    <div class="card-body">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suplier as $item)
                <tr>
                    <td>{{ $item->kodespl }}</td>
                    <td>{{ $item->namaspl }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
