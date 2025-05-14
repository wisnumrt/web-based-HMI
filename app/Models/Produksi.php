<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    protected $table = 'produksi'; // Nama tabel
    protected $primaryKey = 'id_produksi'; // Primary 

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'id');
    }

    // Model Pekerjaan.php
    public function produksis()
    {
        return $this->hasMany(Produksi::class, 'id_produksi');
    }

    public function produksi()
    {
        return $this->hasOne(Produksi::class, 'id_produksi');
    }

    protected $fillable = [
        'id',
        'durasi_pre',
        'durasi_run',
        'durasi_trouble',
        'j_trouble',
        'durasi_break',
        'j_breakdown',
        'realisasi',
        'waste',
        'speed',
        'plate',
        'kertas',
        'tinta',
    ];
}
