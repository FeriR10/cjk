<?php

namespace App\Http\Controllers;

use App\Models\Pulsa;
use App\Models\BillerPulsa;
use App\Models\DealerPulsa;
use App\Models\PenjualanDealerPulsa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BillerPulsaController extends Controller
{
    public function index()
    {
        // $data_biller_pulsa = BillerPulsa::with(['biller', 'dealer_pulsa'])->get();
        if (auth()->user()->role_id != 4) {
            $data_biller_pulsa = BillerPulsa::with(['biller', 'dealer_pulsa'])->get();
        } 
        if (auth()->user()->role_id == 4) {
            $data_biller_pulsa = BillerPulsa::with(['biller', 'dealer_pulsa'])->where('biller_id', auth()->user()->biller_id)->get();
        }

        return view('biller-pulsa.index', [
            'data_biller_pulsa' => $data_biller_pulsa
        ]);
    }

    public function add(Request $request)
    {
        $data_dealer_pulsa = DealerPulsa::where('jumlah_transaksi', '>', 0)->get();
        $data_pulsa = Pulsa::all();
        return view('biller-pulsa.add', [
            'data_dealer_pulsa' => $data_dealer_pulsa,
            'data_pulsa' => $data_pulsa
        ]);
    }

    public function create(Request $request)
    {
        $pulsa =DealerPulsa::find($request->dealer_pulsa_id);
        // dd($pulsa);

        $validated = $request->validate([
            'dealer_pulsa_id' => 'required',
            'switching' => 'required',
            'jumlah_transaksi' => 'required',
        ]);

        // add data to table biller_pulsa
        $biller_pulsa = new BillerPulsa;
        $biller_pulsa->biller_id = auth()->user()->biller_id;
        $biller_pulsa->dealer_pulsa_id = $request->dealer_pulsa_id;
        $biller_pulsa->pulsa_id = $pulsa->pulsa_id;
        $biller_pulsa->kartu_id = $pulsa->kartu_id;
        $biller_pulsa->nominal = $pulsa->nominal;
        $biller_pulsa->switching = $request->switching;
        $biller_pulsa->harga_jual = $pulsa->harga_jual + $request->switching;
        $biller_pulsa->jumlah_transaksi = $request->jumlah_transaksi;
        $biller_pulsa->total_saldo = $biller_pulsa->nominal * $request->jumlah_transaksi;
        $biller_pulsa->harga_beli = $pulsa->harga_jual;
        // dd($biller_pulsa);
        $biller_pulsa->save();

        // update data in table dealer_pulsa
        $dealer_pulsa = DealerPulsa::find($request->dealer_pulsa_id);
        $dealer_pulsa->jumlah_transaksi = $dealer_pulsa->jumlah_transaksi - $request->jumlah_transaksi;
        $dealer_pulsa->total_saldo = $dealer_pulsa->total_saldo - $biller_pulsa->total_saldo;
        $dealer_pulsa->save();

        // add data to penjualan_dealer_pulsa_table
        $penjualan = new PenjualanDealerPulsa;
        $penjualan->dealer_id = $pulsa->dealer_id;
        $penjualan->dealer_pulsa_id = $request->dealer_pulsa_id;
        $penjualan->pulsa_id = $pulsa->pulsa_id;
        $penjualan->kartu_id = $pulsa->kartu_id;
        $penjualan->nominal = $pulsa->nominal;
        $penjualan->harga_jual = $pulsa->harga_jual;
        $penjualan->jumlah_transaksi = $request->jumlah_transaksi;
        $penjualan->harga_beli = $pulsa->harga_beli;
        $penjualan->total_harga_jual = $pulsa->harga_jual * $request->jumlah_transaksi;
        $penjualan->total_harga_beli = $pulsa->harga_beli * $request->jumlah_transaksi;
        $penjualan->keuntungan = $penjualan->total_harga_jual - $penjualan->total_harga_beli;
        // dd($penjualan);
        $penjualan->save();

        Session::flash('status', 'success');
        Session::flash('message', 'Tambah data sukses');
        return redirect('/biller-pulsa');
    }
    
    public function tambahSaldo($id)
    {
        $biller = BillerPulsa::find($id);
        $max = DealerPulsa::find($biller->dealer_pulsa_id);
        $data_dealer_pulsa = DealerPulsa::find($id);
        $data_biller_pulsa =BillerPulsa::find($id);
        $data_pulsa = Pulsa::all();
        return view('biller-pulsa.tambah-saldo', [
            'data_dealer_pulsa' => $data_dealer_pulsa,
            'data_biller_pulsa' => $data_biller_pulsa,
            'max' => $max,
            'data_pulsa' => $data_pulsa
        ]);
    }

    public function createTambahSaldo(Request $request, $id)
    {
        $biller = BillerPulsa::find($id);
        $max = DealerPulsa::find($biller->dealer_pulsa_id);
        // dd($max->jumlah_transaksi);

        $validated = $request->validate([
            'jumlah_transaksi' => 'required',
        ]);

        // dd($validated);

        // update data in table biller_pulsa
        $biller_pulsa = BillerPulsa::find($id);
        $biller_pulsa->jumlah_transaksi = $biller_pulsa->jumlah_transaksi + $request->jumlah_transaksi;
        $total_saldo = $biller_pulsa->nominal * $request->jumlah_transaksi;
        $biller_pulsa->total_saldo = $biller_pulsa->total_saldo + $total_saldo;
        // dd($biller_pulsa);
        // $biller_pulsa->save();
        
        // update data in table dealer_pulsa
        $dealer_pulsa = DealerPulsa::find($biller_pulsa->dealer_pulsa_id);
        $dealer_pulsa->jumlah_transaksi = $dealer_pulsa->jumlah_transaksi - $request->jumlah_transaksi;
        $total_saldo = $biller_pulsa->nominal * $request->jumlah_transaksi;
        $dealer_pulsa->total_saldo = $dealer_pulsa->total_saldo - $total_saldo;
        // dd($dealer_pulsa);
        // $dealer_pulsa->save();

        $dealer =DealerPulsa::find($biller_pulsa->dealer_pulsa_id);
        // dd($pulsa->dealer_pulsa_id);

        // add data to penjualan_dealer_pulsa_table
        $penjualan = new PenjualanDealerPulsa;
        $penjualan->dealer_id = $dealer->dealer_id;
        $penjualan->dealer_pulsa_id = $biller_pulsa->dealer_pulsa_id;
        $penjualan->pulsa_id = $dealer->pulsa_id;
        $penjualan->kartu_id = $dealer->kartu_id;
        $penjualan->nominal = $dealer->nominal;
        $penjualan->harga_jual = $dealer->harga_jual;
        $penjualan->jumlah_transaksi = $request->jumlah_transaksi;
        $penjualan->harga_beli = $dealer->harga_beli;
        $penjualan->total_harga_jual = $dealer->harga_jual * $request->jumlah_transaksi;
        $penjualan->total_harga_beli = $dealer->harga_beli * $request->jumlah_transaksi;
        $penjualan->keuntungan = $penjualan->total_harga_jual - $penjualan->total_harga_beli;
        // dd($penjualan);
        // $penjualan->save();

        Session::flash('status', 'success');
        Session::flash('message', 'Tambah saldo sukses');
        return redirect('/biller-pulsa');
    }
    
    public function edit($id)
    {
        $data_dealer_pulsa = DealerPulsa::find($id);
        $data_biller_pulsa =BillerPulsa::find($id);
        $data_pulsa = Pulsa::all();
        return view('biller-pulsa.edit', [
            'data_dealer_pulsa' => $data_dealer_pulsa,
            'data_biller_pulsa' => $data_biller_pulsa,
            'data_pulsa' => $data_pulsa
        ]);
    }

    public function update(Request $request, $id)
    {
        

        $validated = $request->validate([
            'switching' => 'required',
        ]);

        // update data in table biller_pulsa
        $biller_pulsa = BillerPulsa::find($id);
        $biller_pulsa->switching = $request->switching;
        $biller_pulsa->harga_jual = $biller_pulsa->harga_beli + $request->switching;
        // dd($biller_pulsa);
        $biller_pulsa->save();

        Session::flash('status', 'success');
        Session::flash('message', 'Edit switching sukses');
        return redirect('/biller-pulsa');
    }
}
