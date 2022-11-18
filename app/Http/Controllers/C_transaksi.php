<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;

class C_transaksi extends Controller
{

    public function index()
    {
        $transaksi = Transaksi::all();
        $barang = Barang::all();
        return view('/transaksi',compact('transaksi','barang'));
    }

    public function store(Request $request)
    {
        //dd($request->type);
        if($request->type == "penambahan"){
            $stok = $request->stok_barang + $request->jumlah;
        }
        elseif($request->type == "pengurangan"){
            $stok = $request->stok_barang - $request->jumlah;
        }
        $harga = preg_replace("/[^0-9]/", '', $request->harga);
        //dd($harga);
        //dd($request->stok_barang);
        Transaksi::create([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'type' => $request->type,
            'harga' => $harga,
            'jumlah' => $request->jumlah,
            'total_stok' => $stok,
        ]);
        Barang::where('id',$request->id_barang)
        ->update([
            'stok' => $stok,
        ]);
        return redirect('/transaksi')->with('status','Transaksi Berhasil Ditambahkan!!!'); 
    }

    public function edit($id)
    {
        $transaksi = Transaksi::where('id',$id)->get();
        $barang = Barang::all();
        return view('/transaksi-edit', compact('transaksi','barang')); 
    }

    public function update(Request $request, $id)
    {
        if($request->id_barang == $request->old_id_barang){     //  id barang tetap
            if($request->type == $request->old_type){           //  type tetap
                if($request->type == "penambahan"){
                    $stok = $request->stok_barang + ($request->jumlah - $request->old_jumlah);
                }
                elseif($request->type == "pengurangan"){
                    $stok = $request->stok_barang - ($request->jumlah - $request->old_jumlah);
                }
            }
            else{                                               //  type diubah
                if($request->type == "penambahan"){
                    $stok = $request->stok_barang + $request->old_jumlah + $request->jumlah;
                }
                elseif($request->type == "pengurangan"){
                    $stok = $request->stok_barang - $request->old_jumlah - $request->jumlah;
                }
            }
            $harga = preg_replace("/[^0-9]/", '', $request->harga);
            Transaksi::where('id',$id)
            ->update([
                'tanggal' => $request->tanggal,
                'id_barang' => $request->id_barang,
                'type' => $request->type,
                'harga' => $harga,
                'jumlah' => $request->jumlah,
                'total_stok' => $stok,
            ]);
            Barang::where('id',$request->id_barang)
            ->update([
                'stok' => $stok,
            ]);
        }
        else{                                                   //  id barang diubah
            if($request->old_type == "penambahan"){
                $old_stok =  $request->old_stok_barang - $request->old_jumlah;
            }
            elseif($request->old_type == "pengurangan"){
                $old_stok =  $request->old_stok_barang + $request->old_jumlah;
            }
            Barang::where('id',$request->old_id_barang)
            ->update([
                'stok' => $old_stok,
            ]);
            if($request->type == "penambahan"){
                $stok = $request->stok_barang + $request->jumlah;
            }
            elseif($request->type == "pengurangan"){
                $stok = $request->stok_barang - $request->jumlah;
            }
            $harga = preg_replace("/[^0-9]/", '', $request->harga);
            Transaksi::where('id',$id)
            ->update([
                'tanggal' => $request->tanggal,
                'id_barang' => $request->id_barang,
                'type' => $request->type,
                'harga' => $harga,
                'jumlah' => $request->jumlah,
                'total_stok' => $stok,
            ]);
            Barang::where('id',$request->id_barang)
            ->update([
                'stok' => $stok,
            ]);
        }
        return redirect('/transaksi'.$id)->with('status','Transaksi berhasil diubah'); 
    }

    public function delete(Request $request, $id)
    {
        //dd($request->type);
        if($request->type == "penambahan"){
            $stok = $request->stok - $request->jumlah;
        }
        elseif($request->type == "pengurangan"){
            $stok = $request->stok + $request->jumlah;
        }
        Transaksi::where('id',$id)->delete();
        Barang::where('id',$request->id_barang)
        ->update([
            'stok' => $stok,
        ]);
        return redirect('/transaksi')->with('status','Transaksi Berhasil Dihapus'); 
    }

}

