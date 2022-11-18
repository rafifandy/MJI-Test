<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $fillable = ['id','nama_barang','harga','stok'];
    
    public $timestamps = false;
    public $incrementing = false;

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class,'id_barang');
    }
}
