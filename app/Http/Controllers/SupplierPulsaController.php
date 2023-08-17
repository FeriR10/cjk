<?php

namespace App\Http\Controllers;

use App\Models\Kartu;
use App\Models\Pulsa;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\SupplierPulsa;
use Illuminate\Support\Facades\Session;

class SupplierPulsaController extends Controller
{
    public function index()
    {
        $data_supplier_pulsa = SupplierPulsa::with(['supplier', 'kartu'])->get();
        return view('supplier-pulsa.index', [
            'data_supplier_pulsa' => $data_supplier_pulsa
        ]);
    }

    public function add()
    {
        $data_supplier = Supplier::all();
        $data_pulsa = Pulsa::all();
        $data_kartu = Kartu::all();
        return view('supplier-pulsa.add', [
            'data_supplier' => $data_supplier,
            'data_pulsa' => $data_pulsa,
            'data_kartu' => $data_kartu,
        ]);
    }

    public function create(Request $request)
    {
        $pulsa = Pulsa::find($request->pulsa_id);

        $validated = $request->validate([
            'supplier_id' => 'required',
            'pulsa_id' => 'required',
            'kartu_id' => 'required',
            'harga_jual' => 'required',
        ]);

        $supplier_pulsa = new SupplierPulsa;
        $supplier_pulsa->supplier_id = auth()->user()->supplier_id;
        $supplier_pulsa->pulsa_id = $request->pulsa_id;
        $supplier_pulsa->nominal = $pulsa->nominal;
        $supplier_pulsa->kartu_id = $request->kartu_id;
        $supplier_pulsa->harga_jual = $request->harga_jual;
        $supplier_pulsa->save();

        Session::flash('status', 'success');
        Session::flash('message', 'Tambah data sukses');
        return redirect('/supplier-pulsa');
    }

    public function edit($id)
    {
        $data_supplier_pulsa = SupplierPulsa::with(['supplier', 'kartu'])->find($id);
        return view('supplier-pulsa.edit', [
            'data_supplier_pulsa' => $data_supplier_pulsa
        ]);
    }

    public function update(Request $request, $id)
    {
        $pulsa = Pulsa::find($request->pulsa_id);

        $validated = $request->validate([
            'harga_jual' => 'required',
        ]);

        $supplier_pulsa = SupplierPulsa::with(['supplier', 'kartu'])->find($id);
        $supplier_pulsa->harga_jual = $request->harga_jual;
        // dd($supplier_pulsa);
        $supplier_pulsa->save();

        Session::flash('status', 'success');
        Session::flash('message', 'Update harga jual sukses');
        return redirect('/supplier-pulsa');
    }
}
