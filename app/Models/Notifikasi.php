<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    //
    protected $table  = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
