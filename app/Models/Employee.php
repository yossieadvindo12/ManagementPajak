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
        'nama',
        'tempat',
        'tanggal_lahir',
        'alamat',
        'is_active',
        'status_ptkp',
        'kode_karyawan',
        'id_company'
    ];
    protected $table = 'employee';
    public $timestamps = false;
}
