<?php


namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        $stok = Stock::with('barang')->get();
        $data = [];
        $no = 1;

        foreach ($stok as $item) {
            $data[] = [
                'no' => $no++,
                'namabrg' => $item->barang->namabrg,
                'qty' => $item->qty,
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Nama Barang',
            'QTY',
        ];
    }
}
