<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Dbeli;
use App\Models\Hbeli;
use App\Models\Stock;
use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembelianController extends Controller
{
    public function index()
    {
        $barang = Barang::all(); 
        $suplier = Suplier::all(); 
        return view('pembelian.index', compact('barang', 'suplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodespl' => 'required|exists:tbl_suplier,kodespl',
            'items' => 'required|array|min:1',
            'items.*.kodebrg' => 'required|exists:tbl_barang,kodebrg',
            'items.*.harga' => 'required|numeric|min:1',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            $hbeli = Hbeli::create([
                'notransaksi' => $this->generateTransactionNumber(),
                'kodespl' => $request->kodespl,
                'tglbeli' => now(),
            ]);

            foreach ($request->items as $item) {
                
                Dbeli::create([
                    'notransaksi' => $hbeli->notransaksi,
                    'kodebrg' => $item['kodebrg'],
                    'hargabeli' => $item['harga'],
                    'qty' => $item['qty'],
                    'diskon' => $item['diskon'] ?? 0,
                    'diskonrp' => ($item['harga'] * $item['qty'] * ($item['diskon'] ?? 0)) / 100,
                    'totalrp' => ($item['harga'] * $item['qty']) - (($item['harga'] * $item['qty'] * ($item['diskon'] ?? 0)) / 100),
                ]);
                $stock = Stock::firstOrNew(['kodebrg' => $item['kodebrg']]);
                $stock->qty = ($stock->qty ?? 0) + $item['qty'];
                $stock->save();
            }

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan.']);
        } catch (\Exception $e) {
            Log::error('Kesalahan penyimpanan transaksi: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan transaksi.'], 500);
        }
    }

    private function generateTransactionNumber()
    {
        $latestTransaction = Hbeli::latest('id')->first();
        $newNumber = 'B' . now()->format('Ymd') . str_pad(($latestTransaction ? $latestTransaction->id + 1 : 1), 3, '0', STR_PAD_LEFT);
        return $newNumber;
    }
}
