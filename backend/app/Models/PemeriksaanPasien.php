<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanPasien extends Model
{
    //

    use HasFactory;

    protected $table = 'pemeriksaanpasien';

    protected $fillable = [
        'is_active',
        'bb',
        'td',
        'keluhan',
        'diagnosa',
        'uuid_pasien',
    ];

}
