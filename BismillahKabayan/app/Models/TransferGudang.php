<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferGudang extends Model
{
    protected $fillable = ['gudang_asal_id', 'gudang_tujuan_id', 'user_id', 'keterangan'];

    public function detail()
    {
        return $this->hasMany(DetailTransferGudang::class);
    }

    public function gudangAsal()
    {
        return $this->belongsTo(Gudang::class, 'gudang_asal_id');
    }

    public function gudangTujuan()
    {
        return $this->belongsTo(Gudang::class, 'gudang_tujuan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}