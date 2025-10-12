<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoUsage extends Model
{
    //
    protected $table = 'promo_usage';
    protected $primaryKey = 'id_usage';
    public function promoDiskon(){
        return $this->belongsTo(PromoDiskon::class, 'id_promo');
    }
    public function users() {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function pesanan(){
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}
