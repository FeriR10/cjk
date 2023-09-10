<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanSupplierPulsa;

class PenjualanSupplierPulsaController extends Controller
{
    public function index()
    {
        // $total_keuntungan = PenjualanDealerPulsa::sum('keuntungan');
        if (auth()->user()->role_id != 2) {
            $total_keuntungan = PenjualanSupplierPulsa::sum('keuntungan');
        } 
        if (auth()->user()->role_id == 2) {
            $total_keuntungan = PenjualanSupplierPulsa::with(['supplier', 'dealer', 'supplier_pulsa', 'pulsa', 'kartu'])->where('supplier_id', auth()->user()->supplier_id)->sum('keuntungan');
        }
        // $data_penjualan = PenjualanDealerPulsa::with(['dealer_pulsa', 'pulsa', 'kartu'])->get();
        if (auth()->user()->role_id != 2) {
            $data_penjualan = PenjualanSupplierPulsa::with(['supplier', 'dealer', 'supplier_pulsa', 'pulsa', 'kartu'])->get();
        } 
        if (auth()->user()->role_id == 2) {
            $data_penjualan = PenjualanSupplierPulsa::with(['supplier', 'dealer', 'supplier_pulsa', 'pulsa', 'kartu'])->where('supplier_id', auth()->user()->supplier_id)->get();
        }
        return view('penjualan-supplier-pulsa.index', [
            'data_penjualan' => $data_penjualan,
            'total_keuntungan' => $total_keuntungan,
        ]);
    }
}
