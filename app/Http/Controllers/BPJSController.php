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

        // $exists = DB::table('bpjs')
        // ->where('id_company', $request->id_company)
        // ->whereRaw('MONTH(updated_at) = ?', [$request->month])
        // ->exists();


        // if (!$exists) {
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
    s.gaji_pokok,
    s.gaji_pokok * 0.02 AS jht_karyawan,
    s.gaji_pokok * 0.037 AS jht_pt,
    s.gaji_pokok * 0.0030 AS jkm,
    s.gaji_pokok * 0.0054 AS jkk,
    s.gaji_pokok * 0.01 AS jp_karyawan,
    s.gaji_pokok * 0.02 AS jp_pt,
    IF(t.bpjs_kesehatan IS NULL, 0, t.bpjs_kesehatan) AS bpjs_kesehatan,
    (s.gaji_pokok * 0.02) + (s.gaji_pokok * 0.01) AS ditanggung_karyawan,
    (s.gaji_pokok * 0.037) + (s.gaji_pokok * 0.0030) + (s.gaji_pokok * 0.0054) + (s.gaji_pokok * 0.02) + IF(t.bpjs_kesehatan IS NULL, 0, t.bpjs_kesehatan) AS ditanggung_pt,
    DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum1), '-01'), '%Y-%m-%d') AS created_at,
    DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum2), '-01'), '%Y-%m-%d') AS updated_at
    FROM
    employee AS emp
    LEFT JOIN
    (SELECT id_employee, nik, npwp, MAX(updated_at) AS max_updated_at FROM salaries WHERE MONTH(updated_at) <= :monthnum3 GROUP BY id_employee, nik, npwp) AS max_salaries
    ON emp.id = max_salaries.id_employee
    LEFT JOIN
    salaries AS s
    ON emp.id = s.id_employee AND s.updated_at = max_salaries.max_updated_at
    LEFT JOIN
    company AS c
    ON emp.id_company = c.id_company
    LEFT JOIN
    (SELECT id_employee, nik, npwp, MAX(updated_at) AS max_updated_at FROM tunjangans WHERE MONTH(updated_at) <= :monthnum4 GROUP BY id_employee, nik, npwp) AS max_tunjangans
    ON emp.id = max_tunjangans.id_employee
    LEFT JOIN
    tunjangans AS t
    ON emp.id = t.id_employee AND t.updated_at = max_tunjangans.max_updated_at
        WHERE emp.id_company = :id_company AND max_salaries.max_updated_at IS NOT NULL AND max_tunjangans.max_updated_at IS NOT NULL and emp.is_active = 1
        GROUP BY emp.id,emp.nik,emp.npwp, c.id_company, s.gaji_pokok, t.bpjs_kesehatan)";

    DB::insert($sql, [
        'id_company' => $request->id_company,
        'monthnum1' => $request->month,
        'monthnum2' => $request->month,
        'monthnum3' => $request->month,
        'monthnum4' => $request->month
    ]);


        return redirect()->route('showBpjs', ['id_company' => $request->id_company, 'monthnum'=> $request->month ])->with('succes','data berhasil ditambahkan');
// }else {
//     // Handle exceptions, for example:
//         return back()->with([
//             'error' => 'Error, Data bpjs Sudah terdapat didatabase.'
//         ]);

//     }
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
        MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'DECEMBER' THEN bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm ELSE 0 END) AS DECEMBER
        ,(bpjs.bpjs_kesehatan+bpjs.jkk+bpjs.jkm) total    
        from bpjs
            LEFT JOIN company AS c
                    ON bpjs.id_company = c.id_company
            left Join employee as emp
                    on bpjs.id_employee = emp.id
            where year(bpjs.updated_at)= :year
            and emp.id_company = :id_company
            group by emp.nama,c.name_company,emp.nik,
            emp.npwp,bpjs.bpjs_kesehatan,bpjs.jkk,bpjs.jkm
                ";

        $dataBPJS = DB::select($sql, ['id_company' => $id_company,'year'=>$year]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('bpjs.reportBpjs', compact('dataBPJS','dataPerusahaan'));
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

    public function export_excel(Request $request)
	{


            $sql ="
            SELECT
                emp.nama,
                c.name_company,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JANUARY' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS JANUARY,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'FEBRUARY' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS FEBRUARY,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'MARCH' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS MARCH,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'APRIL' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS APRIL,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'MAY' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS MAY,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JUNE' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS JUNE,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'JULY' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS JULY,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'AUGUST' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS AUGUST,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'SEPTEMBER' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS SEPTEMBER,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'OCTOBER' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS OCTOBER,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'NOVEMBER' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS NOVEMBER,
            MAX(CASE WHEN MONTHNAME(bpjs.updated_at) = 'DECEMBER' THEN bpjs.bpjs_kesehatan ELSE 0 END) AS DECEMBER
                from bpjs
                LEFT JOIN company AS c
                        ON bpjs.id_company = c.id_company
                left Join employee as emp
                        on bpjs.nik = emp.nik
                where year(bpjs.updated_at)=2024
                group by emp.nama,c.name_company
                    ";


            $data = DB::select($sql);
            $arrayData[] = array('nama','name_company'
            ,'JANUARY','FEBRUARY','MARCH','APRIL'
            ,'MAY','JUNE','JULY','AUGUST'
            ,'SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER');

            foreach($data as $report){
                $arrayData[]=array(
                    'Nama' => $report->nama,
                    'Perusahaan' => $report->name_company,
                    'JANUARY' => $report->JANUARY,
                    'FEBRUARY' => $report->FEBRUARY,
                    'MARCH' => $report->MARCH,
                    'APRIL' => $report->APRIL,
                    'MAY' => $report->MAY,
                    'JUNE' => $report->JUNE,
                    'JULY' => $report->JULY,
                    'AUGUST' => $report->AUGUST,
                    'SEPTEMBER' => $report->SEPTEMBER,
                    'OCTOBER' => $report->OCTOBER,
                    'NOVEMBER' => $report->NOVEMBER,
                    'DECEMBER' => $report->DECEMBER
                );
            }


		return Excel::download(new BpjsExport($data), 'bpjs.xlsx');
	}
}
