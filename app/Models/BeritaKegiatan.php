<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BeritaKegiatan extends Model
{
    use HasFactory;

    protected $table = 'berita_kegiatan';

    protected $fillable = [
        'user_id',
        'id_jenis_laporan',
        'judul',
        'tanggal',
        'tempat',
        'jumlah_peserta',
        'deskripsi',
        'gambar',
        'link_pdf'
    ];

    // CRITICAL: Casting agar Laravel otomatis handle JSON <-> Array
    protected $casts = [
        'gambar' => 'array',
        'link_pdf' => 'array',
        'tanggal' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function jenisLaporan()
    // {
    //     return $this->belongsTo(JenisLaporan::class, 'id_jenis_laporan');
    // }
}
