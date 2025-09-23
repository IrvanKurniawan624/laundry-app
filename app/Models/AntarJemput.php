<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntarJemput extends Model
{
    //
    protected $table = 'antar_jemput';
    protected $primarykey = 'id_antar';
    public function pesanan(){
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
    public function user(){
        return $this->belongsTo(User::class, 'id_kurir');
    }
}
