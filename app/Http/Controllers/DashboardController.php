<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanBillerPulsa;
use App\Models\PenjualanDealerPulsa;
use App\Models\PenjualanSupplierPulsa;

class DashboardController extends Controller
{
    public function index()
    {
        // $total_keuntungan_supplier = PenjualanSupplierPulsa::sum('keuntungan');
        if (auth()->user()->role_id != 2) {
            $total_keuntungan_supplier = PenjualanSupplierPulsa::sum('keuntungan');
        } 
        if (auth()->user()->role_id == 2) {
            $total_keuntungan_supplier = PenjualanSupplierPulsa::where('supplier_id', auth()->user()->supplier_id)->sum('keuntungan');
        }
        // $total_keuntungan_dealer = PenjualanDealerPulsa::sum('keuntungan');
        if (auth()->user()->role_id != 3) {
            $total_keuntungan_dealer = PenjualanDealerPulsa::sum('keuntungan');
        } 
        if (auth()->user()->role_id == 3) {
            $total_keuntungan_dealer = PenjualanDealerPulsa::where('dealer_id', auth()->user()->dealer_id)->sum('keuntungan');
        }
        // $total_keuntungan_biller = PenjualanBillerPulsa::sum('keuntungan');
        if (auth()->user()->role_id != 4) {
            $total_keuntungan_biller = PenjualanBillerPulsa::sum('keuntungan');
        } 
        if (auth()->user()->role_id == 4) {
            $total_keuntungan_biller = PenjualanBillerPulsa::where('biller_id', auth()->user()->biller_id)->sum('keuntungan');
        }
        return view('dashboard.index', [
            'total_keuntungan_supplier' => $total_keuntungan_supplier,
            'total_keuntungan_dealer' => $total_keuntungan_dealer,
            'total_keuntungan_biller' => $total_keuntungan_biller,
        ]);
    }
}
