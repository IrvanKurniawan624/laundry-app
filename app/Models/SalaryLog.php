<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryLog extends Model
{
    //
    protected $table = 'salary_log';
    protected $primaryKey = 'id_salary';
    public function user(){
        return $this->belongsTo(User::class, 'id_petugas');
    }
}
