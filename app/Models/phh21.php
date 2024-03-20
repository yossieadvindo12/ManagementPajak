<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phh21 extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'id_company',
        'gaji_pokok',
        'A5',
        'sc',
        'natura',
        'gaji_bruto',
        'Ter alias',
        'pph21',
        'thp',
        'gross_up',
        'keterangan_pph'
    ];

    
}
