<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PphExport implements FromCollection, WithHeadings
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
                'Nama',
                'NIK',
                'NPWP',
                'Company Name',
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December',
                'Total'
            ];
        }

}
