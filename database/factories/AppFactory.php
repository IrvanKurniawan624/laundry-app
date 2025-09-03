<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AppFactory{
    protected $faker;

    public function __construct()
    {
        // Gunakan locale Indonesia
        $this->faker = Faker::create('id_ID');
    }

    // ===== Users =====
    public function user(string $role = 'Pelanggan'): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => $role,
            'nomor_telepon' => $this->faker->numerify('08##########'),
            'alamat' => $this->faker->address(),
            'salary_type' => $role === 'Pegawai' 
            ? $this->faker->randomElement(['Flat', 'Per_Pesanan']) 
            : null,
        ];
    }

    // ===== Jenis Layanan Laundry =====
    public function layanan(): array
    {
        return [
            'jenis_layanan' => $this->faker->randomElement(['Cuci Kering', 'Cuci Setrika', 'Setrika Saja']),
            'tarif' => $this->faker->randomElement([5000, 7000, 10000]),
        ];
    }

    // ===== Tipe Pesanan =====
    public function tipePesanan(): array
    {
        return [
            'nama_tipe' => $this->faker->randomElement(['Reguler', 'Express', 'Kilat']),
            'harga_tambahan' => $this->faker->randomElement([0, 3000, 7000]),
        ];
    }

    // ===== Snack =====
    public function snack(): array
    {
        return [
            'nama_snack' => $this->faker->randomElement(['Keripik', 'Coklat', 'Air Mineral']),
            'harga' => $this->faker->randomElement([5000, 7000, 10000]),
            'stok' => $this->faker->numberBetween(10, 100),
        ];
    }

    // ===== Config =====
    public function config(): array
    {
        return [
            'app_name' => 'Laundry App',
            'logo' => null,
        ];
    }
}
