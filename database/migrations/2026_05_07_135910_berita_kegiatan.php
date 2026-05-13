<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('berita_kegiatan', function (Blueprint $table) {
            $table->id();

            // Relasi ke User yang menginput (Pembuat Laporan)
            $table->foreignId('user_id')
                ->constrained('users')
            ;

            // Relasi ke Jenis Laporan
            $table->foreignId('id_jenis_laporan')
                ->constrained('jenis_laporan')
            ;

            $table->string('judul');
            $table->date('tanggal');
            $table->string('tempat');
            $table->integer('jumlah_peserta')->default(0);
            $table->text('deskripsi')->nullable();

            // Aset Digital (JSON untuk banyak file)
            $table->json('gambar')->nullable();
            $table->json('link_pdf')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita_kegiatan');
    }
};
