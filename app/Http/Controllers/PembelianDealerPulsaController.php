<?php

namespace App\Http\Controllers;

use App\Models\PembelianDealerPulsa;
use Illuminate\Http\Request;

class PembelianDealerPulsaController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id != 3) {
            $data_pembelian = PembelianDealerPulsa::with(['supplier', 'dealer', 'kartu', 'pulsa'])->get();
        }
        if (auth()->user()->role_id == 3) {
            $data_pembelian = PembelianDealerPulsa::with(['supplier', 'dealer', 'kartu', 'pulsa'])->where('dealer_id', auth()->user()->dealer_id)->get();
        }
        return view('pembelian-dealer-pulsa.index', [
            'data_pembelian' => $data_pembelian,
        ]);
    }
}
