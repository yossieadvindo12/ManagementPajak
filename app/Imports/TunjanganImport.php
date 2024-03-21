<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Tunjangan;
use App\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class TunjanganImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tunjangan([
            'id_employee' => $row['id_employee'],
            'nik' => $row['nik'],
            'npwp' => $row['npwp'],
            'sc' => $row['sc'],
            'natura' => $row['natura'],
            'bpjs_kesehatan' => $row['bpjs_kesehatan']
            'thr' => $row['thr']
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
