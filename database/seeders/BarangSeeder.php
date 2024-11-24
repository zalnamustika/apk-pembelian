<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $barangData = [
            ['kodebrg' => 'BRG001', 'namabrg' => 'Barang A', 'satuan' => 'pcs', 'hargabeli' => 10000],
            ['kodebrg' => 'BRG002', 'namabrg' => 'Barang B', 'satuan' => 'pcs', 'hargabeli' => 20000],
            ['kodebrg' => 'BRG003', 'namabrg' => 'Barang C', 'satuan' => 'pcs', 'hargabeli' => 15000],
        ];
        $stockData = [
            ['kodebrg' => 'BRG001', 'qty' => 50],
            ['kodebrg' => 'BRG002', 'qty' => 30],
            ['kodebrg' => 'BRG003', 'qty' => 20],
        ];
        foreach ($barangData as $barang) {
            DB::table('tbl_barang')->updateOrInsert(
                ['kodebrg' => $barang['kodebrg']],
                $barang
            );
        }
        foreach ($stockData as $stock) {
            DB::table('tbl_stock')->updateOrInsert(
                ['kodebrg' => $stock['kodebrg']],
                $stock
            );
        }
    }
}
