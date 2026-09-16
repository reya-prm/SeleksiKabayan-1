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
}
