<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    public function index() {
        $suplier = Suplier::all();
        return view('suplier.index', compact('suplier'));
    }
}
