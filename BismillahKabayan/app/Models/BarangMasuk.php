<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $fillable = [
        'gudang_id',
        'user_id',
        'keterangan',
    ];

    public function detail()
    {
        return $this->hasMany(DetailBarangMasuk::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
