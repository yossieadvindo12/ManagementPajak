<?php
 
namespace App\Exports;

use App\Models\Bpjs;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BpjsExport implements WithMapping
{
    /**
    * @return \Illuminate\Support\FromQuery
    */

    protected $year;
    protected $data;

    // function __construct($year) {
    //     $this->year = $year;
    // }

    function __construct($data) {
        $this->data = $data;
    }


    // public function view(): View
    // {
    //     return view('bpjs.reportBpjs', [
    //         'dataBPJS' => Bpjs::all()
    //     ]);
    // }
    public function map($data): array
    {
        // This example will return 3 rows.
        // First row will have 2 column, the next 2 will have 1 column
        return [
            $data->nama,
            $data->nama_perusahaan,
        ];
    }

    // public function headings(): array
    // {
    //     $attributes = array_keys($this->collection()->first()->getAttributes());
    //     return $attributes;
    // }
}