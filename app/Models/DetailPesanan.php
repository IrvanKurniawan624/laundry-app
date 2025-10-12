<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    //
    protected $table = 'detail_pesanan';
    protected $primarykey = 'id_layanan_item';
    public function pesanan(){
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
    public function jenisLayananLaundry(){
        return $this->belongsTo(JenisLayananLaundry::class, 'id_layanan');
    }
    public function tipePesanan(){
        return $this->belongsTo(TipePesanan::class, 'id_tipe_pesanan');
    }
}
