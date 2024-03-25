<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PphReportController extends Controller
{
    //
    public function index()
    {
          $sql = "SELECT
          emp.nama,
          emp.nik,
          emp.npwp,
          c.name_company,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.pph21 END),0) AS JANUARY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.pph21 END),0) AS FEBRUARY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.pph21 END),0) AS MARCH,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.pph21 END),0) AS APRIL,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.pph21 END),0) AS MAY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.pph21 END),0) AS JUNE,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.pph21 END),0)  AS JULY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.pph21 END),0) AS AUGUST,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.pph21 END),0)  AS SEPTEMBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.pph21 END),0) AS OCTOBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.pph21 END),0) AS NOVEMBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.pph21 END),0) AS DECEMBER,
          (
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.pph21 END),0)+
           ifnull( MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.pph21 END),0)
          ) total
      FROM
          employee AS emp
      LEFT JOIN phh21s ps  ON emp.id = ps.id_employee
      left join company c  on emp.id_company = c.id_company
      where  keterangan_pph = 'reportMonthly'
      group by emp.nama,
          emp.nik,
          emp.npwp,
          c.name_company
      ";

        $dataSalary = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('pphReport.reportPph',compact('dataSalary','dataPerusahaan'));

        }

        public function reportShow($id_company,$year)
    {
        //
        $sql = "SELECT
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.pph21 END),0) AS JANUARY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.pph21 END),0) AS FEBRUARY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.pph21 END),0) AS MARCH,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.pph21 END),0) AS APRIL,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.pph21 END),0) AS MAY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.pph21 END),0) AS JUNE,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.pph21 END),0)  AS JULY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.pph21 END),0) AS AUGUST,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.pph21 END),0)  AS SEPTEMBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.pph21 END),0) AS OCTOBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.pph21 END),0) AS NOVEMBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.pph21 END),0) AS DECEMBER,
        (
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.pph21 END),0)+
         ifnull( MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.pph21 END),0)
        ) total
    FROM
        employee AS emp
    LEFT JOIN phh21s ps  ON emp.id = ps.id_employee
    left join company c  on emp.id_company = c.id_company
        WHERE emp.id_company = :id_company
        and year(ps.updated_at) = :yearnum
        and keterangan_pph = 'reportMonthly'
    group by emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company";


        $dataSalary = DB::select($sql, ['id_company' => $id_company, 'yearnum' => $year]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('pphReport.reportPph', compact('dataSalary','dataPerusahaan'));
    }

    public function pphthrindex()
    {
          $sql = "SELECT
          emp.nama,
          emp.nik,
          emp.npwp,
          c.name_company,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.pph21 END),0) AS JANUARY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.pph21 END),0) AS FEBRUARY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.pph21 END),0) AS MARCH,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.pph21 END),0) AS APRIL,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.pph21 END),0) AS MAY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.pph21 END),0) AS JUNE,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.pph21 END),0)  AS JULY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.pph21 END),0) AS AUGUST,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.pph21 END),0)  AS SEPTEMBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.pph21 END),0) AS OCTOBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.pph21 END),0) AS NOVEMBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.pph21 END),0) AS DECEMBER,
          (
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.pph21 END),0)+
           ifnull( MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.pph21 END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.pph21 END),0)
          ) total
      FROM
          employee AS emp
      LEFT JOIN phh21s ps  ON emp.id = ps.id_employee
      left join company c  on emp.id_company = c.id_company
      where  keterangan_pph = 'reportTHR'
      group by emp.nama,
          emp.nik,
          emp.npwp,
          c.name_company
      ";

        $dataSalary = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('pphReport.reportPphTHR',compact('dataSalary','dataPerusahaan'));

        }

        public function reportPphTHRShow($id_company,$year)
    {
        //
        $sql = "SELECT
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.pph21 END),0) AS JANUARY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.pph21 END),0) AS FEBRUARY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.pph21 END),0) AS MARCH,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.pph21 END),0) AS APRIL,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.pph21 END),0) AS MAY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.pph21 END),0) AS JUNE,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.pph21 END),0)  AS JULY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.pph21 END),0) AS AUGUST,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.pph21 END),0)  AS SEPTEMBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.pph21 END),0) AS OCTOBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.pph21 END),0) AS NOVEMBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.pph21 END),0) AS DECEMBER,
        (
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.pph21 END),0)+
         ifnull( MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.pph21 END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.pph21 END),0)
        ) total
    FROM
        employee AS emp
    LEFT JOIN phh21s ps  ON emp.id = ps.id_employee
    left join company c  on emp.id_company = c.id_company
        WHERE emp.id_company = :id_company
        and year(ps.updated_at) = :yearnum
        and keterangan_pph = 'reportTHR'
    group by emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company";


        $dataSalary = DB::select($sql, ['id_company' => $id_company, 'yearnum' => $year]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('pphReport.reportPphTHR', compact('dataSalary','dataPerusahaan'));
    }
    public function thrindex()
    {
          $sql = "SELECT
          emp.nama,
          emp.nik,
          emp.npwp,
          c.name_company,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.thr END),0) AS JANUARY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.thr END),0) AS FEBRUARY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.thr END),0) AS MARCH,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.thr END),0) AS APRIL,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.thr END),0) AS MAY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.thr END),0) AS JUNE,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.thr END),0)  AS JULY,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.thr END),0) AS AUGUST,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.thr END),0)  AS SEPTEMBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.thr END),0) AS OCTOBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.thr END),0) AS NOVEMBER,
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.thr END),0) AS DECEMBER,
          (
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.thr END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.thr END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.thr END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.thr END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.thr END),0)+
           ifnull( MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.thr END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.thr END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.thr END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.thr END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.thr END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.thr END),0)+
            ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.thr END),0)
          ) total
      FROM
          employee AS emp
      LEFT JOIN phh21s ps  ON emp.id = ps.id_employee
      left join company c  on emp.id_company = c.id_company
      where  keterangan_pph = 'reportTHR'
      group by emp.nama,
          emp.nik,
          emp.npwp,
          c.name_company
      ";

        $dataSalary = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('pphReport.reportTHR',compact('dataSalary','dataPerusahaan'));

        }

        public function reportTHRShow($id_company,$year)
    {
        //
        $sql = "SELECT
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.thr END),0) AS JANUARY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.thr END),0) AS FEBRUARY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.thr END),0) AS MARCH,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.thr END),0) AS APRIL,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.thr END),0) AS MAY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.thr END),0) AS JUNE,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.thr END),0)  AS JULY,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.thr END),0) AS AUGUST,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.thr END),0)  AS SEPTEMBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.thr END),0) AS OCTOBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.thr END),0) AS NOVEMBER,
        ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.thr END),0) AS DECEMBER,
        (
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 1 THEN ps.thr END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 2 THEN ps.thr END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 3 THEN ps.thr END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 4 THEN ps.thr END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 5 THEN ps.thr END),0)+
         ifnull( MAX(CASE WHEN MONTH(ps.updated_at) = 6 THEN ps.thr END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 7 THEN ps.thr END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 8 THEN ps.thr END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 9 THEN ps.thr END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 10 THEN ps.thr END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 11 THEN ps.thr END),0)+
          ifnull(MAX(CASE WHEN MONTH(ps.updated_at) = 12 THEN ps.thr END),0)
        ) total
    FROM
        employee AS emp
    LEFT JOIN phh21s ps  ON emp.id = ps.id_employee
    left join company c  on emp.id_company = c.id_company
        WHERE emp.id_company = :id_company
        and year(ps.updated_at) = :yearnum
        and keterangan_pph = 'reportTHR'
    group by emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company";


        $dataSalary = DB::select($sql, ['id_company' => $id_company, 'yearnum' => $year]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('pphReport.reportTHR', compact('dataSalary','dataPerusahaan'));
    }
}
