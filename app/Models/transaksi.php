<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $fillable = ['id','nomor_transaksi','tanggal','id_barang','type','harga','jumlah','total_stok'];
    
    public $timestamps = false;
    public $incrementing = false;

    public function barang()
    {
        return $this->belongsTo(Barang::class,'id_barang');
    }
}
