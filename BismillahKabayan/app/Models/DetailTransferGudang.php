<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransferGudang extends Model
{
    protected $fillable = ['transfer_gudang_id', 'barang_id', 'qty'];

    public function transferGudang()
    {
        return $this->belongsTo(TransferGudang::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}