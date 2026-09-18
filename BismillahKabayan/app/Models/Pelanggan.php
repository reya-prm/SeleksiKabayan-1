<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = ['nama', 'nomor_hp', 'alamat'];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
