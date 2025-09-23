<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primarykey = 'id_pesanan';

    public function userPelanggan() {
        return $this->belongsTo(Pesanan::class, 'id_pelanggan');
    }
    public function userPetugas() {
        return $this->belongsTo(User::class,'id_petugas');
    }
    public function detailPesanan(){
        return $this->hasMany(DetailPesanan::class, foreignKey: 'id_pesanan');
    }
    public function antarJemput(){
        return $this->hasOne(AntarJemput::class,'id_pesanan');
    }

    public function promoUsage() {
        return $this->hasOne(PromoUsage::class, 'id_pesanan');
    }
    
}
