<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SuplierController;
use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.app');
});

Route::get('/barang', [BarangController::class, 'index']);
Route::get('/suplier', [SuplierController::class, 'index']);
Route::resource('/pembelian', PembelianController::class);
Route::post('/pembelian/store', [PembelianController::class, 'store']);
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/stock/pdf', [StockController::class, 'exportPdf'])->name('stock.pdf');
Route::get('/stock/excel', [StockController::class, 'exportExcel'])->name('stock.excel');


