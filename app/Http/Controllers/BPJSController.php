<?php

namespace App\Http\Controllers;

use App\Exports\BpjsExport;
use App\Models\BPJS;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BPJSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sql = "SELECT
        emp.id,
        emp.nama,
        bpjs.nik,
        c.name_company,
        gaji_pokok,
        jht_karyawan,
      	jht_pt,
        jkm,
        jkk,
        jp_karyawan,
        jp_pt,
        bpjs_kesehatan,
        ditanggung_karyawan,
        ditanggung_pt,
        MONTHNAME(bpjs.updated_at) AS bulan,
        YEAR(bpjs.updated_at) AS year
        FROM bpjs
        LEFT JOIN company AS c ON bpjs.id_company = c.id_company
        left Join employee as emp on bpjs.id_employee = emp.id
        ";
        // GROUP BY bpjs.id, emp.nama,bpjs.nik, c.name_company,gaji_pokok,MONTHNAME(bpjs.updated_at),YEAR(bpjs.updated_at)

        $dataBPJS = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('bpjs.bpjs',compact('dataBPJS','dataPerusahaan'));
    }

    public function reportIndex()
    {
        //


        $sql ="SELECT
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JANUARY' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS JANUARY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'FEBRUARY' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS FEBRUARY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'MARCH' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS MARCH,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'APRIL' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS APRIL,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'MAY' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS MAY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JUNE' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS JUNE,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JULY' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS JULY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'AUGUST' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS AUGUST,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'SEPTEMBER' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS SEPTEMBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'OCTOBER' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS OCTOBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'NOVEMBER' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS NOVEMBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'DECEMBER' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS DECEMBER,
    sum(bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm) total
        from bpjs
        LEFT JOIN company AS c
                ON bpjs.id_company = c.id_company
        left Join employee as emp
                on bpjs.id_employee = emp.id
        where year(bpjs.updated_at)=2024
        group by emp.nama,c.name_company,emp.nik,
        emp.npwp
                ";
        // GROUP BY bpjs.id, emp.nama,bpjs.nik, c.name_company,gaji_pokok,MONTHNAME(bpjs.updated_at),YEAR(bpjs.updated_at)

        $dataBPJS = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('bpjs.reportbpjs',compact('dataBPJS','dataPerusahaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'id_company'  => 'required|integer',
            'month' => 'required|integer'

        ]);

        DB::delete("DELETE FROM bpjs WHERE id_company= :id_company and MONTH(updated_at) = :month and YEAR(updated_at)=YEAR(NOW())", ['id_company' => $request->id_company, 'month' => $request->month]);

        $sql = "INSERT INTO bpjs (id_employee,
        nik,npwp,
        id_company,
        gaji_pokok,
        jht_karyawan,
        jht_pt,
        jkm,
        jkk,
        jp_karyawan,
        jp_pt,
        bpjs_kesehatan,
        ditanggung_karyawan,
        ditanggung_pt,
        created_at,
        updated_at
        )
        (SELECT
    emp.id,
    emp.nik,
    emp.npwp,
    c.id_company,
    if(s.gaji_pokok is null,0,if(emp.status_BPJS = 1,max(ub.upah_bpjs),0)) upah,
    if(s.gaji_pokok is null,0,if(emp.status_BPJS = 1,max(ub.upah_bpjs),0)) * 0.02 AS jht_karyawan,
    if(s.gaji_pokok is null,0,if(emp.status_BPJS = 1,max(ub.upah_bpjs),0)) * 0.037 AS jht_pt,
    if(s.gaji_pokok is null,0,if(emp.status_BPJS = 1,max(ub.upah_bpjs),0)) * 0.0030 AS jkm,
    if(s.gaji_pokok is null,0,if(emp.status_BPJS = 1,max(ub.upah_bpjs),0)) * 0.0054 AS jkk,
    if(s.gaji_pokok is null,0,if(emp.status_BPJS = 1,max(ub.upah_bpjs),0)) * 0.01 AS jp_karyawan,
    if(s.gaji_pokok is null,0,if(emp.status_BPJS = 1,max(ub.upah_bpjs),0)) * 0.02 AS jp_pt,
    IF(t.bpjs_kesehatan IS NULL, 0, max(t.bpjs_kesehatan)) AS bpjs_kesehatan,
    if(emp.status_BPJS = 1,(ub.upah_bpjs * 0.02),0) +
    if(emp.status_BPJS = 1,(ub.upah_bpjs * 0.01),0) AS ditanggung_karyawan,
    if(emp.status_BPJS = 1,(ub.upah_bpjs * 0.037),0) +
    if(emp.status_BPJS = 1,(ub.upah_bpjs * 0.0030),0) +
    if(emp.status_BPJS = 1,(ub.upah_bpjs * 0.0054),0) +
    if(emp.status_BPJS = 1,(ub.upah_bpjs * 0.02),0) +
    IF(max(t.bpjs_kesehatan) IS NULL, 0, max(t.bpjs_kesehatan)) AS ditanggung_pt,
    DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum1), '-01'), '%Y-%m-%d') AS created_at,
    DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum2), '-01'), '%Y-%m-%d') AS updated_at
    FROM
    employee AS emp
    LEFT JOIN
    (SELECT distinct id_employee,MAX(updated_at) AS max_updated_at FROM salaries WHERE MONTH(updated_at) <= :monthnum3 GROUP BY id_employee) AS max_salaries
    ON emp.id = max_salaries.id_employee
    left join
    salaries s on emp.id = s.id_employee and s.updated_at = max_salaries.max_updated_at
    LEFT JOIN
    (SELECT distinct id_employee,MAX(updated_at) AS max_updated_at FROM upah_bpjs  WHERE MONTH(updated_at) <= :monthnum7 GROUP BY id_employee) AS max_upah
    ON emp.id = max_upah.id_employee
    left join
    upah_bpjs ub  on emp.id = ub.id_employee and ub.updated_at = max_upah.max_updated_at
    LEFT JOIN
    company AS c
    ON emp.id_company = c.id_company
    LEFT JOIN
    (SELECT distinct id_employee,MAX(updated_at) AS max_updated_at FROM tunjangans WHERE MONTH(updated_at) <= :monthnum4 GROUP BY id_employee) AS max_tunjangans
    ON emp.id = max_tunjangans.id_employee
    left join
    tunjangans t on emp.id = t.id_employee  and t.updated_at = max_tunjangans.max_updated_at
        WHERE emp.id_company = :id_company AND  max_tunjangans.max_updated_at IS NOT NULL
        and emp.id in (SELECT id
            FROM employee
            WHERE
                (is_active = 1 AND (MONTH(updated_at) IS NULL OR MONTH(updated_at) <= :monthnum5))
                OR
                (is_active = 0 AND (MONTH(updated_at) IS NULL OR MONTH(updated_at) > :monthnum6))
            )
        GROUP BY emp.id,emp.nik,emp.npwp, c.id_company,  t.bpjs_kesehatan)";

    DB::insert($sql, [
        'id_company' => $request->id_company,
        'monthnum1' => $request->month,
        'monthnum2' => $request->month,
        'monthnum3' => $request->month,
        'monthnum4' => $request->month,
        'monthnum5' => $request->month,
        'monthnum6' => $request->month,
        'monthnum7' => $request->month,
    ]);


        return redirect()->route('showBpjs', ['id_company' => $request->id_company, 'monthnum'=> $request->month ])->with('succes','data berhasil ditambahkan');

}

    /**
     * Display the specified resource.
     */
    public function insertShow($id_company, $monthnum)
    {
        //
        $sql = "SELECT
        emp.id,
        emp.nama,
        bpjs.nik,
        c.name_company,
        gaji_pokok,
        jht_karyawan,
      	jht_pt,
        jkm,
        jkk,
        jp_karyawan,
        jp_pt,
        bpjs_kesehatan,
        ditanggung_karyawan,
        ditanggung_pt,
        MONTHNAME(bpjs.updated_at) AS bulan,
        YEAR(bpjs.updated_at) AS year
        FROM bpjs
        LEFT JOIN company AS c ON bpjs.id_company = c.id_company
        left Join employee as emp on bpjs.id_employee = emp.id
        WHERE emp.id_company = :id_company and MONTH(bpjs.updated_at) = :monthnum";

        $dataBPJS = DB::select($sql, ['id_company' => $id_company,'monthnum'=> $monthnum]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('bpjs.bpjs', compact('dataBPJS','dataPerusahaan'));
    }

    public function reportShow($id_company, $year)
    {
        //
        $sql ="SELECT
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JANUARY' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS JANUARY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'FEBRUARY' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS FEBRUARY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'MARCH' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS MARCH,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'APRIL' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS APRIL,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'MAY' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS MAY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JUNE' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS JUNE,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JULY' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS JULY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'AUGUST' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS AUGUST,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'SEPTEMBER' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS SEPTEMBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'OCTOBER' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS OCTOBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'NOVEMBER' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS NOVEMBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'DECEMBER' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS DECEMBER,
    sum(bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm) total
        from bpjs
        LEFT JOIN company AS c
                ON bpjs.id_company = c.id_company
        left Join employee as emp
                on bpjs.id_employee = emp.id
        where year(bpjs.updated_at)= :year_num
        and emp.id_company = :id_company
        group by emp.nama,c.name_company,emp.nik,
        emp.npwp
                ";

        $dataBPJS = DB::select($sql, ['id_company' => $id_company,'year_num'=>$year]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('bpjs.reportBpjs', compact('dataBPJS','dataPerusahaan'));
    }

    public function reportKaryawanIndex()
    {
        //


        $sql ="SELECT
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
        MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JANUARY' THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END) AS JANUARY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'FEBRUARY' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS FEBRUARY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'MARCH' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS MARCH,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'APRIL' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS APRIL,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'MAY' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS MAY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JUNE' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS JUNE,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JULY' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS JULY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'AUGUST' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS AUGUST,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'SEPTEMBER' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS SEPTEMBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'OCTOBER' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS OCTOBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'NOVEMBER' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS NOVEMBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'DECEMBER' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS DECEMBER,
    sum(bpjs.jht_karyawan+bpjs.jp_karyawan ) total
        from bpjs
        LEFT JOIN company AS c
                ON bpjs.id_company = c.id_company
        left Join employee as emp
                on bpjs.id_employee = emp.id
        where year(bpjs.updated_at)=2024
        group by emp.nama,c.name_company,emp.nik,
        emp.npwp
                ";
        // GROUP BY bpjs.id, emp.nama,bpjs.nik, c.name_company,gaji_pokok,MONTHNAME(bpjs.updated_at),YEAR(bpjs.updated_at)

        $dataBPJS = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('bpjs.reportBpjsKaryawan',compact('dataBPJS','dataPerusahaan'));
    }
    public function reportKaryawanShow($id_company, $year)
    {
        //
        $sql ="SELECT
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JANUARY' THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END) AS JANUARY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'FEBRUARY' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS FEBRUARY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'MARCH' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS MARCH,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'APRIL' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS APRIL,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'MAY' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS MAY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JUNE' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS JUNE,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JULY' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS JULY,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'AUGUST' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS AUGUST,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'SEPTEMBER' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS SEPTEMBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'OCTOBER' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS OCTOBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'NOVEMBER' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS NOVEMBER,
    MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'DECEMBER' THEN bpjs.jht_karyawan+bpjs.jp_karyawan  ELSE 0 END) AS DECEMBER,
    sum(bpjs.jht_karyawan+bpjs.jp_karyawan ) total
        from bpjs
        LEFT JOIN company AS c
                ON bpjs.id_company = c.id_company
        left Join employee as emp
                on bpjs.id_employee = emp.id
        where year(bpjs.updated_at)= :year_num
        and emp.id_company = :id_company
        group by emp.nama,c.name_company,emp.nik,
        emp.npwp
                ";

        $dataBPJS = DB::select($sql, ['id_company' => $id_company,'year_num'=>$year]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('bpjs.reportBpjsKaryawan', compact('dataBPJS','dataPerusahaan'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BPJS $bPJS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BPJS $bPJS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BPJS $bPJS)
    {
        //
    }


    public function exportA5($id_company, $year) 
    {
        $data = BPJS::query()->select(
            'emp.nama',
            'emp.nik',
            'emp.npwp',
            'c.name_company',
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 1 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS JANUARY'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 2 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS FEBRUARY'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 3 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS MARCH'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 4 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS APRIL'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 5 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS MAY'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 6 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS JUNE'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 7 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS JULY'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 8 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS AUGUST'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 9 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS SEPTEMBER'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 10 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS OCTOBER'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 11 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS NOVEMBER'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 12 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0) AS DECEMBER'),
            \DB::raw('
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 1 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 2 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 3 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 4 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 5 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 6 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 7 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 8 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 9 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 10 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 11 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 12 THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END),0)
            AS total')
        )
        ->from('bpjs AS bpjs')
        ->leftJoin('company AS c', 'bpjs.id_company', '=', 'c.id_company')
        ->leftJoin('employee AS emp', 'bpjs.id_employee', '=', 'emp.id')
        ->whereYear('bpjs.updated_at', '=', $year)
        ->where('emp.id_company', '=', $id_company)
        ->groupBy('emp.nama', 'c.name_company', 'emp.nik', 'emp.npwp')
        ->get();

        return Excel::download(new BpjsExport($data), 'bpjsA5.xlsx');
    }

    public function exportA10($id_company, $year) 
    {
        $data = BPJS::query()->select(
            'emp.nama',
            'emp.nik',
            'emp.npwp',
            'c.name_company',
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 1 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS JANUARY'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 2 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS FEBRUARY'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 3 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS MARCH'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 4 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS APRIL'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 5 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS MAY'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 6 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS JUNE'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 7 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS JULY'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 8 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS AUGUST'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 9 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS SEPTEMBER'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 10 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS OCTOBER'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 11 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS NOVEMBER'),
            \DB::raw('COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 12 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0) AS DECEMBER'),
            \DB::raw('
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 1 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 2 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 3 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 4 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 5 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 6 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 7 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 8 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 9 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 10 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 11 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)+
            COALESCE(SUM(CASE WHEN MONTH(bpjs.updated_at) = 12 THEN bpjs.jht_karyawan+bpjs.jp_karyawan ELSE 0 END),0)
            AS total')
        )
        ->from('bpjs AS bpjs')
        ->leftJoin('company AS c', 'bpjs.id_company', '=', 'c.id_company')
        ->leftJoin('employee AS emp', 'bpjs.id_employee', '=', 'emp.id')
        ->whereYear('bpjs.updated_at', '=', $year)
        ->where('emp.id_company', '=', $id_company)
        ->groupBy('emp.nama', 'c.name_company', 'emp.nik', 'emp.npwp')
        ->get();

        return Excel::download(new BpjsExport($data), 'bpjsA10.xlsx');
    }
}
