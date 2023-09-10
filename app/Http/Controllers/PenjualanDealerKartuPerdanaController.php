<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanDealerKartuPerdana;

class PenjualanDealerKartuPerdanaController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id != 3) {
            $data_penjualan = PenjualanDealerKartuPerdana::with(['dealer', 'biller', 'kartu'])->get();
        }
        if (auth()->user()->role_id == 3) {
            $data_penjualan = PenjualanDealerKartuPerdana::with(['dealer', 'biller', 'kartu'])->where('dealer_id', auth()->user()->dealer_id)->get();
        }
        return view('penjualan-dealer-kartu-perdana.index', [
            'data_penjualan' => $data_penjualan,
        ]);
    }
}
