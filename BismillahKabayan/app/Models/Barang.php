<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';

    protected $fillable = [
        'sku',
        'nama_barang',
        'kategori',
        'satuan',
        'harga_pokok',
        'harga_jual',
        'status_aktif',
    ];

    public function stokBarang()
    {
        return $this->hasMany(StokBarang::class, 'barang_id');
    }
}