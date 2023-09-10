<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\DealerKartuPerdana;
use Illuminate\Support\Facades\Session;
use App\Models\PembelianDealerKartuPerdana;
use App\Models\PenjualanSupplierKartuPerdana;

class PembelianDealerKartuPerdanaController extends Controller
{
    public function index()
    {
        // $data_pembelian = PembelianDealerKartuPerdana::with(['dealer_pulsa', 'pulsa', 'kartu'])->get();
        if (auth()->user()->role_id != 3) {
            $data_pembelian = PembelianDealerKartuPerdana::with(['supplier', 'dealer', 'kartu'])->get();
        }
        if (auth()->user()->role_id == 3) {
            $data_pembelian = PembelianDealerKartuPerdana::with(['supplier', 'dealer', 'kartu'])->where('dealer_id', auth()->user()->dealer_id)->get();
        }
        return view('pembelian-dealer-kartu-perdana.index', [
            'data_pembelian' => $data_pembelian,
        ]);
    }
}
