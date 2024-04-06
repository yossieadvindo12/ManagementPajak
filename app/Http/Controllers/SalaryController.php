<?php

namespace App\Http\Controllers;

use App\Models\phh21;
use App\Models\Company;
use App\Exports\PphExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalaryController extends Controller
{
    //
    public function index()
    {
          $sql = "SELECT
          emp.nama,
          emp.nik,
          emp.npwp,
          c.name_company,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.gaji_pokok + ps.sc END),0) AS JANUARY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.gaji_pokok + ps.sc END),0) AS FEBRUARY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.gaji_pokok + ps.sc END),0) AS MARCH,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.gaji_pokok + ps.sc END),0) AS APRIL,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.gaji_pokok + ps.sc END),0) AS MAY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.gaji_pokok + ps.sc END),0) AS JUNE,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.gaji_pokok + ps.sc END),0)  AS JULY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.gaji_pokok + ps.sc END),0) AS AUGUST,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.gaji_pokok + ps.sc END),0)  AS SEPTEMBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.gaji_pokok + ps.sc END),0) AS OCTOBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.gaji_pokok + ps.sc END),0) AS NOVEMBER,
          ifnull(MAX(CASE WHEN MONTH(s.updated_at) = 12 THEN s.gaji_pokok END),0) AS DECEMBER,
          (
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.gaji_pokok + ps.sc END),0)+
           ifnull( MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(s.updated_at) = 12 THEN s.gaji_pokok END),0)
          ) total
      FROM
          employee AS emp
      LEFT JOIN phh21s ps  ON emp.id = ps.id_employee
      left join company c  on emp.id_company = c.id_company
      left join (
    	select id_employee, gaji_pokok, updated_at from salaries where month(updated_at) = 12 and year(updated_at) = year(now())
    ) s on emp.id = s.id_employee
      group by emp.nama,
          emp.nik,
          emp.npwp,
          c.name_company
      ";

        $dataSalary = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('salary.reportSalary',compact('dataSalary','dataPerusahaan'));

        }

        public function reportShow($id_company,$year)
    {
        //
        $sql = "SELECT
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.gaji_pokok + ps.sc END),0) AS JANUARY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.gaji_pokok + ps.sc END),0) AS FEBRUARY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.gaji_pokok + ps.sc END),0) AS MARCH,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.gaji_pokok + ps.sc END),0) AS APRIL,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.gaji_pokok + ps.sc END),0) AS MAY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.gaji_pokok + ps.sc END),0) AS JUNE,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.gaji_pokok + ps.sc END),0)  AS JULY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.gaji_pokok + ps.sc END),0) AS AUGUST,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.gaji_pokok + ps.sc END),0)  AS SEPTEMBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.gaji_pokok + ps.sc END),0) AS OCTOBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.gaji_pokok + ps.sc END),0) AS NOVEMBER,
        ifnull(MAX(CASE WHEN MONTH(s.updated_at) = 12 THEN s.gaji_pokok END),0) AS DECEMBER,
        (
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.gaji_pokok + ps.sc END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.gaji_pokok + ps.sc END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.gaji_pokok + ps.sc END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.gaji_pokok + ps.sc END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.gaji_pokok + ps.sc END),0)+
         ifnull( MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.gaji_pokok + ps.sc END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.gaji_pokok + ps.sc END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.gaji_pokok + ps.sc END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.gaji_pokok + ps.sc END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.gaji_pokok + ps.sc END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.gaji_pokok + ps.sc END),0)+
          ifnull(MAX(CASE WHEN MONTH(s.updated_at) = 12 THEN s.gaji_pokok END),0)
        ) total
    FROM
        employee AS emp
    LEFT JOIN phh21s ps  ON emp.id = ps.id_employee
    left join company c  on emp.id_company = c.id_company
    left join (
    	select id_employee, gaji_pokok, updated_at from salaries where month(updated_at) = 12 and year(updated_at) = year(now())
    ) s on emp.id = s.id_employee
        WHERE emp.id_company = :id_company
        and year(ps.updated_at) = :yearnum
    group by emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company";


        $dataSalary = DB::select($sql, ['id_company' => $id_company, 'yearnum' => $year]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('salary.reportSalary', compact('dataSalary','dataPerusahaan'));
    }

    public function exportA1($id_company, $year) 
    {
        $data = DB::table('employee as emp')
    ->select(
        'emp.nama',
        'emp.nik',
        'emp.npwp',
        'c.name_company',
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.gaji_pokok + ps.sc END),0) AS JANUARY'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.gaji_pokok + ps.sc END),0) AS FEBRUARY'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.gaji_pokok + ps.sc END),0) AS MARCH'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.gaji_pokok + ps.sc END),0) AS APRIL'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.gaji_pokok + ps.sc END),0) AS MAY'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.gaji_pokok + ps.sc END),0) AS JUNE'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.gaji_pokok + ps.sc END),0) AS JULY'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.gaji_pokok + ps.sc END),0) AS AUGUST'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.gaji_pokok + ps.sc END),0) AS SEPTEMBER'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.gaji_pokok + ps.sc END),0) AS OCTOBER'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.gaji_pokok + ps.sc END),0) AS NOVEMBER'),
        DB::raw('ifnull(MAX(CASE WHEN MONTH(s.updated_at) = 12 THEN s.gaji_pokok END),0) AS DECEMBER'),
        DB::raw('(
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.gaji_pokok + ps.sc END),0)+
            ifnull(MAX(CASE WHEN MONTH(s.updated_at) = 12 THEN s.gaji_pokok END),0)
        ) AS total')
    )
    ->leftJoin('phh21s as ps', 'emp.id', '=', 'ps.id_employee')
    ->leftJoin('company as c', 'emp.id_company', '=', 'c.id_company')
    ->leftJoin(DB::raw("
    (SELECT id_employee, gaji_pokok, updated_at 
    FROM salaries 
    WHERE MONTH(updated_at) = 12 
    AND YEAR(updated_at) = $year) AS s"), 
    'emp.id', '=', 's.id_employee')
    ->where('emp.id_company', '=', $id_company)
    ->whereYear('ps.updated_at', '=', $year)
    ->groupBy('emp.nama', 'emp.nik', 'emp.npwp', 'c.name_company')
    ->get();

        return Excel::download(new PphExport($data), 'GajiA1.xlsx');
    }
}
