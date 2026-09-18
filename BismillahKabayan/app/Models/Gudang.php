<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $fillable = ['nama_gudang', 'alamat'];

    public function stokBarangs()
    {
        return $this->hasMany(StokBarang::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function transferKeluar()
    {
        return $this->hasMany(TransferGudang::class, 'gudang_asal_id');
    }

    public function transferMasuk()
    {
        return $this->hasMany(TransferGudang::class, 'gudang_tujuan_id');
    }
}
