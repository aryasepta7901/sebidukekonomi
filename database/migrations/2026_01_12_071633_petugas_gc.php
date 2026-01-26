<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petugas_gc', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique()->nullable(); // Unique agar tidak ada email ganda
            $table->string('password')->nullable();
            $table->string('foto')->nullable(); // Nullable jika foto tidak wajib diisi
            $table->string('wil_tugas')->nullable(); // Menyimpan wilayah tugas (misal: kode kec/kab)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petugas_gc');
    }
};
