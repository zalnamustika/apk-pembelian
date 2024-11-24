<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    use HasFactory;

    protected $table = 'tbl_suplier';

    protected $fillable = [
        'kodespl',
        'namaspl',
    ];

    public $timestamps = true;
}

