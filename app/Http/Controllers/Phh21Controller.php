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
        emp.id,
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
        gaji_pokok,
        A5,
      	sc,
        natura,
        thr,
        lain_lain,
        gaji_bruto,
        `Ter alias`  as ter_alias,
        pph21,
        thp,
        gross_up,
        keterangan_pph,
        MONTHNAME(phh21s.updated_at) AS bulan,
        YEAR(phh21s.updated_at) AS year
        FROM phh21s 
        LEFT JOIN company AS c ON phh21s.id_company = c.id_company
        left Join employee as emp on phh21s.id_employee = emp.id
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
        emp.id,
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
        gaji_pokok,
        A5,
      	sc,
        natura,
        thr,
        lain_lain,
        gaji_bruto,
        `Ter alias`  as ter_alias,
        pph21,
        thp,
        gross_up,
        keterangan_pph,
        MONTHNAME(phh21s.updated_at) AS bulan,
        YEAR(phh21s.updated_at) AS year
        FROM phh21s 
        LEFT JOIN company AS c ON phh21s.id_company = c.id_company
        left Join employee as emp on phh21s.id_employee = emp.id
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

        
        DB::delete("DELETE FROM phh21s WHERE id_company= :id_company and MONTH(updated_at) = :month     and YEAR(updated_at)=YEAR(NOW()) and keterangan_pph= :keterangan_pph", 
        ['id_company' => $request->id_company, 'month' => $request->month,'keterangan_pph' => $request->keterangan_pph]);
        
    if($request->keterangan_pph != 'reportTHR' and $request->month != '12'){
                        $sql = "INSERT INTO phh21s (id_employee,
                        nik,npwp, 
                        id_company, 
                        gaji_pokok, 
                        A5, 
                        sc, 
                        natura, 
                        thr,
                        lain_lain,
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
                        emp.id,
                    emp.nik, 
                    emp.npwp,
                    c.id_company, 
                    s.gaji_pokok, 
                    b.jkm + b.jkk + b.bpjs_kesehatan AS a5,  
                    t.sc,
                    t.natura,
                    0 thr,
                    t.lain_lain,
                    s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( t.sc,0) +ifnull( t.natura,0) +ifnull( t.lain_lain,0) as gaji_bruto,
                    ter.`Ter alias` ,
                    FLOOR((s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( t.sc,0) +ifnull( t.natura,0) +ifnull( t.lain_lain,0)) * ter.presentase )as pph21,
                    FLOOR((s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( t.sc,0) +ifnull( t.natura,0) +ifnull( t.lain_lain,0)) - ((s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( t.sc,0) +ifnull( t.natura,0) +ifnull( t.lain_lain,0)) * ter.presentase)) as thp,
                    FLOOR((s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( t.sc,0) +ifnull( t.natura,0) +ifnull( t.lain_lain,0)) - ((s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( t.sc,0) +ifnull( t.natura,0) +ifnull( t.lain_lain,0)) - ((s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( t.sc,0) +ifnull( t.natura,0) +ifnull( t.lain_lain,0)) * ter.presentase))) 
                    as gross_up,
                    :keterangan_pph as keterangan_pph,
                    DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum1), '-01'), '%Y-%m-%d') AS created_at, 
                    DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum2), '-01'), '%Y-%m-%d') AS updated_at 
                    FROM 
                    employee AS emp 
                    LEFT JOIN 
                    (SELECT distinct id_employee, MAX(updated_at) AS max_updated_at FROM salaries WHERE MONTH(updated_at) <= :monthnum3 GROUP BY id_employee) AS max_salaries
                    ON emp.id = max_salaries.id_employee
                    left join 
                    salaries s on emp.id = s.id_employee and s.updated_at = max_salaries.max_updated_at
                    LEFT JOIN 
                    company AS c 
                    ON emp.id_company = c.id_company 
                    left join 
                    (select id_employee, nik, npwp, gaji_pokok, jkm, jkk,bpjs_kesehatan, max(updated_at) as max_updated_at  from bpjs where MONTH(updated_at)= :monthnum5 group  by id_employee, nik, npwp, gaji_pokok, jkm, jkk,bpjs_kesehatan) as b 
                    on emp.id = b.id_employee 
                    LEFT JOIN 
                    (SELECT distinct id_employee, MAX(updated_at) AS max_updated_at FROM tunjangans WHERE MONTH(updated_at) <= :monthnum4 GROUP BY id_employee) AS max_tunjangans
                    ON emp.id = max_tunjangans.id_employee
                    left join 
                    tunjangans t on emp.id = t.id_employee  and t.updated_at = max_tunjangans.max_updated_at
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
                        and emp.id in (SELECT id 
                            FROM employee 
                            WHERE 
                                (is_active = 1 AND (MONTH(updated_at) IS NULL OR MONTH(updated_at) <= :monthnum6))
                                OR 
                                (is_active = 0 AND (MONTH(updated_at) IS NULL OR MONTH(updated_at) > :monthnum7))
                            ) 
                        and (s.gaji_pokok + b.jkm + b.jkk + b.bpjs_kesehatan + ifnull( t.sc,0) +ifnull( t.natura,0)) BETWEEN min AND ifnull(max,9999999999)
                        GROUP BY emp.id,emp.npwp,emp.nik, c.id_company, s.gaji_pokok, b.jkm, b.jkk , b.bpjs_kesehatan , t.sc,
                        t.natura,managementpajak.ter.`Ter alias`,managementpajak.ter.presentase)";
                    
                    DB::insert($sql, [
                        'id_company' => $request->id_company, 
                        'monthnum1' => $request->month, 
                        'monthnum2' => $request->month,
                        'monthnum3' => $request->month,
                        'monthnum4' => $request->month,
                        'monthnum5' => $request->month,
                        'monthnum6' => $request->month,
                        'monthnum7' => $request->month,
                        'keterangan_pph' => $request->keterangan_pph
                    ]);
            
    }else if($request->keterangan_pph != 'reportTHR' and $request->month = '12'){
                        $sql = "INSERT INTO phh21s (id_employee,
                        nik,npwp, 
                        id_company, 
                        gaji_pokok, 
                        A5, 
                        sc, 
                        natura, 
                        thr,
                        lain_lain,
                        gaji_bruto, 
                        `Ter alias`, 
                        pph21, 
                        thp, 
                        gross_up, 
                        keterangan_pph, 
                        created_at, 
                        updated_at
                        )
                        (select
                        rekap.id,
                        rekap.nik,
                        rekap.npwp,
                        rekap.id_company,
                        rekap.A1 gaji_pokok,
                        0 A5,
                        0 sc,
                        0 natura,
                        0 thr,
                        0 lain_lain,
                        0 gaji_bruto,
                        '-' `Ter alias`,
                    round((if(rekap.npwp is null,
                                if(rekap.is_active=0,
                                    rekap.A17,
                                    if(rekap.lamakerja<=12,rekap.A17,(rekap.A17*rekap.lamakerja/12)*(1+0.2)))
                                ,if(rekap.is_active=0,
                                    rekap.A17,
                                    if(rekap.lamakerja<=12,rekap.A17,(rekap.A17*rekap.lamakerja/12)))
                        ))) - rekap.pph21 as pph21,
                        0 thp,
                        0 gross_up,
                        :keterangan_pph as keterangan_pph,
                    DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum1), '-01'), '%Y-%m-%d') AS created_at, 
                    DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum2), '-01'), '%Y-%m-%d') AS updated_at 
                    from (select
                    sub1.id,
                    sub1.nik,
                    sub1.npwp,
                    sub1.nama,
                    sub1.is_active,
                    sub1.id_company,
                #     sub1.pph21,
                    sum(sub1.pph21) pph21,
                    b.awalKerja,
                    b.akhirKerja,
                    b.lamakerja,
                sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0) as A1,
                    b.a5,
                --     sum(sub1.thr) A7,
                    ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) as A8,
                    ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) as A9,
                    b.A10,
                    ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 as A11,
                    ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - (ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10) as A12,
                    ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 as A14,
                    CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end as A15,
                FLOOR(if(CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end >((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 , 0, floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 - CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end) )/1000)*1000  as A16,
                CASE
                        WHEN FLOOR(if(CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end >((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 , 0, floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 - CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end) )/1000)*1000 <= 60000000 THEN FLOOR(if(CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end >((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 , 0, floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 - CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end) )/1000)*1000 * 0.05
                        WHEN FLOOR(if(CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end >((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 , 0, floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 - CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end) )/1000)*1000 <= 250000000 THEN (FLOOR(if(CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end >((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 , 0, floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 - CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end) )/1000)*1000 - 60000000) * 0.15 + 3000000
                        WHEN FLOOR(if(CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end >((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 , 0, floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 - CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end) )/1000)*1000 <= 500000000 THEN (FLOOR(if(CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end >((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 , 0, floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 - CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end) )/1000)*1000 - 250000000) * 0.25 + 31500000
                        ELSE (FLOOR(if(CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end >((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 , 0, floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) - ROUND(if(
                    (b.lamakerja*500000) >= ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 )* 0.05,
                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok,0)) + b.a5 ) * 0.05,
                        b.lamakerja*500000
                    )) + b.a10 - CASE
                    WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                    WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                    WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                    WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                    WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                    WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                    WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                    WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                    ELSE 0
                end) )/1000)*1000 - 500000000) * 0.3 + 94000000
                    END AS A17
                from (
                SELECT
                    emp.id,
                    emp.nik,
                    emp.npwp,
                    emp.nama,
                    emp.status_ptkp,
                    emp.is_active,
                    c.id_company,
                    ps.gaji_pokok,
                    IFNULL(ps.sc,0) as sc,
                    ifNULL(ps.thr,0) as thr,
                    ps.gaji_pokok + IFNULL(ps.sc,0) AS total_gaji,
                    ps.pph21,
                    ps.updated_at,
                    ps.created_at
                FROM
                    employee AS emp
                    LEFT JOIN company AS c ON emp.id_company = c.id_company
                    LEFT JOIN phh21s AS ps ON emp.id = ps.id_employee
                WHERE
                    emp.id_company = :id_company
                    and keterangan_pph = 'reportMonthly'
                    and month(ps.updated_at) BETWEEN 1 AND 11
                GROUP BY
                    emp.id,
                    emp.nik,
                    emp.npwp,
                    emp.nama,
                    emp.status_ptkp,
                    emp.is_active,
                    c.id_company,
                    ps.gaji_pokok,
                    ps.pph21,
                    ps.sc,
                    ps.thr,
                    ps.created_at,
                    ps.updated_at
                    )
                    as sub1
                    left join (
                        select id_employee, gaji_pokok from salaries where month(updated_at) = 12 and year(updated_at) = year(now())
                    ) s on sub1.id = s.id_employee
                    left join (
                        select
                            id_employee,
                            sum(b.jkm + b.jkk + b.bpjs_kesehatan) AS a5,
                            sum(b.jht_karyawan + b.jp_karyawan) as a10,
                            IF((b.jkm + b.jkk + b.bpjs_kesehatan) <> 0 , MONTHNAME(MIN(b.created_at)), 0) AS awalKerja,
                            IF((b.jkm + b.jkk + b.bpjs_kesehatan) <> 0 , MONTHNAME(MAX(b.updated_at)), 0) AS akhirKerja,
                            IF((b.jkm + b.jkk + b.bpjs_kesehatan) <> 0 , MAX(MONTH(b.updated_at))-MIN(MONTH(b.updated_at))+1, 0) AS lamakerja
                        from bpjs as b where year(updated_at) = year(now())
                        group by id_employee,b.jkm,b.jkk,b.bpjs_kesehatan
                    ) b ON sub1.id = b.id_employee
                    group by id,b.awalKerja,
                    b.akhirKerja,
                    b.lamakerja,
                s.gaji_pokok,b.a5,b.a10) as rekap)";

                    DB::insert($sql, [
                        'id_company' => $request->id_company, 
                        'monthnum1' => $request->month, 
                        'monthnum2' => $request->month,
                        'keterangan_pph' => $request->keterangan_pph
                    ]);
                            
    }else {

        $sql = "INSERT INTO phh21s (id_employee,
        nik,npwp, 
        id_company, 
        gaji_pokok, 
        A5, 
        sc, 
        natura, 
        thr,
        lain_lain,
        gaji_bruto, 
        `Ter alias`, 
        pph21, 
        thp, 
        gross_up, 
        keterangan_pph, 
        created_at, 
        updated_at
        )
        (select rekap.id,
                rekap.nik,
                rekap.npwp,
                rekap.id_company,
                0 gaji_pokok,
                0 a5,
                0 sc,
                0 natura,
                rekap.a7,
                0 lain_lain,
                0 as gaji_bruto,
                '-'`Ter alias` ,
                round((if(rekap.npwp is null,
                       if(rekap.is_active = 0,
                          rekap.A17,
                          if(rekap.lamakerja <= 12, rekap.A17, (rekap.A17 * rekap.lamakerja / 12) * (1 + 0.2)))
                 , if(rekap.is_active = 0,
                      rekap.A17,
                      if(rekap.lamakerja <= 12, rekap.A17, (rekap.A17 * rekap.lamakerja / 12)))
                    ))) - sum(totalpph.pph21) PPH21,
                0 as thp,
                0 as gross_up,
                :keterangan_pph as keterangan_pph,
                DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum1), '-01'), '%Y-%m-%d') AS created_at,
                DATE_FORMAT(CONCAT(YEAR(NOW()), CONCAT('-', :monthnum2), '-01'), '%Y-%m-%d') AS updated_at
      from (select sub1.id,
                   sub1.nik,
                   sub1.npwp,
                   sub1.nama,
                   sub1.is_active,
                   sub1.id_company,
                   sum(sub1.pph21)                                                                                 pph21,
                   b.awalKerja,
                   b.akhirKerja,
                   b.lamakerja,
                   sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)                                               as A1,
                   b.a5,
                   sum(sub1.thr)                                                                                  A7,
                   ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr))                    as A8,
                   ROUND(if(
                           (b.lamakerja * 500000) >=
                           ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                           ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                           b.lamakerja * 500000
                         ))                                                                                     as A9,
                   b.A10,
                   ROUND(if(
                           (b.lamakerja * 500000) >=
                           ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                           ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                           b.lamakerja * 500000
                         )) + b.a10                                                                             as A11,
                   ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) - ROUND(if(
                           (b.lamakerja * 500000) >=
                           ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                           ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                           b.lamakerja * 500000
                                                                                                     )) + b.a10 as A12,
                   ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) - ROUND(if(
                           (b.lamakerja * 500000) >=
                           ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                           ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                           b.lamakerja * 500000
                                                                                                     )) + b.a10 as A14,
                   CASE
                       WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                       WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                       WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                       WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                       WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                       WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                       WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                       WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                       WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                       WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                       WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                       ELSE 0
                       end                                                                                      as A15,
                   FLOOR(if(CASE
                                WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                                WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                                WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                                WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                                WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                                WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                                WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                                WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                                WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                                WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                                WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                                ELSE 0
                                end >
                            ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) - ROUND(if(
                                    (b.lamakerja * 500000) >=
                                    ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                                    ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                                    b.lamakerja * 500000
                                                                                                              )) +
                            b.a10, 0,
                            floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) - ROUND(if(
                                    (b.lamakerja * 500000) >=
                                    ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                                    ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) * 0.05,
                                    b.lamakerja * 500000
                                                                                                                    )) +
                                  b.a10 - CASE
                                              WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                                              WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                                              WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                                              WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                                              WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                                              WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                                              WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                                              WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                                              WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                                              WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                                              WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                                              ELSE 0
                                      end)) / 1000) * 1000                                                      as A16,
                   CASE
                       WHEN FLOOR(if(CASE
                                         WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                                         WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                                         WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                                         WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                                         WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                                         WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                                         WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                                         WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                                         WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                                         WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                                         WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                                         ELSE 0
                                         end >
                                     ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) -
                                     ROUND(if(
                                             (b.lamakerja * 500000) >=
                                             ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) *
                                             0.05,
                                             ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) *
                                             0.05,
                                             b.lamakerja * 500000
                                           )) + b.a10, 0,
                                     floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) -
                                           ROUND(if(
                                                   (b.lamakerja * 500000) >=
                                                   ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 +
                                                    sum(sub1.thr)) * 0.05,
                                                   ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 +
                                                    sum(sub1.thr)) * 0.05,
                                                   b.lamakerja * 500000
                                                 )) + b.a10 - CASE
                                                                  WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                                                                  WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                                                                  WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                                                                  WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                                                                  WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                                                                  WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                                                                  WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                                                                  WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                                                                  WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                                                                  WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                                                                  WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                                                                  ELSE 0
                                               end)) / 1000) * 1000 <= 60000000 THEN FLOOR(if(CASE
                                                                                                  WHEN sub1.status_ptkp = 'TK/0'
                                                                                                      THEN 54000000
                                                                                                  WHEN sub1.status_ptkp = 'TK/1'
                                                                                                      THEN 58500000
                                                                                                  WHEN sub1.status_ptkp = 'TK/2'
                                                                                                      THEN 63000000
                                                                                                  WHEN sub1.status_ptkp = 'TK/3'
                                                                                                      THEN 67500000
                                                                                                  WHEN sub1.status_ptkp = 'K/0'
                                                                                                      THEN 58500000
                                                                                                  WHEN sub1.status_ptkp = 'K/1'
                                                                                                      THEN 63000000
                                                                                                  WHEN sub1.status_ptkp = 'K/2'
                                                                                                      THEN 67500000
                                                                                                  WHEN sub1.status_ptkp = 'K/3'
                                                                                                      THEN 72000000
                                                                                                  WHEN sub1.status_ptkp = 'HB/1'
                                                                                                      THEN 58500000
                                                                                                  WHEN sub1.status_ptkp = 'HB/2'
                                                                                                      THEN 63000000
                                                                                                  WHEN sub1.status_ptkp = 'HB/3'
                                                                                                      THEN 67500000
                                                                                                  ELSE 0
                                                                                                  end >
                                                                                              ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                               b.a5 + sum(sub1.thr)) -
                                                                                              ROUND(if(
                                                                                                      (b.lamakerja * 500000) >=
                                                                                                      ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                       b.a5 +
                                                                                                       sum(sub1.thr)) *
                                                                                                      0.05,
                                                                                                      ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                       b.a5 +
                                                                                                       sum(sub1.thr)) *
                                                                                                      0.05,
                                                                                                      b.lamakerja *
                                                                                                      500000
                                                                                                    )) + b.a10, 0,
                                                                                              floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                     b.a5 +
                                                                                                     sum(sub1.thr)) -
                                                                                                    ROUND(if(
                                                                                                            (b.lamakerja * 500000) >=
                                                                                                            ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                             b.a5 +
                                                                                                             sum(sub1.thr)) *
                                                                                                            0.05,
                                                                                                            ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                             b.a5 +
                                                                                                             sum(sub1.thr)) *
                                                                                                            0.05,
                                                                                                            b.lamakerja *
                                                                                                            500000
                                                                                                          )) + b.a10 -
                                                                                                    CASE
                                                                                                        WHEN sub1.status_ptkp = 'TK/0'
                                                                                                            THEN 54000000
                                                                                                        WHEN sub1.status_ptkp = 'TK/1'
                                                                                                            THEN 58500000
                                                                                                        WHEN sub1.status_ptkp = 'TK/2'
                                                                                                            THEN 63000000
                                                                                                        WHEN sub1.status_ptkp = 'TK/3'
                                                                                                            THEN 67500000
                                                                                                        WHEN sub1.status_ptkp = 'K/0'
                                                                                                            THEN 58500000
                                                                                                        WHEN sub1.status_ptkp = 'K/1'
                                                                                                            THEN 63000000
                                                                                                        WHEN sub1.status_ptkp = 'K/2'
                                                                                                            THEN 67500000
                                                                                                        WHEN sub1.status_ptkp = 'K/3'
                                                                                                            THEN 72000000
                                                                                                        WHEN sub1.status_ptkp = 'HB/1'
                                                                                                            THEN 58500000
                                                                                                        WHEN sub1.status_ptkp = 'HB/2'
                                                                                                            THEN 63000000
                                                                                                        WHEN sub1.status_ptkp = 'HB/3'
                                                                                                            THEN 67500000
                                                                                                        ELSE 0
                                                                                                        end)) / 1000) *
                                                                                     1000 * 0.05
                       WHEN FLOOR(if(CASE
                                         WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                                         WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                                         WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                                         WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                                         WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                                         WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                                         WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                                         WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                                         WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                                         WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                                         WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                                         ELSE 0
                                         end >
                                     ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) -
                                     ROUND(if(
                                             (b.lamakerja * 500000) >=
                                             ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) *
                                             0.05,
                                             ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) *
                                             0.05,
                                             b.lamakerja * 500000
                                           )) + b.a10, 0,
                                     floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) -
                                           ROUND(if(
                                                   (b.lamakerja * 500000) >=
                                                   ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 +
                                                    sum(sub1.thr)) * 0.05,
                                                   ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 +
                                                    sum(sub1.thr)) * 0.05,
                                                   b.lamakerja * 500000
                                                 )) + b.a10 - CASE
                                                                  WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                                                                  WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                                                                  WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                                                                  WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                                                                  WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                                                                  WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                                                                  WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                                                                  WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                                                                  WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                                                                  WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                                                                  WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                                                                  ELSE 0
                                               end)) / 1000) * 1000 <= 250000000 THEN (FLOOR(if(CASE
                                                                                                    WHEN sub1.status_ptkp = 'TK/0'
                                                                                                        THEN 54000000
                                                                                                    WHEN sub1.status_ptkp = 'TK/1'
                                                                                                        THEN 58500000
                                                                                                    WHEN sub1.status_ptkp = 'TK/2'
                                                                                                        THEN 63000000
                                                                                                    WHEN sub1.status_ptkp = 'TK/3'
                                                                                                        THEN 67500000
                                                                                                    WHEN sub1.status_ptkp = 'K/0'
                                                                                                        THEN 58500000
                                                                                                    WHEN sub1.status_ptkp = 'K/1'
                                                                                                        THEN 63000000
                                                                                                    WHEN sub1.status_ptkp = 'K/2'
                                                                                                        THEN 67500000
                                                                                                    WHEN sub1.status_ptkp = 'K/3'
                                                                                                        THEN 72000000
                                                                                                    WHEN sub1.status_ptkp = 'HB/1'
                                                                                                        THEN 58500000
                                                                                                    WHEN sub1.status_ptkp = 'HB/2'
                                                                                                        THEN 63000000
                                                                                                    WHEN sub1.status_ptkp = 'HB/3'
                                                                                                        THEN 67500000
                                                                                                    ELSE 0
                                                                                                    end >
                                                                                                ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                 b.a5 + sum(sub1.thr)) -
                                                                                                ROUND(if(
                                                                                                        (b.lamakerja * 500000) >=
                                                                                                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                         b.a5 +
                                                                                                         sum(sub1.thr)) *
                                                                                                        0.05,
                                                                                                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                         b.a5 +
                                                                                                         sum(sub1.thr)) *
                                                                                                        0.05,
                                                                                                        b.lamakerja *
                                                                                                        500000
                                                                                                      )) + b.a10, 0,
                                                                                                floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                       b.a5 +
                                                                                                       sum(sub1.thr)) -
                                                                                                      ROUND(if(
                                                                                                              (b.lamakerja * 500000) >=
                                                                                                              ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                               b.a5 +
                                                                                                               sum(sub1.thr)) *
                                                                                                              0.05,
                                                                                                              ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                               b.a5 +
                                                                                                               sum(sub1.thr)) *
                                                                                                              0.05,
                                                                                                              b.lamakerja *
                                                                                                              500000
                                                                                                            )) + b.a10 -
                                                                                                      CASE
                                                                                                          WHEN sub1.status_ptkp = 'TK/0'
                                                                                                              THEN 54000000
                                                                                                          WHEN sub1.status_ptkp = 'TK/1'
                                                                                                              THEN 58500000
                                                                                                          WHEN sub1.status_ptkp = 'TK/2'
                                                                                                              THEN 63000000
                                                                                                          WHEN sub1.status_ptkp = 'TK/3'
                                                                                                              THEN 67500000
                                                                                                          WHEN sub1.status_ptkp = 'K/0'
                                                                                                              THEN 58500000
                                                                                                          WHEN sub1.status_ptkp = 'K/1'
                                                                                                              THEN 63000000
                                                                                                          WHEN sub1.status_ptkp = 'K/2'
                                                                                                              THEN 67500000
                                                                                                          WHEN sub1.status_ptkp = 'K/3'
                                                                                                              THEN 72000000
                                                                                                          WHEN sub1.status_ptkp = 'HB/1'
                                                                                                              THEN 58500000
                                                                                                          WHEN sub1.status_ptkp = 'HB/2'
                                                                                                              THEN 63000000
                                                                                                          WHEN sub1.status_ptkp = 'HB/3'
                                                                                                              THEN 67500000
                                                                                                          ELSE 0
                                                                                                          end)) /
                                                                                             1000) * 1000 - 60000000) *
                                                                                      0.15 + 3000000
                       WHEN FLOOR(if(CASE
                                         WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                                         WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                                         WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                                         WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                                         WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                                         WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                                         WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                                         WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                                         WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                                         WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                                         WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                                         ELSE 0
                                         end > ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5) - ROUND(if(
                               (b.lamakerja * 500000) >=
                               ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5) * 0.05,
                               ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5) * 0.05,
                               b.lamakerja * 500000
                                                                                                                 )) +
                                               b.a10, 0,
                                     floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5) - ROUND(if(
                                             (b.lamakerja * 500000) >=
                                             ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5) * 0.05,
                                             ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5) * 0.05,
                                             b.lamakerja * 500000
                                                                                                             )) +
                                           b.a10 - CASE
                                                       WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                                                       WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                                                       WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                                                       WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                                                       WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                                                       WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                                                       WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                                                       WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                                                       WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                                                       WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                                                       WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                                                       ELSE 0
                                               end)) / 1000) * 1000 <= 500000000 THEN (FLOOR(if(CASE
                                                                                                    WHEN sub1.status_ptkp = 'TK/0'
                                                                                                        THEN 54000000
                                                                                                    WHEN sub1.status_ptkp = 'TK/1'
                                                                                                        THEN 58500000
                                                                                                    WHEN sub1.status_ptkp = 'TK/2'
                                                                                                        THEN 63000000
                                                                                                    WHEN sub1.status_ptkp = 'TK/3'
                                                                                                        THEN 67500000
                                                                                                    WHEN sub1.status_ptkp = 'K/0'
                                                                                                        THEN 58500000
                                                                                                    WHEN sub1.status_ptkp = 'K/1'
                                                                                                        THEN 63000000
                                                                                                    WHEN sub1.status_ptkp = 'K/2'
                                                                                                        THEN 67500000
                                                                                                    WHEN sub1.status_ptkp = 'K/3'
                                                                                                        THEN 72000000
                                                                                                    WHEN sub1.status_ptkp = 'HB/1'
                                                                                                        THEN 58500000
                                                                                                    WHEN sub1.status_ptkp = 'HB/2'
                                                                                                        THEN 63000000
                                                                                                    WHEN sub1.status_ptkp = 'HB/3'
                                                                                                        THEN 67500000
                                                                                                    ELSE 0
                                                                                                    end >
                                                                                                ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                 b.a5 + sum(sub1.thr)) -
                                                                                                ROUND(if(
                                                                                                        (b.lamakerja * 500000) >=
                                                                                                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                         b.a5 +
                                                                                                         sum(sub1.thr)) *
                                                                                                        0.05,
                                                                                                        ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                         b.a5 +
                                                                                                         sum(sub1.thr)) *
                                                                                                        0.05,
                                                                                                        b.lamakerja *
                                                                                                        500000
                                                                                                      )) + b.a10, 0,
                                                                                                floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                       b.a5 +
                                                                                                       sum(sub1.thr)) -
                                                                                                      ROUND(if(
                                                                                                              (b.lamakerja * 500000) >=
                                                                                                              ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                               b.a5 +
                                                                                                               sum(sub1.thr)) *
                                                                                                              0.05,
                                                                                                              ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) +
                                                                                                               b.a5 +
                                                                                                               sum(sub1.thr)) *
                                                                                                              0.05,
                                                                                                              b.lamakerja *
                                                                                                              500000
                                                                                                            )) + b.a10 -
                                                                                                      CASE
                                                                                                          WHEN sub1.status_ptkp = 'TK/0'
                                                                                                              THEN 54000000
                                                                                                          WHEN sub1.status_ptkp = 'TK/1'
                                                                                                              THEN 58500000
                                                                                                          WHEN sub1.status_ptkp = 'TK/2'
                                                                                                              THEN 63000000
                                                                                                          WHEN sub1.status_ptkp = 'TK/3'
                                                                                                              THEN 67500000
                                                                                                          WHEN sub1.status_ptkp = 'K/0'
                                                                                                              THEN 58500000
                                                                                                          WHEN sub1.status_ptkp = 'K/1'
                                                                                                              THEN 63000000
                                                                                                          WHEN sub1.status_ptkp = 'K/2'
                                                                                                              THEN 67500000
                                                                                                          WHEN sub1.status_ptkp = 'K/3'
                                                                                                              THEN 72000000
                                                                                                          WHEN sub1.status_ptkp = 'HB/1'
                                                                                                              THEN 58500000
                                                                                                          WHEN sub1.status_ptkp = 'HB/2'
                                                                                                              THEN 63000000
                                                                                                          WHEN sub1.status_ptkp = 'HB/3'
                                                                                                              THEN 67500000
                                                                                                          ELSE 0
                                                                                                          end)) /
                                                                                             1000) * 1000 - 250000000) *
                                                                                      0.25 + 31500000
                       ELSE (FLOOR(if(CASE
                                          WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                                          WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                                          WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                                          WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                                          WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                                          WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                                          WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                                          WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                                          WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                                          WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                                          WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                                          ELSE 0
                                          end >
                                      ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) -
                                      ROUND(if(
                                              (b.lamakerja * 500000) >=
                                              ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 +
                                               sum(sub1.thr)) * 0.05,
                                              ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 +
                                               sum(sub1.thr)) * 0.05,
                                              b.lamakerja * 500000
                                            )) + b.a10, 0,
                                      floor(((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 + sum(sub1.thr)) -
                                            ROUND(if(
                                                    (b.lamakerja * 500000) >=
                                                    ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 +
                                                     sum(sub1.thr)) * 0.05,
                                                    ((sum(sub1.total_gaji) + ifnull(s.gaji_pokok, 0)) + b.a5 +
                                                     sum(sub1.thr)) * 0.05,
                                                    b.lamakerja * 500000
                                                  )) + b.a10 - CASE
                                                                   WHEN sub1.status_ptkp = 'TK/0' THEN 54000000
                                                                   WHEN sub1.status_ptkp = 'TK/1' THEN 58500000
                                                                   WHEN sub1.status_ptkp = 'TK/2' THEN 63000000
                                                                   WHEN sub1.status_ptkp = 'TK/3' THEN 67500000
                                                                   WHEN sub1.status_ptkp = 'K/0' THEN 58500000
                                                                   WHEN sub1.status_ptkp = 'K/1' THEN 63000000
                                                                   WHEN sub1.status_ptkp = 'K/2' THEN 67500000
                                                                   WHEN sub1.status_ptkp = 'K/3' THEN 72000000
                                                                   WHEN sub1.status_ptkp = 'HB/1' THEN 58500000
                                                                   WHEN sub1.status_ptkp = 'HB/2' THEN 63000000
                                                                   WHEN sub1.status_ptkp = 'HB/3' THEN 67500000
                                                                   ELSE 0
                                                end)) / 1000) * 1000 - 500000000) * 0.3 + 94000000
                       END                                                                                      AS A17
            from (SELECT emp.id,
                         emp.nik,
                         emp.npwp,
                         emp.nama,
                         emp.status_ptkp,
                         emp.is_active,
                         c.id_company,
                         ps.gaji_pokok,
                         IFNULL(ps.sc, 0)                 as sc,
                         ifNULL(t.thr, 0)                as thr,
                         ps.gaji_pokok + IFNULL(ps.sc, 0) AS total_gaji,
                         ps.pph21,
                         ps.updated_at,
                         ps.created_at
                  FROM employee AS emp
                           LEFT JOIN company AS c ON emp.id_company = c.id_company
                           LEFT JOIN phh21s AS ps ON emp.id = ps.id_employee
                           LEFT JOIN (SELECT distinct id_employee, MAX(updated_at) AS max_updated_at FROM tunjangans WHERE MONTH(updated_at) <= 12 GROUP BY id_employee) AS max_tunjangans
                                ON emp.id = max_tunjangans.id_employee
                          left join tunjangans t on emp.id = t.id_employee  and t.updated_at = max_tunjangans.max_updated_at and ps.updated_at = t.updated_at
                  WHERE emp.id_company = :id_company
                    AND month(ps.updated_at) BETWEEN 1 AND 11
                  GROUP BY emp.id,
                           emp.nik,
                           emp.npwp,
                           emp.nama,
                           emp.is_active,
                           c.id_company,
                           ps.updated_at
)
                     as sub1
                     left join (select id_employee, gaji_pokok
                                from salaries
                                where month(updated_at) = 12 and year(updated_at) = year(now())) s
                               on sub1.id = s.id_employee
                     left join (select id_employee,
                                       sum(b.jkm + b.jkk + b.bpjs_kesehatan)                                        AS a5,
                                       sum(b.jht_karyawan + b.jp_karyawan)                                          as a10,
                                       IF((b.jkm + b.jkk + b.bpjs_kesehatan) <> 0, MONTHNAME(MIN(b.created_at)),
                                          0)                                                                        AS awalKerja,
                                       IF((b.jkm + b.jkk + b.bpjs_kesehatan) <> 0, MONTHNAME(MAX(b.updated_at)),
                                          0)                                                                        AS akhirKerja,
                                       IF((b.jkm + b.jkk + b.bpjs_kesehatan) <> 0,
                                          MAX(MONTH(b.updated_at)) - MIN(MONTH(b.updated_at)) + 1,
                                          0)                                                                        AS lamakerja
                                from bpjs as b
                                where year(updated_at) = year(now())
                                group by id_employee) b ON sub1.id = b.id_employee
            group by sub1.id, b.awalKerja,
                     b.akhirKerja,
                     b.lamakerja,
                     s.gaji_pokok, b.a5, b.a10) as rekap
               left join (SELECT emp.id,
                                 c.id_company,
                                 ps.pph21,
                                 ps.updated_at,
                                 ps.created_at
                          FROM employee AS emp
                                   LEFT JOIN company AS c ON emp.id_company = c.id_company
                                   LEFT JOIN phh21s AS ps ON emp.id = ps.id_employee
                          WHERE emp.id_company = :id_company2
                            AND month(ps.updated_at) BETWEEN 1 AND 12
                            and ps.keterangan_pph = 'reportMonthly'
                          GROUP BY emp.id,
                                   c.id_company,
                                   ps.updated_at) totalpph
                         on rekap.id = totalpph.id and rekap.id_company = totalpph.id_company
      group by rekap.id)";

    DB::insert($sql, [
        'id_company' => $request->id_company, 
        'id_company2' => $request->id_company, 
        'monthnum1' => $request->month, 
        'monthnum2' => $request->month,
        'keterangan_pph' => $request->keterangan_pph
    ]);
    }
    
    return redirect()->route('showPph', ['id_company' => $request->id_company, 'monthnum'=> $request->month, 'keterangan_pph' => $request->keterangan_pph ])->with('succes','data berhasil ditambahkan');

    }

    public function insertShow($id_company, $monthnum, $keterangan_pph)
    {
        //
        $sql = "SELECT 
        emp.id,
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
        gaji_pokok,
        A5,
      	sc,
        natura,
        thr,
        lain_lain,
        gaji_bruto,
        `Ter alias`  as ter_alias,
        pph21,
        thp,
        gross_up,
        keterangan_pph,
        MONTHNAME(phh21s.updated_at) AS bulan,
        YEAR(phh21s.updated_at) AS year
        FROM phh21s 
        LEFT JOIN company AS c ON phh21s.id_company = c.id_company
        left Join employee as emp on phh21s.id_employee = emp.id
        WHERE emp.id_company = :id_company and MONTH(phh21s.updated_at) = :monthnum and keterangan_pph= :keterangan_pph";

        $dataPPH21 = DB::select($sql, ['id_company' => $id_company,'monthnum'=> $monthnum, 'keterangan_pph' => $keterangan_pph]);
        $dataPerusahaan = Company::all();
        // Pass the data to the view to display
        return view('pph21.pph21', compact('dataPPH21','dataPerusahaan'));
    }

    public function reportShow($id_company, $monthnum)
    {
        //
        $sql = "SELECT 
        emp.id,
        emp.nama,
        emp.nik,
        emp.npwp,
        c.name_company,
        gaji_pokok,
        A5,
      	sc,
        natura,
        thr,
        lain_lain,
        gaji_bruto,
        `Ter alias`  as ter_alias,
        pph21,
        thp,
        gross_up,
        keterangan_pph,
        MONTHNAME(phh21s.updated_at) AS bulan,
        YEAR(phh21s.updated_at) AS year
        FROM phh21s 
        LEFT JOIN company AS c ON phh21s.id_company = c.id_company
        left Join employee as emp on phh21s.id_employee = emp.id
        WHERE emp.id_company = :id_company and MONTH(phh21s.updated_at) = :monthnum";

        $dataPPH21 = DB::select($sql, ['id_company' => $id_company,'monthnum' => $monthnum]);
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
