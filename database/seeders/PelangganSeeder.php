<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // lokal Indonesia
        $now = Carbon::now();

        // jumlah pelanggan yang ingin dibuat — ubah sesuai kebutuhan
        $count = 50;

        $rows = [];
        for ($i = 0; $i < $count; $i++) {
            $name = $faker->name;
            $email = $faker->unique()->safeEmail;
            $rows[] = [
                'name' => $name,
                'email' => $email,
                // hash password via Laravel
                'password' => Hash::make('password'), 
                'role' => 'Pelanggan',
                'nomor_telepon' => $faker->numerify('08##########'),
                'alamat' => $faker->address,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // optional: kalau mau hapus semua users dulu (BERHATI-HATI)
        // DB::table('users')->truncate();

        DB::table('users')->insert($rows);
    }
}
