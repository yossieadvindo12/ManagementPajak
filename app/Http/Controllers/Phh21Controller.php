<?php

namespace App\Http\Controllers;

use App\Models\phh21;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Phh21Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sql = "SELECT 
        id,
        emp.nama,
        emp.nik,
        c.name_company,
        gaji_pokok,
        A5,
      	sc,
        natura,
        gaji_bruto,
        `Ter alias`  as ter_alias,
        pph21,
        thp,
        gross_up,
        MONTHNAME(phh21s.updated_at) AS bulan,
        YEAR(phh21s.updated_at) AS year
        FROM phh21s 
        LEFT JOIN company AS c ON phh21s.id_company = c.id_company
        left Join employee as emp on phh21s.nik = emp.nik
        ";
        // GROUP BY bpjs.id, emp.nama,bpjs.nik, c.name_company,gaji_pokok,MONTHNAME(bpjs.updated_at),YEAR(bpjs.updated_at)

        $dataPPH21 = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('pph21.pph21',compact('dataPPH21','dataPerusahaan'));
    }

    public function reportIndex()
    {
        //


        $sql = "SELECT 
        id,
        emp.nama,
        emp.nik,
        c.name_company,
        gaji_pokok,
        A5,
      	sc,
        natura,
        gaji_bruto,
        `Ter alias` as ter_alias,
        pph21,
        thp,
        gross_up,
        MONTHNAME(phh21s.updated_at) AS bulan,
        YEAR(phh21s.updated_at) AS year
        FROM phh21s 
        LEFT JOIN company AS c ON phh21s.id_company = c.id_company
        left Join employee as emp on phh21s.nik = emp.nik
        ";
        // GROUP BY bpjs.id, emp.nama,bpjs.nik, c.name_company,gaji_pokok,MONTHNAME(bpjs.updated_at),YEAR(bpjs.updated_at)

        $dataPPH21 = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('pph21.reportPph21',compact('dataPPH21','dataPerusahaan'));
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

    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'id_company'  => 'required|integer',
            'month' => 'required|integer',
            'keterangan_pph' => 'required|string'
        ]);

        // $exists = DB::table('bpjs')
        // ->where('id_company', $request->id_company)
        // ->whereRaw('MONTH(updated_at) = ?', [$request->month])
        // ->exists();
        

        // if (!$exists) {
        $sql = "INSERT INTO phh21s (nik, 
        id_company, 
        gaji_pokok, 
        A5, 
        sc, 
        natura, 
        gaji_bruto, 
        `Ter alias`, 
        pph21, 
        thp, 
        gross_up, 
        keterangan_pph, 
        created_at, 
        updated_at
        )
        (SELECT 
    emp.nik, 
    c.id_company, 
    s.gaji_pokok, 
    b.jkm + b.jkk + b.bpjs_kesehatan AS a5,  
    max_tunjangans.sc,
    max_tunjangans.natura,
    s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( max_tunjangans.sc,0) +ifnull( max_tunjangans.natura,0) as gaji_bruto,
	ter.`Ter alias` ,
	(s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( max_tunjangans.sc,0) +ifnull( max_tunjangans.natura,0)) * ter.presentase as pph21,
	(s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( max_tunjangans.sc,0) +ifnull( max_tunjangans.natura,0)) - ((s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( max_tunjangans.sc,0) +ifnull( max_tunjangans.natura,0)) * ter.presentase) as thp,
	(s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( max_tunjangans.sc,0) +ifnull( max_tunjangans.natura,0)) - ((s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( max_tunjangans.sc,0) +ifnull( max_tunjangans.natura,0)) - ((s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( max_tunjangans.sc,0) +ifnull( max_tunjangans.natura,0)) * ter.presentase)) 
	 as gross_up,
     :keterangan_pph as keterangan_pph,
    DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum1), '-01'), '%Y-%m-%d') AS created_at, 
    DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum2), '-01'), '%Y-%m-%d') AS updated_at 
    FROM 
    employee AS emp 
    LEFT JOIN 
    (SELECT nik, MAX(updated_at) AS max_updated_at FROM salaries WHERE MONTH(updated_at) <= :monthnum3 GROUP BY nik) AS max_salaries
    ON emp.nik = max_salaries.nik
    LEFT JOIN 
    salaries AS s 
    ON emp.nik = s.nik AND s.updated_at = max_salaries.max_updated_at
    LEFT JOIN 
    company AS c 
    ON emp.id_company = c.id_company 
    left join 
    (select nik, gaji_pokok, jkm, jkk,bpjs_kesehatan, max(updated_at) as max_updated_at  from bpjs where MONTH(updated_at)<= :monthnum5 group  by nik, gaji_pokok, jkm, jkk,bpjs_kesehatan) as b 
    on emp.nik = b.nik 
    LEFT JOIN 
    (SELECT nik,sc, natura, MAX(updated_at) AS max_updated_at FROM tunjangans WHERE MONTH(updated_at) <= :monthnum4 GROUP BY nik,sc, natura) AS max_tunjangans
    ON emp.nik = max_tunjangans.nik
    LEFT JOIN 
    tunjangans AS t 
    ON emp.nik = t.nik AND t.updated_at = max_tunjangans.max_updated_at
