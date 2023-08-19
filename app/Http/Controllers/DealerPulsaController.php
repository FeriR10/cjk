<?php

namespace App\Http\Controllers;

use App\Models\Pulsa;
use App\Models\DealerPulsa;
use Illuminate\Http\Request;
use App\Models\SupplierPulsa;
use App\Models\PenjualanDealerPulsa;
use App\Models\PenjualanSupplierPulsa;
use Illuminate\Support\Facades\Session;

class DealerPulsaController extends Controller
{
    public function index()
    {
        // $data_dealer_pulsa = DealerPulsa::with(['dealer', 'supplier_pulsa', 'kartu'])->get();
        if (auth()->user()->role_id != 3) {
            $data_dealer_pulsa = DealerPulsa::with(['dealer', 'supplier_pulsa'])->get();
        } 
        if (auth()->user()->role_id == 3) {
            $data_dealer_pulsa = DealerPulsa::with(['dealer', 'supplier_pulsa'])->where('dealer_id', auth()->user()->dealer_id)->get();
        }
        return view('dealer-pulsa.index', [
            'data_dealer_pulsa' => $data_dealer_pulsa
        ]);
    }

    public function add()
    {
        $data_supplier_pulsa = SupplierPulsa::with('kartu')->get();
        $data_pulsa = Pulsa::all();
        return view('dealer-pulsa.add', [
            'data_supplier_pulsa' => $data_supplier_pulsa,
            'data_pulsa' => $data_pulsa
        ]);
    }
    
    public function tambahSaldo($id)
    {
        $data_supplier_pulsa = SupplierPulsa::with('kartu')->get();
        $data_dealer_pulsa = DealerPulsa::with('kartu')->find($id);
        $data_pulsa = Pulsa::all();
        return view('dealer-pulsa.tambah-saldo', [
            'data_supplier_pulsa' => $data_supplier_pulsa,
            'data_dealer_pulsa' => $data_dealer_pulsa,
            'data_pulsa' => $data_pulsa
        ]);
    }

    public function create(Request $request)
    {
        $pulsa =SupplierPulsa::find($request->supplier_pulsa_id);

        $validated = $request->validate([
            'supplier_pulsa_id' => 'required',
            'switching' => 'required',
            'jumlah_transaksi' => 'required',
        ]);

        $dealer_pulsa = new DealerPulsa;
        $dealer_pulsa->dealer_id = auth()->user()->dealer_id;
        $dealer_pulsa->supplier_pulsa_id = $request->supplier_pulsa_id;
        $dealer_pulsa->pulsa_id = $pulsa->pulsa_id;
        $dealer_pulsa->kartu_id = $pulsa->kartu_id;
        $dealer_pulsa->nominal = $pulsa->nominal;
        $dealer_pulsa->switching = $request->switching;
        $dealer_pulsa->harga_jual = $pulsa->harga_jual + $request->switching;
        $dealer_pulsa->jumlah_transaksi = $request->jumlah_transaksi;
        $dealer_pulsa->total_saldo = $dealer_pulsa->nominal * $request->jumlah_transaksi;
        $dealer_pulsa->harga_beli = $pulsa->harga_jual;
        // dd($dealer_pulsa);
        $dealer_pulsa->save();

        // add data to penjualan_dealer_pulsa_table
        $penjualan = new PenjualanSupplierPulsa;
        $penjualan->supplier_id = $pulsa->dealer_id;
        $penjualan->supplier_pulsa_id = $request->dealer_pulsa_id;
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
        // $penjualan->save();

        Session::flash('status', 'success');
        Session::flash('message', 'Tambah data sukses');
        return redirect('/dealer-pulsa');
    }
    
    public function createTambahSaldo(Request $request, $id)
    {
        $data_dealer_pulsa = DealerPulsa::with('kartu')->find($id);
        // dd($data_dealer_pulsa->supplier_pulsa_id);
        $pulsa =SupplierPulsa::find($data_dealer_pulsa->supplier_pulsa_id);
        // dd($pulsa);

        $validated = $request->validate([
            'jumlah_transaksi' => 'required',
        ]);

        // update data in table dealer_pulsa
        $dealer_pulsa = DealerPulsa::find($id);
        $dealer_pulsa->jumlah_transaksi = $dealer_pulsa->jumlah_transaksi + $request->jumlah_transaksi;
        $jumlah_saldo =  $dealer_pulsa->nominal * $request->jumlah_transaksi;
        $dealer_pulsa->total_saldo = $dealer_pulsa->total_saldo + $jumlah_saldo;
        // dd($dealer_pulsa);
        $dealer_pulsa->save();

        $supplier = SupplierPulsa::find($data_dealer_pulsa->supplier_pulsa_id);
        // dd($supplier->supplier_id);

        // add data to penjualan_supplier_pulsa_table
        $penjualan = new PenjualanSupplierPulsa;
        $penjualan->supplier_id = $supplier->supplier_id;
        $penjualan->supplier_pulsa_id = $dealer_pulsa->supplier_pulsa_id;
        $penjualan->pulsa_id = $supplier->pulsa_id;
        $penjualan->kartu_id = $supplier->kartu_id;
        $penjualan->nominal = $supplier->nominal;
        $penjualan->harga_jual = $supplier->harga_jual;
        $penjualan->jumlah_transaksi = $request->jumlah_transaksi;
        $penjualan->harga_beli = $supplier->harga_awal;
        $penjualan->total_harga_jual = $supplier->harga_jual * $request->jumlah_transaksi;
        $penjualan->total_harga_beli = $supplier->harga_awal * $request->jumlah_transaksi;
        $penjualan->keuntungan = $penjualan->total_harga_jual - $penjualan->total_harga_beli;
        // dd($penjualan);
        $penjualan->save();

        Session::flash('status', 'success');
        Session::flash('message', 'Tambah saldo sukses');
        return redirect('/dealer-pulsa');
    }

    public function edit($id)
    {
        $data_supplier_pulsa = SupplierPulsa::with('kartu')->get();
        $data_dealer_pulsa = DealerPulsa::with('kartu')->find($id);
        $data_pulsa = Pulsa::all();
        return view('dealer-pulsa.edit', [
            'data_supplier_pulsa' => $data_supplier_pulsa,
            'data_dealer_pulsa' => $data_dealer_pulsa,
            'data_pulsa' => $data_pulsa
        ]);
    }

    public function update(Request $request, $id)
    {
        $data_dealer_pulsa = DealerPulsa::with('kartu')->find($id);
        $pulsa =SupplierPulsa::find($data_dealer_pulsa->supplier_pulsa_id);
        // dd($pulsa);

        $validated = $request->validate([
            'switching' => 'required',
        ]);

        // update data in table dealer_pulsa
        $dealer_pulsa = DealerPulsa::find($id);
        $dealer_pulsa->switching = $request->switching;
        $dealer_pulsa->harga_jual = $dealer_pulsa->harga_beli + $request->switching;
        // dd($dealer_pulsa);
        $dealer_pulsa->save();

        Session::flash('status', 'success');
        Session::flash('message', 'Edit switching sukses');
        return redirect('/dealer-pulsa');
    }
}
