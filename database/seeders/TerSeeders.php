<?php

namespace Database\Seeders;

use App\Models\Ter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TerSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $ter = [
                [
                 'MIN'=> 0,
                 'MAX'=> 5400000,
                 'Presentase'=> 0,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 0,00%'
                ],
                [
                 'MIN'=> 5400000,
                 'MAX'=> 5650000,
                 'Presentase'=> 0.0025,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 0,25%'
                ],
                [
                 'MIN'=> 5650000,
                 'MAX'=> 5950000,
                 'Presentase'=> 0.005,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 0,50%'
                ],
                [
                 'MIN'=> 5950000,
                 'MAX'=> 6300000,
                 'Presentase'=> 0.0075,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 0,75%'
                ],
                [
                 'MIN'=> 6300000,
                 'MAX'=> 6750000,
                 'Presentase'=> 0.01,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 1,00%'
                ],
                [
                 'MIN'=> 6750000,
                 'MAX'=> 7500000,
                 'Presentase'=> 0.0125,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 1,25%'
                ],
                [
                 'MIN'=> 7500000,
                 'MAX'=> 8550000,
                 'Presentase'=> 0.015,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 1,50%'
                ],
                [
                 'MIN'=> 8550000,
                 'MAX'=> 9650000,
                 'Presentase'=> 0.0175,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 1,75%'
                ],
                [
                 'MIN'=> 9650000,
                 'MAX'=> 10050000,
                 'Presentase'=> 0.02,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 2,00%'
                ],
                [
                 'MIN'=> 10050000,
                 'MAX'=> 10350000,
                 'Presentase'=> 0.0225,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 2,25%'
                ],
                [
                 'MIN'=> 10350000,
                 'MAX'=> 10700000,
                 'Presentase'=> 0.025,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 2,50%'
                ],
                [
                 'MIN'=> 10700000,
                 'MAX'=> 11050000,
                 'Presentase'=> 0.03,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 3,00%'
                ],
                [
                 'MIN'=> 11050000,
                 'MAX'=> 11600000,
                 'Presentase'=> 0.035,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 3,50%'
                ],
                [
                 'MIN'=> 11600000,
                 'MAX'=> 12500000,
                 'Presentase'=> 0.04,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 4,00%'
                ],
                [
                 'MIN'=> 12500000,
                 'MAX'=> 13750000,
                 'Presentase'=> 0.05,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 5,00%'
                ],
                [
                 'MIN'=> 13750000,
                 'MAX'=> 15100000,
                 'Presentase'=> 0.06,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 6,00%'
                ],
                [
                 'MIN'=> 15100000,
                 'MAX'=> 16950000,
                 'Presentase'=> 0.07,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 7,00%'
                ],
                [
                 'MIN'=> 16950000,
                 'MAX'=> 19750000,
                 'Presentase'=> 0.08,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 8,00%'
                ],
                [
                 'MIN'=> 19750000,
                 'MAX'=> 24150000,
                 'Presentase'=> 0.09,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 9,00%'
                ],
                [
                 'MIN'=> 24150000,
                 'MAX'=> 26450000,
                 'Presentase'=> 0.1,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 10,00%'
                ],
                [
                 'MIN'=> 26450000,
                 'MAX'=> 28000000,
                 'Presentase'=> 0.11,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 11,00%'
                ],
                [
                 'MIN'=> 28000000,
                 'MAX'=> 30050000,
                 'Presentase'=> 0.12,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 12,00%'
                ],
                [
                 'MIN'=> 30050000,
                 'MAX'=> 32400000,
                 'Presentase'=> 0.13,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 13,00%'
                ],
                [
                 'MIN'=> 32400000,
                 'MAX'=> 35400000,
                 'Presentase'=> 0.14,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 14,00%'
                ],
                [
                 'MIN'=> 35400000,
                 'MAX'=> 39100000,
                 'Presentase'=> 0.15,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 15,00%'
                ],
                [
                 'MIN'=> 39100000,
                 'MAX'=> 43850000,
                 'Presentase'=> 0.16,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 16,00%'
                ],
                [
                 'MIN'=> 43850000,
                 'MAX'=> 47800000,
                 'Presentase'=> 0.17,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 17,00%'
                ],
                [
                 'MIN'=> 47800000,
                 'MAX'=> 51400000,
                 'Presentase'=> 0.18,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 18,00%'
                ],
                [
                 'MIN'=> 51400000,
                 'MAX'=> 56300000,
                 'Presentase'=> 0.19,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 19,00%'
                ],
                [
                 'MIN'=> 56300000,
                 'MAX'=> 62200000,
                 'Presentase'=> 0.2,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 20,00%'
                ],
                [
                 'MIN'=> 62200000,
                 'MAX'=> 68600000,
                 'Presentase'=> 0.21,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 21,00%'
                ],
                [
                 'MIN'=> 68600000,
                 'MAX'=> 77500000,
                 'Presentase'=> 0.22,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 22,00%'
                ],
                [
                 'MIN'=> 77500000,
                 'MAX'=> 89000000,
                 'Presentase'=> 0.23,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 23,00%'
                ],
                [
                 'MIN'=> 89000000,
                 'MAX'=> 103000000,
                 'Presentase'=> 0.24,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 24,00%'
                ],
                [
                 'MIN'=> 103000000,
                 'MAX'=> 125000000,
                 'Presentase'=> 0.25,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 25,00%'
                ],
                [
                 'MIN'=> 125000000,
                 'MAX'=> 157000000,
                 'Presentase'=> 0.26,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 26,00%'
                ],
                [
                 'MIN'=> 157000000,
                 'MAX'=> 206000000,
                 'Presentase'=> 0.27,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 27,00%'
                ],
                [
                 'MIN'=> 206000000,
                 'MAX'=> 337000000,
                 'Presentase'=> 0.28,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 28,00%'
                ],
                [
                 'MIN'=> 337000000,
                 'MAX'=> 454000000,
                 'Presentase'=> 0.29,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 29,00%'
                ],
                [
                 'MIN'=> 454000000,
                 'MAX'=> 550000000,
                 'Presentase'=> 0.3,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 30,00%'
                ],
                [
                 'MIN'=> 550000000,
                 'MAX'=> 695000000,
                 'Presentase'=> 0.31,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 31,00%'
                ],
                [
                 'MIN'=> 695000000,
                 'MAX'=> 910000000,
                 'Presentase'=> 0.32,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 32,00%'
                ],
                [
                 'MIN'=> 910000000,
                 'MAX'=> 1400000000,
                 'Presentase'=> 0.33,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 33,00%'
                ],
                [
                 'MIN'=> 1400000000,
                 'MAX'=> NULL,
                 'Presentase'=> 0.34,
                 'TER'=> 'TER A',
                 'TER ALIAS'=> 'TER A 34,00%'
                ],
                [
                 'MIN'=> 0,
                 'MAX'=> 6200000,
                 'Presentase'=> 0,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 0,00%'
                ],
                [
                 'MIN'=> 6200000,
                 'MAX'=> 6500000,
                 'Presentase'=> 0.0025,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 0,25%'
                ],
                [
                 'MIN'=> 6500000,
                 'MAX'=> 6850000,
                 'Presentase'=> 0.005,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 0,50%'
                ],
                [
                 'MIN'=> 6850000,
                 'MAX'=> 7300000,
                 'Presentase'=> 0.0075,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 0,75%'
                ],
                [
                 'MIN'=> 7300000,
                 'MAX'=> 9200000,
                 'Presentase'=> 0.01,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 1,00%'
                ],
                [
                 'MIN'=> 9200000,
                 'MAX'=> 10750000,
                 'Presentase'=> 0.015,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 1,50%'
                ],
                [
                 'MIN'=> 10750000,
                 'MAX'=> 11250000,
                 'Presentase'=> 0.02,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 2,00%'
                ],
                [
                 'MIN'=> 11250000,
                 'MAX'=> 11600000,
                 'Presentase'=> 0.025,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 2,50%'
                ],
                [
                 'MIN'=> 11600000,
                 'MAX'=> 12600000,
                 'Presentase'=> 0.03,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 3,00%'
                ],
                [
                 'MIN'=> 12600000,
                 'MAX'=> 13600000,
                 'Presentase'=> 0.04,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 4,00%'
                ],
                [
                 'MIN'=> 13600000,
                 'MAX'=> 14950000,
                 'Presentase'=> 0.05,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 5,00%'
                ],
                [
                 'MIN'=> 14950000,
                 'MAX'=> 16400000,
                 'Presentase'=> 0.06,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 6,00%'
                ],
                [
                 'MIN'=> 16400000,
                 'MAX'=> 18450000,
                 'Presentase'=> 0.07,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 7,00%'
                ],
                [
                 'MIN'=> 18450000,
                 'MAX'=> 21850000,
                 'Presentase'=> 0.08,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 8,00%'
                ],
                [
                 'MIN'=> 21850000,
                 'MAX'=> 26000000,
                 'Presentase'=> 0.09,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 9,00%'
                ],
                [
                 'MIN'=> 26000000,
                 'MAX'=> 27700000,
                 'Presentase'=> 0.1,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 10,00%'
                ],
                [
                 'MIN'=> 27700000,
                 'MAX'=> 29350000,
                 'Presentase'=> 0.11,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 11,00%'
                ],
                [
                 'MIN'=> 29350000,
                 'MAX'=> 31450000,
                 'Presentase'=> 0.12,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 12,00%'
                ],
                [
                 'MIN'=> 31450000,
                 'MAX'=> 33950000,
                 'Presentase'=> 0.13,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 13,00%'
                ],
                [
                 'MIN'=> 33950000,
                 'MAX'=> 37100000,
                 'Presentase'=> 0.14,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 14,00%'
                ],
                [
                 'MIN'=> 37100000,
                 'MAX'=> 41100000,
                 'Presentase'=> 0.15,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 15,00%'
                ],
                [
                 'MIN'=> 41100000,
                 'MAX'=> 45800000,
                 'Presentase'=> 0.16,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 16,00%'
                ],
                [
                 'MIN'=> 45800000,
                 'MAX'=> 49500000,
                 'Presentase'=> 0.17,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 17,00%'
                ],
                [
                 'MIN'=> 49500000,
                 'MAX'=> 53800000,
                 'Presentase'=> 0.18,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 18,00%'
                ],
                [
                 'MIN'=> 53800000,
                 'MAX'=> 58500000,
                 'Presentase'=> 0.19,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 19,00%'
                ],
                [
                 'MIN'=> 58500000,
                 'MAX'=> 64000000,
                 'Presentase'=> 0.2,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 20,00%'
                ],
                [
                 'MIN'=> 64000000,
                 'MAX'=> 71000000,
                 'Presentase'=> 0.21,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 21,00%'
                ],
                [
                 'MIN'=> 71000000,
                 'MAX'=> 80000000,
                 'Presentase'=> 0.22,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 22,00%'
                ],
                [
                 'MIN'=> 80000000,
                 'MAX'=> 93000000,
                 'Presentase'=> 0.23,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 23,00%'
                ],
                [
                 'MIN'=> 93000000,
                 'MAX'=> 109000000,
                 'Presentase'=> 0.24,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 24,00%'
                ],
                [
                 'MIN'=> 109000000,
                 'MAX'=> 129000000,
                 'Presentase'=> 0.25,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 25,00%'
                ],
                [
                 'MIN'=> 129000000,
                 'MAX'=> 163000000,
                 'Presentase'=> 0.26,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 26,00%'
                ],
                [
                 'MIN'=> 163000000,
                 'MAX'=> 211000000,
                 'Presentase'=> 0.27,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 27,00%'
                ],
                [
                 'MIN'=> 211000000,
                 'MAX'=> 374000000,
                 'Presentase'=> 0.28,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 28,00%'
                ],
                [
                 'MIN'=> 374000000,
                 'MAX'=> 459000000,
                 'Presentase'=> 0.29,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 29,00%'
                ],
                [
                 'MIN'=> 459000000,
                 'MAX'=> 555000000,
                 'Presentase'=> 0.3,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 30,00%'
                ],
                [
                 'MIN'=> 555000000,
                 'MAX'=> 704000000,
                 'Presentase'=> 0.31,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 31,00%'
                ],
                [
                 'MIN'=> 704000000,
                 'MAX'=> 957000000,
                 'Presentase'=> 0.32,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 32,00%'
                ],
                [
                 'MIN'=> 957000000,
                 'MAX'=> 1405000000,
                 'Presentase'=> 0.33,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 33,00%'
                ],
                [
                 'MIN'=> 1405000000,
                 'MAX'=> NULL,
                 'Presentase'=> 0.34,
                 'TER'=> 'TER B',
                 'TER ALIAS'=> 'TER B 34,00%'
                ],
                [
                 'MIN'=> 0,
                 'MAX'=> 6600000,
                 'Presentase'=> 0,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 0,00%'
                ],
                [
                 'MIN'=> 6600000,
                 'MAX'=> 6950000,
                 'Presentase'=> 0.0025,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 0,25%'
                ],
                [
                 'MIN'=> 6950000,
                 'MAX'=> 7350000,
                 'Presentase'=> 0.005,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 0,50%'
                ],
                [
                 'MIN'=> 7350000,
                 'MAX'=> 7800000,
                 'Presentase'=> 0.0075,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 0,75%'
                ],
                [
                 'MIN'=> 7800000,
                 'MAX'=> 8850000,
                 'Presentase'=> 0.01,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 1,00%'
                ],
                [
                 'MIN'=> 8850000,
                 'MAX'=> 9800000,
                 'Presentase'=> 0.0125,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 1,25%'
                ],
                [
                 'MIN'=> 9800000,
                 'MAX'=> 10950000,
                 'Presentase'=> 0.015,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 1,50%'
                ],
                [
                 'MIN'=> 10950000,
                 'MAX'=> 11200000,
                 'Presentase'=> 0.0175,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 1,75%'
                ],
                [
                 'MIN'=> 11200000,
                 'MAX'=> 12050000,
                 'Presentase'=> 0.02,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 2,00%'
                ],
                [
                 'MIN'=> 12050000,
                 'MAX'=> 12950000,
                 'Presentase'=> 0.03,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 3,00%'
                ],
                [
                 'MIN'=> 12950000,
                 'MAX'=> 14150000,
                 'Presentase'=> 0.04,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 4,00%'
                ],
                [
                 'MIN'=> 14150000,
                 'MAX'=> 15550000,
                 'Presentase'=> 0.05,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 5,00%'
                ],
                [
                 'MIN'=> 15550000,
                 'MAX'=> 17050000,
                 'Presentase'=> 0.06,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 6,00%'
                ],
                [
                 'MIN'=> 17050000,
                 'MAX'=> 19500000,
                 'Presentase'=> 0.07,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 7,00%'
                ],
                [
                 'MIN'=> 19500000,
                 'MAX'=> 22700000,
                 'Presentase'=> 0.08,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 8,00%'
                ],
                [
                 'MIN'=> 22700000,
                 'MAX'=> 26600000,
                 'Presentase'=> 0.09,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 9,00%'
                ],
                [
                 'MIN'=> 26600000,
                 'MAX'=> 28100000,
                 'Presentase'=> 0.1,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 10,00%'
                ],
                [
                 'MIN'=> 28100000,
                 'MAX'=> 30100000,
                 'Presentase'=> 0.11,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 11,00%'
                ],
                [
                 'MIN'=> 30100000,
                 'MAX'=> 32600000,
                 'Presentase'=> 0.12,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 12,00%'
                ],
                [
                 'MIN'=> 32600000,
                 'MAX'=> 35400000,
                 'Presentase'=> 0.13,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 13,00%'
                ],
                [
                 'MIN'=> 35400000,
                 'MAX'=> 38900000,
                 'Presentase'=> 0.14,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 14,00%'
                ],
                [
                 'MIN'=> 38900000,
                 'MAX'=> 43000000,
                 'Presentase'=> 0.15,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 15,00%'
                ],
                [
                 'MIN'=> 43000000,
                 'MAX'=> 47400000,
                 'Presentase'=> 0.16,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 16,00%'
                ],
                [
                 'MIN'=> 47400000,
                 'MAX'=> 51200000,
                 'Presentase'=> 0.17,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 17,00%'
                ],
                [
                 'MIN'=> 51200000,
                 'MAX'=> 55800000,
                 'Presentase'=> 0.18,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 18,00%'
                ],
                [
                 'MIN'=> 55800000,
                 'MAX'=> 60400000,
                 'Presentase'=> 0.19,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 19,00%'
                ],
                [
                 'MIN'=> 60400000,
                 'MAX'=> 66700000,
                 'Presentase'=> 0.2,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 20,00%'
                ],
                [
                 'MIN'=> 66700000,
                 'MAX'=> 74500000,
                 'Presentase'=> 0.21,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 21,00%'
                ],
                [
                 'MIN'=> 74500000,
                 'MAX'=> 83200000,
                 'Presentase'=> 0.22,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 22,00%'
                ],
                [
                 'MIN'=> 83200000,
                 'MAX'=> 95000000,
                 'Presentase'=> 0.23,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 23,00%'
                ],
                [
                 'MIN'=> 95600000,
                 'MAX'=> 110000000,
                 'Presentase'=> 0.24,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 24,00%'
                ],
                [
                 'MIN'=> 110000000,
                 'MAX'=> 134000000,
                 'Presentase'=> 0.25,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 25,00%'
                ],
                [
                 'MIN'=> 134000000,
                 'MAX'=> 169000000,
                 'Presentase'=> 0.26,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 26,00%'
                ],
                [
                 'MIN'=> 169000000,
                 'MAX'=> 221000000,
                 'Presentase'=> 0.27,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 27,00%'
                ],
                [
                 'MIN'=> 221000000,
                 'MAX'=> 390000000,
                 'Presentase'=> 0.28,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 28,00%'
                ],
                [
                 'MIN'=> 390000000,
                 'MAX'=> 463000000,
                 'Presentase'=> 0.39,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 39,00%'
                ],
                [
                 'MIN'=> 463000000,
                 'MAX'=> 561000000,
                 'Presentase'=> 0.3,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 30,00%'
                ],
                [
                 'MIN'=> 561000000,
                 'MAX'=> 709000000,
                 'Presentase'=> 0.31,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 31,00%'
                ],
                [
                 'MIN'=> 709000000,
                 'MAX'=> 965000000,
                 'Presentase'=> 0.32,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 32,00%'
                ],
                [
                 'MIN'=> 965000000,
                 'MAX'=> 1419000000,
                 'Presentase'=> 0.33,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 33,00%'
                ],
                [
                 'MIN'=> 1419000000,
                 'MAX'=> NULL,
                 'Presentase'=> 0.34,
                 'TER'=> 'TER C',
                 'TER ALIAS'=> 'TER C 34,00%'
                ]
               
                
               
        ];
        DB::table('ter')->insert($ter);
    }
}
