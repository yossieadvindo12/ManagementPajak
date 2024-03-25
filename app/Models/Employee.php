<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
           /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $fillable = [
        'nik',
        'npwp',
        'nama',
        'tempat',
        'tanggal_lahir',
        'alamat',
        'is_active',
        'status_ptkp',
        'kode_karyawan',
        'status_bpjs',
        'id_company'
    ];
    protected $table = 'employee';
    public $timestamps = false;
}
