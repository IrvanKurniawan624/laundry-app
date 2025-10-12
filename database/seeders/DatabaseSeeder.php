<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ======================
        // Bersihkan semua tabel
        // ======================
        $tables = [
            'config',
            'detail_transaksi_snack',
            'transaksi_snack',
            'snack',
            'salary_log',
            'promo_usage',
            'promo_diskon',
            'notifikasi',
            'detail_pesanan',
            'antar_jemput',
            'config_antar_jemput',
            'pesanan',
            'tipe_pesanan',
            'jenis_layanan_laundry',
            'users',
        ];

        foreach ($tables as $table) {
            DB::statement("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE");
        }

        // ======================
        // Users
        // ======================
        DB::table('users')->insert([
            [
                'name' => 'Admin Utama',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'nomor_telepon' => '081111111111',
                'alamat' => 'Jl. Admin No. 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pegawai Laundry',
                'email' => 'pegawai@example.com',
                'password' => Hash::make('password'),
                'role' => 'Pegawai',
                'nomor_telepon' => '082222222222',
                'alamat' => 'Jl. Pegawai No. 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kurir Laundry',
                'email' => 'kurir@example.com',
                'password' => Hash::make('password'),
                'role' => 'Pegawai', // bisa dianggap pegawai dengan job kurir
                'nomor_telepon' => '083333333333',
                'alamat' => 'Jl. Kurir No. 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pelanggan A',
                'email' => 'pelanggan.a@example.com',
                'password' => Hash::make('password'),
                'role' => 'Pelanggan',
                'nomor_telepon' => '084444444444',
                'alamat' => 'Jl. Pelanggan No. 4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ======================
        // Jenis Layanan Laundry
        // ======================
        DB::table('jenis_layanan_laundry')->insert([
            ['jenis_layanan' => 'Cuci Kering', 'tarif' => 7000, 'created_at' => now(), 'updated_at' => now()],
            ['jenis_layanan' => 'Cuci Basah', 'tarif' => 5000, 'created_at' => now(), 'updated_at' => now()],
            ['jenis_layanan' => 'Cuci Setrika', 'tarif' => 10000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ======================
        // Tipe Pesanan
        // ======================
        DB::table('tipe_pesanan')->insert([
            ['nama_tipe' => 'Reguler', 'harga_tambahan' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['nama_tipe' => 'Express', 'harga_tambahan' => 5000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ======================
        // Pesanan
        // ======================
        DB::table('pesanan')->insert([
            [
                'tanggal_pemesanan' => now(),
                'tanggal_pengambilan' => now()->addDays(2),
                'status' => 'Selesai',
                'jumlah_tagihan' => 45000,
                'id_pelanggan' => 4, // Pelanggan A
                'id_petugas' => 2,   // Pegawai Laundry
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal_pemesanan' => now(),
                'tanggal_pengambilan' => now()->addDays(1),
                'status' => 'Dalam Proses',
                'jumlah_tagihan' => 85000,
                'id_pelanggan' => 4,
                'id_petugas' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ======================
        // Detail Pesanan
        // ======================
        DB::table('detail_pesanan')->insert([
            [
                'id_layanan' => 1, // Cuci Kering
                'berat' => 3.5,
                'id_pesanan' => 1,
                'id_tipe_pesanan' => 1, // Reguler
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_layanan' => 3, // Cuci Setrika
                'berat' => 5,
                'id_pesanan' => 2,
                'id_tipe_pesanan' => 2, // Express
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ======================
        // Antar Jemput
        // ======================
        DB::table('antar_jemput')->insert([
            [
                'id_pesanan' => 2,
                'id_kurir' => 3, // Kurir Laundry
                'biaya' => 10000,
                'komisi_kurir' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ======================
        // Config Antar Jemput
        // ======================
        DB::table('config_antar_jemput')->insert([
            [
                'jarak_max_km' => 5,
                'biaya' => 15000,
                'komisi_kurir' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jarak_max_km' => 10,
                'biaya' => 25000,
                'komisi_kurir' => 8000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jarak_max_km' => 20,
                'biaya' => 40000,
                'komisi_kurir' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        // ======================
        // Promo Diskon
        // ======================
        DB::table('promo_diskon')->insert([
            [
                'kode_kupon' => 'DISKON10',
                'jenis_promo' => 'Diskon 10%',
                'tipe_diskon' => 'Persen',
                'diskon' => 10,
                'kuota' => 100,
                'terpakai' => 0,
                'is_active' => true,
                'berlaku_mulai' => now()->subDays(5),
                'berlaku_sampai' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ======================
        // Promo Usage
        // ======================
        DB::table('promo_usage')->insert([
            [
                'id_promo' => 1,
                'id_user' => 4,
                'id_pesanan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ======================
        // Salary Log
        // ======================
        DB::table('salary_log')->insert([
            [
                'id_petugas' => 2,
                'periode' => now()->startOfMonth(),
                'jumlah_salary' => 3000000,
                'sudah_dibayar' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ======================
        // Snack
        // ======================
        DB::table('snack')->insert([
            ['nama_snack' => 'Chitato', 'harga' => 15000, 'stok' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['nama_snack' => 'Aqua Botol', 'harga' => 5000, 'stok' => 50, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ======================
        // Transaksi Snack
        // ======================
        DB::table('transaksi_snack')->insert([
            [
                'id_user' => 4, // pelanggan A
                'tanggal_transaksi' => now(),
                'total_harga' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ======================
        // Detail Transaksi Snack
        // ======================
        DB::table('detail_transaksi_snack')->insert([
            [
                'id_transaksi_snack' => 1,
                'id_snack' => 1, // Chitato
                'jumlah' => 1,
                'subtotal' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_transaksi_snack' => 1,
                'id_snack' => 2, // Aqua
                'jumlah' => 1,
                'subtotal' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ======================
        // Notifikasi
        // ======================
        DB::table('notifikasi')->insert([
            [
                'id_user' => 4,
                'header' => 'Pesanan Selesai',
                'pesan' => 'Pesanan kamu sudah selesai dan bisa diambil.',
                'jenis' => 'StatusPesanan',
                'sudah_dibaca' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 4,
                'header' => 'Promo Baru!',
                'pesan' => 'Gunakan kode DISKON10 untuk diskon 10% di laundry.',
                'jenis' => 'Promo',
                'sudah_dibaca' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // --- Dummy data tambahan ---
        $this->call(PelangganSeeder::class);
        $this->call(PesananSeeder::class);

        // ======================
        // Config
        // ======================
        DB::table('config')->insert([
            [
                'app_name' => 'Laundry App',
                'logo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
