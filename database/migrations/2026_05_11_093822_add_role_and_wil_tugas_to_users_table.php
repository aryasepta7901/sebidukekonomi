<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom role setelah password
            $table->string('role')->default('petugas')->after('password');

            // Tambahkan kolom wil_tugas setelah role
            // Gunakan json agar bisa menampung banyak kode wilayah 16 digit
            $table->json('wil_tugas')->nullable()->after('role');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kembali kolom jika migration di-rollback
            $table->dropColumn(['role', 'wil_tugas']);
        });
    }
};
