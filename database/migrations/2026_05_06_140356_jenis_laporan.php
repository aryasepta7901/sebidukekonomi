<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jenis_laporan', function (Blueprint $table) {
            $table->id();
            // Tambahkan kolom nama untuk menyimpan jenis kategori laporan
            $table->string('nama_jenis'); // Contoh: 'Ngibar', 'Sosialisasi', 'Dukungan K/L'
            $table->string('slug')->nullable(); // Opsional: untuk URL yang lebih rapi
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('jenis_laporan');
    }
};
