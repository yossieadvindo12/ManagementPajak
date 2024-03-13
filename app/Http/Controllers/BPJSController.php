<?php

namespace App\Http\Controllers;

use App\Models\BPJS;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BPJSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dataBPJS = BPJS::all();
        $dataPerusahaan = Company::all();
        return view('bpjs.bpjs',compact('dataBPJS','dataPerusahaan'));
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
        $sql = "INSERT INTO bpjs (nik,
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
        emp.nik,
        c.id_company,
        MAX(s.gaji_pokok),
        MAX(s.gaji_pokok) * 0.02 AS jht_karyawan,
        MAX(s.gaji_pokok) * 0.37 AS jht_pt,
        MAX(s.gaji_pokok) * 0.30 AS jkm,
        MAX(s.gaji_pokok) * 0.54 AS jkk,
        MAX(s.gaji_pokok) * 0.01 AS jp_karyawan,
        MAX(s.gaji_pokok) * 0.02 AS jp_pt,
        NUll bpjs_kesehatan,
        NUll ditanggung_karyawan,
        NUll ditanggung_pt,
        NOW() created_at,
        NOW() updated_at
        FROM employee AS emp
        LEFT JOIN salaries AS s ON emp.nik = s.nik AND s.updated_at <= NOW()
        LEFT JOIN company AS c ON emp.id_company = c.id_company
        WHERE emp.id_company = :id_company
        GROUP BY emp.nik, c.id_company)";

        DB::insert($sql, ['id_company' => $request->id_company]);

        return redirect()->route('showBpjs', ['id_company' => $request->id_company])->with('succes','data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function insertShow($id_company)
    {
        //
        $sql = "SELECT 
        id,
        emp.nama,
        bpjs.nik,
        c.name_company,
        gaji_pokok,
        gaji_pokok * 0.02 AS jht_karyawan,
      	gaji_pokok * 0.37 AS jht_pt,
        gaji_pokok * 0.30 AS jkm,
        gaji_pokok * 0.54 AS jkk,
        gaji_pokok * 0.01 AS jp_karyawan,
        gaji_pokok * 0.02 AS jp_pt,
        MONTHNAME(bpjs.updated_at) AS bulan,
        YEAR(bpjs.updated_at) AS year
        FROM bpjs 
        LEFT JOIN company AS c ON bpjs.id_company = c.id_company
        left Join employee as emp on bpjs.nik = emp.nik
        WHERE bpjs.id_company = :id_company
        GROUP BY bpjs.id, emp.nama,bpjs.nik, c.name_company,gaji_pokok,MONTHNAME(bpjs.updated_at),YEAR(bpjs.updated_at)";

        $dataBPJS = DB::select($sql, ['id_company' => $id_company]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('bpjs.bpjs', compact('dataBPJS','dataPerusahaan'));
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
}
