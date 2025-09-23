<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipePesanan extends Model
{
    //
    protected $table = 'tipe_pesanan';
    protected $primary_key = 'id_tipe_pesanan';

    public function DetailPesanan() {
        return $this->hasMany(DetailPesanan::class,'id_tipe_pesanan');
    }
}
