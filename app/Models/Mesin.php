<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    protected $table = 'mesin'; // Nama tabel
    protected $primaryKey = 'id_mesin'; // Primary key


    protected $fillable = [
        'id_mesin',
        'nama',
    ];
}
