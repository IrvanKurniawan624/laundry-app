<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snack extends Model
{
    protected $table = 'snack';
    protected $primaryKey = 'id_snack';
    public function detailTransaksiSnack()  {
        return $this->belongsTo(DetailTransaksiSnack::class, 'id_petugas');
    }
}
