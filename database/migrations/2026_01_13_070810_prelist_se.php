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
        Schema::create('prelist_se', function (Blueprint $table) {
            $table->string('idsbr')->primary();
            $table->string('nama_usaha');
            $table->text('alamat');
            $table->char('kdprov', 2);
            $table->char('kdkab', 2);
            $table->char('kdkec', 3);
            $table->char('kddesa', 3);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('kbli', 5);
            $table->text('deskripsi_usaha')->nullable(); // Kolom baru
            $table->string('foto_usaha')->nullable();
            $table->string('foto_produk')->nullable();
            $table->text('catatan')->nullable(); // Kolom baru
            $table->foreignId('petugas_id')->constrained('petugas_gc');
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
        Schema::dropIfExists('prelist_se');
    }
};
