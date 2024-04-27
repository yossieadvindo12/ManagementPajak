<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PphExportBulanan implements FromCollection, WithHeadings
{
        protected $data;

        public function __construct($data)
        {
            $this->data = $data;
        }

        public function collection()
        {
            return $this->data;
        }

        public function headings(): array
        {
            return [
                'Id',
                'Nama',
                'NIK',
                'NPWP',
                'Nama Perusahaan',
                'Gaji Pokok',
                'BPJS',
                'SC',
                'NATURA',
                'THR',
                'LAIN - LAIN',
                'GAJI BRUTO',
                'Ter Alias',
                'PPH 21',
                'THP',
                'GROSS UP',
                'KETERANGAN PPH',
                'BULAN',
                'TAHUN'
            ];
        }

}
