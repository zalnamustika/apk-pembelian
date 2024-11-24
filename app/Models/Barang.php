<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'tbl_barang';

    protected $fillable = [
        'kodebrg',
        'namabrg',
        'satuan',
        'hargabeli',
    ];
    public $timestamps = true;
    public function stok()
    {
        return $this->hasOne(Stock::class, 'kodebrg', 'kodebrg');
    }
}

