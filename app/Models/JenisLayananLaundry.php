<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisLayananLaundry extends Model
{
    protected $table = 'jenis_layanan_laundry';
    protected $primarykey = 'id_layanan';

    public function detailPesanan(){
        return $this->hasMany(DetailPesanan::class, 'id_layanan');
    }
}
