<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel; 

class StockController extends Controller
{
    public function index()
    {
        $stok = Stock::with('barang')->get();
        return view('stock.index', compact('stok'));
    }

    public function exportPdf()
    {
        
        $stok = Stock::with('barang')->get();
        $pdf = Pdf::loadView('stock.pdf', compact('stok'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-stok.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new \App\Exports\StockExport, 'laporan-stok.xlsx');
    }
}
