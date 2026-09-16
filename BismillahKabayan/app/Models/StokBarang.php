<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    protected $fillable = ['gudang_id', 'barang_id', 'qty'];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
