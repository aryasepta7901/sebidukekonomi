<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GroundCheck extends Model
{
    use HasFactory;
    protected $table = 'prelist_se';
    protected $primaryKey = 'idsbr';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idsbr',
        'nama_usaha',
        'alamat',
        'kdprov',
        'kdkab',
        'kdkec',
        'kddesa',
        'latitude',
        'longitude',
        'kbli',
        'foto_usaha',
        'foto_produk',
        'catatan',
        'petugas_id'
    ];
    public function petugas()
    {
        return $this->belongsTo(PetugasGC::class, 'petugas_id', 'id');
    }
}
