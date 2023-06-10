<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;


    protected $fillable = ['nama_produk', 'kode_produk', 'unit', 'merk', 'harga_beli', 'harga_jual', 'diskon', 'stok', 'image'];


    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $guarded = [];
    use SoftDeletes;
}
