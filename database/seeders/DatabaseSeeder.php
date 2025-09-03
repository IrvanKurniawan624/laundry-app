<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Database\Factories\AppFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $factory = new AppFactory();

        // === USERS ===
        foreach (['Admin', 'Pegawai', 'Pelanggan'] as $role) {
            $limit = 10;
            for ($i = 0; $i < $limit; $i++) {
                DB::table('users')->insert(array_merge(
                    $factory->user($role),
                    ['created_at' => now(), 'updated_at' => now()]
                ));
            }
            $limit -= 4;
        }

        // Super Admin
        DB::table('users')->updateOrInsert(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin'),
                'role' => 'Admin',
                'nomor_telepon' => $faker->phoneNumber(),
                'alamat' => $faker->address(),
                'salary_type' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // === Layanan Laundry ===
        foreach (['Cuci Kering' => 5000, 'Cuci Setrika' => 7000, 'Setrika Saja' => 4000] as $layanan => $tarif) {
            DB::table('jenis_layanan_laundry')->updateOrInsert(
                ['jenis_layanan' => $layanan],
                ['tarif' => $tarif, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // === Tipe Pesanan ===
        foreach (['Reguler' => 0, 'Express' => 3000, 'Kilat' => 7000] as $tipe => $harga) {
            DB::table('tipe_pesanan')->updateOrInsert(
                ['nama_tipe' => $tipe],
                ['harga_tambahan' => $harga, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // === Snack ===
        foreach (['Keripik' => 5000, 'Coklat' => 7000, 'Air Mineral' => 3000] as $snack => $harga) {
            DB::table('snack')->updateOrInsert(
                ['nama_snack' => $snack],
                ['harga' => $harga, 'stok' => rand(50, 100), 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // === Config ===
        DB::table('config')->updateOrInsert(
            ['id_config' => 1],
            array_merge($factory->config(), ['created_at' => now(), 'updated_at' => now()])
        );

        // === Simulasi Transaksi ===
        $pelangganList = DB::table('users')->where('role', 'Pelanggan')->get();
        $pegawaiList = DB::table('users')->where('role', 'Pegawai')->get();
        $layananList = DB::table('jenis_layanan_laundry')->get();
        $tipeList = DB::table('tipe_pesanan')->get();
        $snackList = DB::table('snack')->get();

        foreach ($pelangganList as $pelanggan) {
            for ($i = 0; $i < 3; $i++) {
                $tipe = $tipeList->random();
                $layanan = $layananList->random();
                $pegawai = $pegawaiList->random();

                // Insert Pesanan
                $idPesanan = DB::table('pesanan')->insertGetId([
                    'id_pelanggan' => $pelanggan->id_user,
                    'id_petugas'   => $pegawai->id_user,
                    'tanggal_pemesanan' => now()->subDays(rand(1, 20)),
                    'tanggal_pengambilan' => now(),
                    'status' => $faker->randomElement(['Diterima','Dalam Proses','Selesai']),
                    'jumlah_tagihan' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Detail Pesanan
                $berat = rand(2, 6);
                $totalLaundry = ($layanan->tarif * $berat) + $tipe->harga_tambahan;

                DB::table('detail_pesanan')->insert([
                    'id_pesanan' => $idPesanan,
                    'id_layanan' => $layanan->id_layanan,
                    'berat' => $berat,
                    'id_tipe_pesanan' => $tipe->id_tipe_pesanan,
                    'antar_kirim' => rand(0,1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Transaksi Snack (jika ada)
                if (rand(0, 1)) {
                    $snack = $snackList->random();
                    $jumlah = rand(1, 3);
                    $subtotal = $snack->harga * $jumlah;

                    $idTransaksiSnack = DB::table('transaksi_snack')->insertGetId([
                        'id_user' => $pelanggan->id_user,
                        'tanggal_transaksi' => now(),
                        'total_harga' => $subtotal,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    DB::table('detail_transaksi_snack')->insert([
                        'id_transaksi_snack' => $idTransaksiSnack,
                        'id_snack' => $snack->id_snack,
                        'jumlah' => $jumlah,
                        'subtotal' => $subtotal,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $totalLaundry += $subtotal;
                }

                // Update total harga pesanan
                DB::table('pesanan')->where('id_pesanan', $idPesanan)->update([
                    'jumlah_tagihan' => $totalLaundry,
                ]);

                // Gaji pegawai
                DB::table('salary_pesanan')->insert([
                    'id_pesanan' => $idPesanan,
                    'id_petugas' => $pegawai->id_user,
                    'tanggal_salary' => now(),
                    'jumlah_salary' => $pegawai->salary_type === 'Flat' ? 50000 : floor($totalLaundry * 0.3),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Notifikasi
                DB::table('notifikasi')->insert([
                    'id_user' => $pelanggan->id_user,
                    'header' => 'Status Pesanan',
                    'pesan' => "Pesanan #$idPesanan sekarang berstatus {$faker->randomElement(['Dalam Proses', 'Selesai'])}",
                    'jenis' => 'StatusPesanan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Promo notifikasi
        foreach (DB::table('users')->get() as $user) {
            DB::table('notifikasi')->insert([
                'id_user' => $user->id_user,
                'header' => 'Promo September',
                'pesan' => 'Dapatkan diskon 20% untuk layanan Cuci Setrika minggu ini!',
                'jenis' => 'Promo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }


}
