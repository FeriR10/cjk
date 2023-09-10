<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanSupplierKartuPerdana;

class PenjualanSupplierKartuPerdanaController extends Controller
{
    public function index()
    {
        // $data_penjualan = PenjualanSupplierKartuPerdana::with(['dealer_pulsa', 'pulsa', 'kartu'])->get();
        if (auth()->user()->role_id != 3) {
            $data_penjualan = PenjualanSupplierKartuPerdana::with(['supplier', 'kartu'])->get();
        }
        if (auth()->user()->role_id == 3) {
            $data_penjualan = PenjualanSupplierKartuPerdana::with(['supplier', 'kartu'])->where('dealer_id', auth()->user()->supplier_id)->get();
        }
        return view('penjualan-supplier-kartu-perdana.index', [
            'data_penjualan' => $data_penjualan,
        ]);
    }
}
