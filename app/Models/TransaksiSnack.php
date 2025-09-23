<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiSnack extends Model
{
    //
    protected $table = 'transaksi_snack';
    protected $primaryKey = 'id_transaksi_snack';
    public function User() {
        return $this->belongsTo(User::class,'id_user');
    }

    public function DetailTransakiSnack(){
        return $this->hasMany(DetailTransaksiSnack::class, 'id_transaksi_snack');
    }
}