LEFT JOIN ter ON 
    CASE emp.status_PTKP
    WHEN 'K/3' THEN 'TER C'
        WHEN 'TK/0' THEN 'TER A'
        WHEN 'TK/1' THEN 'TER A'
        WHEN 'K/0' THEN 'TER A'
        WHEN 'TK/2' THEN 'TER B'
        WHEN 'TK/3' THEN 'TER B'
        WHEN 'K/1' THEN 'TER B'
        WHEN 'K/2' THEN 'TER B'
        WHEN 'K/3' THEN 'TER C'
        ELSE NULL
    END = ter.Ter
        WHERE emp.id_company = :id_company AND max_salaries.max_updated_at IS NOT NULL AND max_tunjangans.max_updated_at IS NOT null 
        and s.gaji_pokok BETWEEN min AND ifnull(max,9999999999)
        GROUP BY emp.nik, c.id_company, s.gaji_pokok, t.bpjs_kesehatan,b.jkm, b.jkk , b.bpjs_kesehatan , max_tunjangans.sc,
    max_tunjangans.natura,managementpajak.ter.`Ter alias`,managementpajak.ter.presentase)";
    
    DB::insert($sql, [
        'id_company' => $request->id_company, 
        'monthnum1' => $request->month, 
        'monthnum2' => $request->month,
        'monthnum3' => $request->month,
        'monthnum4' => $request->month,
        'monthnum5' => $request->month,
        'keterangan_pph' => $request->keterangan_pph
    ]);
    

        return redirect()->route('showPph', ['id_company' => $request->id_company, 'monthnum'=> $request->month, 'keterangan_pph' => $request->keterangan_pph ])->with('succes','data berhasil ditambahkan');
    }

    public function insertShow($id_company, $monthnum, $keterangan_pph)
    {
        //
        $sql = "SELECT 
        id,
        emp.nama,
        emp.nik,
        c.name_company,
        gaji_pokok,
        A5,
      	sc,
        natura,
        gaji_bruto,
        `Ter alias`  as ter_alias,
        pph21,
        thp,
        gross_up,
        MONTHNAME(phh21s.updated_at) AS bulan,
        YEAR(phh21s.updated_at) AS year
        FROM phh21s 
        LEFT JOIN company AS c ON phh21s.id_company = c.id_company
        left Join employee as emp on phh21s.nik = emp.nik
        WHERE emp.id_company = :id_company and MONTH(phh21s.updated_at) = :monthnum and keterangan_pph= :keterangan_pph";

        $dataPPH21 = DB::select($sql, ['id_company' => $id_company,'monthnum'=> $monthnum, 'keterangan_pph' => $keterangan_pph]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('pph21.pph21', compact('dataPPH21','dataPerusahaan'));
    }

    public function reportShow($id_company)
    {
        //
        $sql = "SELECT 
        id,
        emp.nama,
        emp.nik,
        c.name_company,
        gaji_pokok,
        A5,
      	sc,
        natura,
        gaji_bruto,
        `Ter alias`  as ter_alias,
        pph21,
        thp,
        gross_up,
        MONTHNAME(phh21s.updated_at) AS bulan,
        YEAR(phh21s.updated_at) AS year
        FROM phh21s 
        LEFT JOIN company AS c ON phh21s.id_company = c.id_company
        left Join employee as emp on phh21s.nik = emp.nik
        WHERE emp.id_company = :id_company";

        $dataPPH21 = DB::select($sql, ['id_company' => $id_company]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('pph21.reportPph21', compact('dataPPH21','dataPerusahaan'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(phh21 $phh21)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, phh21 $phh21)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(phh21 $phh21)
    {
        //
    }
}
