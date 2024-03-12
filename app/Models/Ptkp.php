<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ptkp extends Model
{
    use HasFactory;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ptkp',
        'besaran_ptkp'
    ];

    protected $table = 'ptkp';

    // Metode untuk mengambil data ptkp
    public static function getPtkpData()
    {
        return static::pluck('ptkp', 'ptkp');
    }
}
