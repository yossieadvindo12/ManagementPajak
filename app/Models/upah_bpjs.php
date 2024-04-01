<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class upah_bpjs extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_employee',
        'upah_bpjs'
    ];
}
