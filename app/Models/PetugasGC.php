<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasGC extends Model
{
    use HasFactory;
    protected $table = 'petugas_gc';

    protected $fillable = ['nama', 'email', 'password', 'foto', 'wil_tugas'];

    // Relasi: Satu petugas bisa melakukan banyak groundcheck
    public function groundchecks()
    {
        return $this->hasMany(GroundCheck::class, 'petugas_id', 'id');
    }
}
