<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PtkpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'ptkp' => 'K/0',
                'besaran_ptkp' => '58500000'
            ],
            [
                'ptkp' => 'K/1',
                'besaran_ptkp' => '63000000'   
            ],
            [
                'ptkp' => 'K/2',
                'besaran_ptkp' => '67500000'   
            ],
            [
                'ptkp' => 'K/3',
                'besaran_ptkp' => '72000000'   
            ],
            [
                'ptkp' => 'TK/0',
                'besaran_ptkp' => '54000000'   
            ],
            [
                'ptkp' => 'TK/1',
                'besaran_ptkp' => '58500000'   
            ],
            [
                'ptkp' => 'TK/2',
                'besaran_ptkp' => '63000000'   
            ],
            [
                'ptkp' => 'TK/3',
                'besaran_ptkp' => '67500000'   
            ]
        ];
        DB::table('ptkp')->insert($data);
    }
}
