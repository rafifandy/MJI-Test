<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class C_barang extends Controller
{

    public function index()
    {
        $barang = Barang::all();
        return view('/barang',compact('barang'));
    }

    public function store(Request $request)
    {
        $harga = preg_replace("/[^0-9]/", '', $request->harga);
        //dd($harga);
        Barang::create([
            'nama_barang' => $request->nama_barang,
            'harga' => $harga,
            'stok' => $request->stok,
        ]);
        return redirect('/barang')->with('status','Barang berhasil ditambahkan'); 
    }

    public function update(Request $request, $id)
    {
        $harga = preg_replace("/[^0-9]/", '', $request->harga);
        //dd($harga);
        Barang::where('id',$id)
        ->update([
            'nama_barang' => $request->nama_barang,
            'harga' => $harga,
            'stok' => $request->stok,
        ]);
        return redirect('/barang')->with('status','Barang berhasil diubah'); 
    }

    public function delete(Request $request, $id)
    {

    }
}
