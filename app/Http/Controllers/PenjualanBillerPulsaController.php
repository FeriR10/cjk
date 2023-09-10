<?php

namespace App\Http\Controllers;

use App\Models\Pulsa;
use App\Models\BillerPulsa;
use Illuminate\Http\Request;
use App\Models\PenjualanBillerPulsa;
use Illuminate\Support\Facades\Session;

class PenjualanBillerPulsaController extends Controller
{
    public function index()
    {
        // $total_keuntungan = PenjualanBillerPulsa::sum('keuntungan');
        if (auth()->user()->role_id != 4) {
            $total_keuntungan = PenjualanBillerPulsa::sum('keuntungan');
        } 
        if (auth()->user()->role_id == 4) {
            $total_keuntungan = PenjualanBillerPulsa::where('biller_id', auth()->user()->biller_id)->sum('keuntungan');
        }
        
        // $data_penjualan= PenjualanBillerPulsa::with(['biller', 'biller_pulsa', 'pulsa', 'kartu'])->get();
        if (auth()->user()->role_id != 4) {
            $data_penjualan= PenjualanBillerPulsa::with(['biller', 'biller_pulsa', 'pulsa', 'kartu'])->get();
        } 
        if (auth()->user()->role_id == 4) {
            $data_penjualan= PenjualanBillerPulsa::with(['biller', 'biller_pulsa', 'pulsa', 'kartu'])->where('biller_id', auth()->user()->biller_id)->get();
        }

        return view('penjualan-biller-pulsa.index', [
            'data_penjualan' => $data_penjualan,
            'total_keuntungan' => $total_keuntungan,
        ]);
    }

    public function add()
    {
        $data_biller_pulsa = BillerPulsa::with('kartu')->where('biller_id', auth()->user()->biller_id)->where('jumlah_transaksi', '>', 0)->get();
        $data_pulsa = Pulsa::all();
        return view('penjualan-biller-pulsa.add', [
            'data_biller_pulsa' => $data_biller_pulsa,
            'data_pulsa' => $data_pulsa
        ]);
    }

    public function create(Request $request)
    {
        $biller_pulsa = BillerPulsa::find($request->biller_pulsa_id);
        // dd($pulsa);

        $validated = $request->validate([
            'biller_pulsa_id' => 'required',
            'no_konsumen' => 'required',
        ]);

        // add data to penjualan_biller_pulsa_table
        $penjualan = new PenjualanBillerPulsa;
        $penjualan->biller_id = auth()->user()->biller_id;
        $penjualan->biller_pulsa_id = $request->biller_pulsa_id;
        $penjualan->kartu_id = $biller_pulsa->kartu_id;
        $penjualan->pulsa_id = $biller_pulsa->pulsa_id;
        $penjualan->nominal = $biller_pulsa->nominal;
        $penjualan->no_konsumen = $request->no_konsumen;
        $penjualan->harga_beli = $biller_pulsa->harga_beli;
        $penjualan->switching = $biller_pulsa->switching;
        $penjualan->harga_jual = $biller_pulsa->harga_jual;
        $penjualan->jumlah_transaksi = 1;
        $penjualan->total_harga_beli = $penjualan->harga_beli * $penjualan->jumlah_transaksi;
        $penjualan->total_harga_jual = $penjualan->harga_jual * $penjualan->jumlah_transaksi;
        $penjualan->keuntungan = $penjualan->total_harga_jual - $penjualan->total_harga_beli;
        // dd($penjualan);
        $penjualan->save();
        
        // update data in table biller_pulsa
        $biller_pulsa = BillerPulsa::find($request->biller_pulsa_id);
        $biller_pulsa->jumlah_transaksi = $biller_pulsa->jumlah_transaksi - 1;
        $biller_pulsa->total_saldo = $biller_pulsa->total_saldo - $biller_pulsa->nominal;
        // dd($biller_pulsa);
        $biller_pulsa->save();

        Session::flash('status', 'success');
        Session::flash('message', 'Tambah data sukses');
        return redirect('/penjualan-biller-pulsa');
    }
}
