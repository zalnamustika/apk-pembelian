<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dbeli extends Model
{
    use HasFactory;

    protected $table = 'tbl_dbeli';

    protected $fillable = [
        'notransaksi',
        'kodebrg',
        'hargabeli',
        'qty',
        'diskon',
        'diskonrp',
        'totalrp',
    ];

    public $timestamps = true;
    public function hbeli()
    {
        return $this->belongsTo(Hbeli::class, 'notransaksi', 'notransaksi');
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kodebrg', 'kodebrg');
    }
}

