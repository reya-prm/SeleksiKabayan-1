<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'user_id',
        'total_harga',
    ];

        public function detail()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
