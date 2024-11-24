<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'tbl_stock';

    protected $fillable = [
        'kodebrg',
        'qty',
    ];

    public $timestamps = true;

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kodebrg', 'kodebrg');
    }
}

