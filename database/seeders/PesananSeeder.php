<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PesananSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $idPetugasLaundry = 2; // pegawai tetap
        $pelangganIds = range(5, 54);

        // status harus sama persis dengan enum di migration
        $statusList = ['Diterima', 'Dalam Proses', 'Selesai'];

        $pesanan = [];

        foreach ($pelangganIds as $idPelanggan) {
            $jumlahPesanan = rand(1, 3);

            for ($i = 0; $i < $jumlahPesanan; $i++) {
                $tanggalPemesanan = Carbon::instance($faker->dateTimeBetween('-10 days', 'now'));
                $status = $faker->randomElement($statusList);
                $jumlahTagihan = $faker->numberBetween(15000, 100000);

                // logika tanggal_pengambilan
                $tanggalPengambilan = null;

                if ($status === 'Selesai') {
                    // tanggal pengambilan = pemesanan + 1–2 hari
                    $tanggalPengambilan = $tanggalPemesanan->copy()->addDays(rand(1, 2));
                } elseif ($status === 'Dalam Proses') {
                    // 50% kemungkinan tanggal_pengambilan sudah ada (laundry hampir selesai)
                    if ($faker->boolean(50)) {
                        $tanggalPengambilan = $tanggalPemesanan->copy()->addDays(rand(1, 3));
                    }
                }
                // status Diterima → tanggal_pengambilan pasti null

                $pesanan[] = [
                    'id_pelanggan'        => $idPelanggan,
                    'id_petugas'          => $idPetugasLaundry,
                    'tanggal_pemesanan'   => $tanggalPemesanan,
                    'tanggal_pengambilan' => $tanggalPengambilan,
                    'status'              => $status,
                    'jumlah_tagihan'      => $jumlahTagihan,
                    'created_at'          => $tanggalPemesanan,
                    'updated_at'          => $tanggalPemesanan,
                ];
            }
        }

        DB::table('pesanan')->insert($pesanan);
    }
}
