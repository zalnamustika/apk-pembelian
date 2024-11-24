<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('stok');

        if ($request->has('search')) {
            $query->where('namabrg', 'like', '%' . $request->search . '%');
        }

        $barang = $query->get();

        return view('barang.index', compact('barang'));
    }
}
