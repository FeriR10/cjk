<?php

namespace App\Http\Controllers;

use App\Models\PembelianBillerPulsa;
use Illuminate\Http\Request;

class PembelianBillerPulsaController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id != 3) {
            $data_pembelian = PembelianBillerPulsa::with(['dealer', 'biller', 'kartu', 'pulsa'])->get();
        }
        if (auth()->user()->role_id == 3) {
            $data_pembelian = PembelianBillerPulsa::with(['dealer', 'biller', 'kartu', 'pulsa'])->where('biller_id', auth()->user()->biller_id)->get();
        }
        return view('pembelian-biller-pulsa.index', [
            'data_pembelian' => $data_pembelian,
        ]);
    }
}
