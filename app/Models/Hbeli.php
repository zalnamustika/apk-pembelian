<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Hbeli extends Model
{
    protected $table = 'tbl_hbeli';

    protected $fillable = [
        'notransaksi',
        'kodespl',
        'tglbeli',
    ];

    public static function generateTransactionNumber()
    {
        $prefix = 'B';
        $year = Carbon::now()->format('Y'); 
        $month = Carbon::now()->format('m'); 

        $lastTransaction = self::whereYear('tglbeli', $year)
            ->whereMonth('tglbeli', $month)
            ->orderBy('notransaksi', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->notransaksi, 7); 
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); 
        } else {
            $nextNumber = '001';
        }

        return $prefix . $year . $month . $nextNumber;
    }
}
