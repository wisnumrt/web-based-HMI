<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produksi;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'data_pekerjaan';
    
    protected $primaryKey = 'id'; // Primary key
    
    protected $fillable = [
        'id_mesin',
        'nomor_spk',
        'produk',
        'w_start',
        'w_finish',
        'quantity',
    ];


    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'id_mesin', 'id_mesin');
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



    public function getHasProductionAttribute()
    {
        return $this->produksi()->exists();
    }

    public function hasProductionData()
    {
        return $this->produksi()->exists();
    }
}