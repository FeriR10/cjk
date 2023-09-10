<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;
use App\Models\BillerKartuPerdana;
use Illuminate\Support\Facades\Session;
use App\Models\PembelianBillerKartuPerdana;

class PembelianBillerKartuPerdanaController extends Controller
{
    public function index()
    {
        // $data_pembelian = PembelianBillerKartuPerdana::with(['biller', 'pulsa', 'kartu'])->get();
        if (auth()->user()->role_id != 3) {
            $data_pembelian = PembelianBillerKartuPerdana::with(['biller', 'kartu'])->get();
        }
        if (auth()->user()->role_id == 3) {
            $data_pembelian = PembelianBillerKartuPerdana::with(['biller', 'kartu'])->where('biller_id', auth()->user()->biller_id)->get();
        }
        return view('pembelian-biller-kartu-perdana.index', [
            'data_pembelian' => $data_pembelian,
        ]);
    }
}
