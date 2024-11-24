<?php

namespace Database\Seeders;

use App\Models\Hbeli;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembelianSeeder extends Seeder
{
    public function run()
    {
        $notransaksi = Hbeli::generateTransactionNumber();

        DB::table('tbl_hbeli')->insert([
            'notransaksi' => $notransaksi,
            'kodespl' => 'SPL001',
            'tglbeli' => now(),
        ]);
        
    }
}
