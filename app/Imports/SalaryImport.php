<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Salary;
use App\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class SalaryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Salary([
            'id_employee' => $row['id_employee'],
            'nik' => $row['nik'],
            'npwp' => $row['npwp'],
            'gaji_pokok' => $row['gaji_pokok']
        ]);
    }

    // public function uniqueBy()
    // {
    //     return 'id';
    // }

    // public function upsertColumns()
    // {
    //     return [ 'sc', 'natura','bpjs_kesehatan'];
    // }
}
