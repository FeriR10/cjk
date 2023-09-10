<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDealerPulsa;
use Illuminate\Http\Request;

class PenjualanDealerPulsaController extends Controller
{
    public function index()
    {
        // $total_keuntungan = PenjualanDealerPulsa::sum('keuntungan');
        if (auth()->user()->role_id != 3) {
            $total_keuntungan = PenjualanDealerPulsa::sum('keuntungan');
        } 
        if (auth()->user()->role_id == 3) {
            $total_keuntungan = PenjualanDealerPulsa::with(['dealer', 'biller', 'dealer_pulsa', 'pulsa', 'kartu'])->where('dealer_id', auth()->user()->dealer_id)->sum('keuntungan');
        }
        // $data_penjualan = PenjualanDealerPulsa::with(['dealer_pulsa', 'pulsa', 'kartu'])->get();
        if (auth()->user()->role_id != 3) {
            $data_penjualan = PenjualanDealerPulsa::with(['dealer', 'biller', 'dealer_pulsa', 'dealer_pulsa', 'pulsa', 'kartu'])->get();
        } 
        if (auth()->user()->role_id == 3) {
            $data_penjualan = PenjualanDealerPulsa::with(['dealer', 'biller', 'dealer_pulsa', 'dealer_pulsa', 'pulsa', 'kartu'])->where('dealer_id', auth()->user()->dealer_id)->get();
        }
        return view('penjualan-dealer-pulsa.index', [
            'data_penjualan' => $data_penjualan,
            'total_keuntungan' => $total_keuntungan,
        ]);
    }
}
