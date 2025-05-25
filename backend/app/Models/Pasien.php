<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'uuid',
        'is_active',
        'nama',
        'tgl_lahir',
        'jenis_kelamin',
        'no_hp',
    ];
}
