<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiKinerja extends Model
{
    protected $table = 'realisasi_kinerja'; // Tentukan nama tabel secara eksplisit

    protected $fillable = [
        'pegawai_id',
        'indikator_id',
        'periode',
        'target',
        'realisasi'
    ];

    public function pegawai()
    {
        return $this->belongsTo(User::class);
    }

    public function indikator()
    {
        return $this->belongsTo(ParameterIndikator::class);
    }
}