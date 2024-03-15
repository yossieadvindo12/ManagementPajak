<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BPJS extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'id_company',
        'gaji_pokok',
        'jht_karyawan',
        'jht_pt',
        'jkm',
        'jkk',
        'jp_karyawan',
        'jp_pt',
        'bpjs_kesehatan',
        'ditanggung_karyawan',
        'ditanggung_pt'
    ];

    protected $table = 'bpjs';
}
