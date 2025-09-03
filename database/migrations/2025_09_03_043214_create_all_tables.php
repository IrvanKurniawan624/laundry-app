<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =======================
        // 1. Users (Admin, Petugas, Pelanggan)
        // =======================
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['Admin', 'Pegawai', 'Pelanggan'])->default('Pegawai');
            $table->string('nomor_telepon', 20)->nullable();
            $table->string('alamat')->nullable();

            $table->enum('salary_type', ['Flat', 'Per_Pesanan'])->default('Per_Pesanan')->nullable();

            $table->timestamps();
        });


        // =======================
        // 2. Jenis Layanan Laundry
        // =======================
        Schema::create('jenis_layanan_laundry', function (Blueprint $table) {
            $table->id('id_layanan');
            $table->string('jenis_layanan', 50);
            $table->decimal('tarif', 10, 2);
            $table->timestamps();
        });

        // =======================
        // 3. Tipe Pesanan
        // =======================
        Schema::create('tipe_pesanan', function (Blueprint $table) {
            $table->id('id_tipe_pesanan');
            $table->string('nama_tipe', 50); // Reguler, Express, 
            $table->decimal('harga_tambahan', 10, 2)->default(0);
            $table->timestamps();
        });

        // =======================
        // 4. Pesanan
        // =======================
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->date('tanggal_pemesanan');
            $table->date('tanggal_pengambilan')->nullable();
            $table->enum('status', ['Diterima', 'Dalam Proses', 'Selesai'])->default('Diterima');
            $table->decimal('jumlah_tagihan', 10, 2)->default(0);

            // Pelanggan
            $table->unsignedBigInteger('id_pelanggan');
            // Petugas
            $table->unsignedBigInteger('id_petugas')->nullable();

            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_user')->on('users')->cascadeOnDelete();
            $table->foreign('id_petugas')->references('id_user')->on('users')->nullOnDelete();
        });


        // =======================
        // 5. Detail Pesanan
        // =======================
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('id_layanan_item');
            $table->unsignedBigInteger('id_layanan');
            $table->decimal('berat', 5, 2)->default(0);
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_tipe_pesanan')->nullable();
            $table->boolean('antar_kirim')->default(false);
            $table->timestamps();

            $table->foreign('id_layanan')->references('id_layanan')->on('jenis_layanan_laundry');
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->cascadeOnDelete();
            $table->foreign('id_tipe_pesanan')->references('id_tipe_pesanan')->on('tipe_pesanan');
        });

        // =======================
        // 6. Notifikasi
        // =======================
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_user'); // pemilik notifikasi
            $table->string('header', 100);
            $table->text('pesan');
            $table->enum('jenis', ['StatusPesanan', 'Promo', 'Umum'])->default('Umum');
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnDelete();
        });

        // =======================
        // 7. Promo Diskon
        // =======================
        Schema::create('promo_diskon', function (Blueprint $table) {
            $table->id('id_promo');
            $table->unsignedBigInteger('id_user'); // pelanggan
            $table->string('jenis_promo', 50);
            $table->decimal('diskon', 10, 2);
            $table->boolean('sudah_digunakan')->default(false);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnDelete();
        });

        // =======================
        // 8. Salary Pesanan (Log gaji pegawai)
        // =======================
        Schema::create('salary_pesanan', function (Blueprint $table) {
            $table->id('id_salary');
            $table->unsignedBigInteger('id_pesanan')->nullable(); // null jika salary flat
            $table->unsignedBigInteger('id_petugas');
            $table->date('tanggal_salary');
            $table->decimal('jumlah_salary', 10, 2);
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->nullOnDelete();
            $table->foreign('id_petugas')->references('id_user')->on('users')->cascadeOnDelete();
        });

        // =======================
        // 9. Snack
        // =======================
        Schema::create('snack', function (Blueprint $table) {
            $table->id('id_snack');
            $table->string('nama_snack', 100);
            $table->decimal('harga', 10, 2);
            $table->integer('stok')->default(0);
            $table->timestamps();
        });

        // =======================
        // 10. Transaksi Snack
        // =======================
        Schema::create('transaksi_snack', function (Blueprint $table) {
            $table->id('id_transaksi_snack');
            $table->unsignedBigInteger('id_user'); // pelanggan
            $table->date('tanggal_transaksi');
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnDelete();
        });

        // =======================
        // 11. Detail Transaksi Snack
        // =======================
        Schema::create('detail_transaksi_snack', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_transaksi_snack');
            $table->unsignedBigInteger('id_snack');
            $table->integer('jumlah');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->foreign('id_transaksi_snack')->references('id_transaksi_snack')->on('transaksi_snack')->cascadeOnDelete();
            $table->foreign('id_snack')->references('id_snack')->on('snack');
        });

        // =======================
        // 12. Config (App setting)
        // =======================
        Schema::create('config', function (Blueprint $table) {
            $table->id('id_config');
            $table->string('app_name')->default('Laundry App');
            $table->string('logo')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('config');
        Schema::dropIfExists('detail_transaksi_snack');
        Schema::dropIfExists('transaksi_snack');
        Schema::dropIfExists('snack');
        Schema::dropIfExists('salary_pesanan');
        Schema::dropIfExists('promo_diskon');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('detail_pesanan');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('tipe_pesanan');
        Schema::dropIfExists('jenis_layanan_laundry');
        Schema::dropIfExists('users');
    }
};
