<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =======================
        // Users (Admin, Petugas, Pelanggan)
        // =======================
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['Admin', 'Pegawai', 'Pelanggan'])->default('Pegawai');
            $table->string('nomor_telepon', 20)->nullable();
            $table->string('alamat')->nullable();
            //$table->enum('salary_type', ['Flat', 'Per_Pesanan'])->default('Per_Pesanan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // =======================
        // Jenis Layanan Laundry
        // =======================
        Schema::create('jenis_layanan_laundry', function (Blueprint $table) {
            $table->id('id_layanan'); 
            $table->string('jenis_layanan', 50); // CUCI KERING | CUCI BASAH | CUCI SETRIKA
            $table->decimal('tarif', 8, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        // =======================
        // Tipe Pesanan
        // =======================
        Schema::create('tipe_pesanan', function (Blueprint $table) {
            $table->id('id_tipe_pesanan');
            $table->string('nama_tipe', 50); // Reguler, Express, (More to speed type of laundry)
            $table->decimal('harga_tambahan', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // =======================
        // Pesanan
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
            $table->softDeletes();
        });


        // =======================
        // Detail Pesanan
        // =======================
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('id_layanan_item');
            $table->unsignedBigInteger('id_layanan');
            $table->decimal('berat', 5, 2)->default(0);
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_tipe_pesanan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_layanan')->references('id_layanan')->on('jenis_layanan_laundry');
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->cascadeOnDelete();
            $table->foreign('id_tipe_pesanan')->references('id_tipe_pesanan')->on('tipe_pesanan');
        });

        // =======================
        // Antar Jemput
        // =======================
        Schema::create('antar_jemput', function (Blueprint $table) {
            $table->id('id_antar');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_kurir')->nullable(); 
            $table->decimal('biaya', 10, 2)->default(0);        
            $table->decimal('komisi_kurir', 10, 2)->default(0); 
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->cascadeOnDelete();
            $table->foreign('id_kurir')->references('id_user')->on('users')->nullOnDelete();
            $table->index('id_kurir');
        });

        // =======================
        // Config Antar Jemput
        // =======================
        Schema::create('config_antar_jemput', function (Blueprint $table) {
            $table->id('id_config');
            $table->decimal('jarak_max_km', 5, 2); // batas jarak km (contoh: 5 km)
            $table->decimal('biaya', 10, 2);       // biaya antar jemput
            $table->decimal('komisi_kurir', 10, 2); // komisi kurir
            $table->timestamps();
            $table->softDeletes();
        });

        // =======================
        // Notifikasi
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
        // Promo Diskon (Hanya untuk Laundry)
        // =======================
        Schema::create('promo_diskon', function (Blueprint $table) {
            $table->id('id_promo');
            $table->string('kode_kupon', 50)->unique();   
            $table->string('jenis_promo', 100);         
            $table->enum('tipe_diskon', ['Persen', 'Nominal'])->default('Persen');
            $table->decimal('diskon', 10, 2);
            $table->integer('kuota')->default(0);       
            $table->integer('terpakai')->default(0);    
            $table->boolean('is_active')->default(true);
            $table->date('berlaku_mulai')->nullable();  
            $table->date('berlaku_sampai')->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });

        // =======================
        // Promo Usage 
        // =======================
        Schema::create('promo_usage', function (Blueprint $table) {
            $table->id('id_usage');
            $table->unsignedBigInteger('id_promo');
            $table->unsignedBigInteger('id_user');       
            $table->unsignedBigInteger('id_pesanan');    
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['id_promo', 'id_user']);     // one use per user
            $table->unique(['id_pesanan']);

            $table->foreign('id_promo')->references('id_promo')->on('promo_diskon')->cascadeOnDelete();
            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnDelete();
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->cascadeOnDelete();
        });

        // =======================
        // Salary Log 
        // =======================
        Schema::create('salary_log', function (Blueprint $table) {
            $table->id('id_salary');
            $table->unsignedBigInteger('id_petugas');
            $table->date('periode'); // ex: 2025-09
            $table->decimal('jumlah_salary', 10, 2);
            $table->boolean('sudah_dibayar')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_petugas')->references('id_user')->on('users')->cascadeOnDelete();
        });


        // =======================
        //! Salary Pesanan (Log gaji pegawai) NOT USED CUZ SALARY FLAT 
        // =======================
        // Schema::create('salary_pesanan', function (Blueprint $table) {
        //     $table->id('id_salary');
        //     $table->unsignedBigInteger('id_pesanan')->nullable(); // null jika salary flat
        //     $table->unsignedBigInteger('id_petugas');
        //     $table->date('tanggal_salary');
        //     $table->decimal('jumlah_salary', 10, 2);
        //     $table->timestamps();

        //     $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->nullOnDelete();
        //     $table->foreign('id_petugas')->references('id_user')->on('users')->cascadeOnDelete();
        // });

        // =======================
        // Snack
        // =======================
        Schema::create('snack', function (Blueprint $table) {
            $table->id('id_snack');
            $table->string('nama_snack', 100);
            $table->decimal('harga', 10, 2);
            $table->integer('stok')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // =======================
        // Transaksi Snack
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
        // Detail Transaksi Snack
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
        // Config (App setting)
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
        Schema::dropIfExists('salary_log');
        Schema::dropIfExists('promo_usage');
        Schema::dropIfExists('promo_diskon');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('detail_pesanan');
        Schema::dropIfExists('antar_jemput');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('tipe_pesanan');
        Schema::dropIfExists('jenis_layanan_laundry');
        Schema::dropIfExists('users');
    }
};
