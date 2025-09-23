<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.pr
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function promoUsage(){
        return $this->hasMany(PromoUsage::class, 'id_user');
    }

    public function antarJemput(){
        return $this->hasMany(AntarJemput::class, 'id_kurir');
    }

    public function pesananPelanggan() {
        return $this->hasMany(Pesanan::class, 'id_pelanggan');
    }
    public function pesananPetugas()  {
        return $this->hasMany(pesanan::class, 'id_petugas');
    }
    public function notifikasi() {
        return $this->hasMany(Notifikasi::class, 'id_user');
    }
    public function salaryLog(){
        return $this->hasMany(SalaryLog::class, 'id_petugas');
    }
    public function transaksiSnack(){
        return $this->hasMany(TransaksiSnack::class, 'id_user');
    }
}
