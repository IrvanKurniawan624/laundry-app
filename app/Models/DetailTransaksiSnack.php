<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksiSnack extends Model
{
    //
    protected $table = 'detail_transaksi_snack';
    protected $primaryKey = 'id_detail';
    public function transaksiSnack(){
        return  $this->belongsTo(TransaksiSnack::class, 'id_transaksi_snack');
    }
    public function snack() {
        return $this->belongsTo(Snack::class, 'id_snack');
    }
}
