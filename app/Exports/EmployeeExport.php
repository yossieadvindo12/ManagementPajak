<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
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
        $attributes = array_keys($this->collection()->first()->getAttributes());
        return $attributes;
    }
}
