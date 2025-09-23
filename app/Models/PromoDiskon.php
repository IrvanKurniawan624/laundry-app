<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoDiskon extends Model
{
    protected $table = 'promo_diskon';
    protected $primarykey = 'id_promo_diskon';
    public function promoUsage(){
        return $this->belongsTo(PromoUsage::class, 'id_promo');
    }
}
