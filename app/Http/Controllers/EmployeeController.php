<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use App\Imports\TunjanganImport;
use App\Models\Ptkp;
use App\Models\Salary;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Tunjangan;
use Illuminate\Contracts\Session\Session;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session as FacadesSession;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $dataEmployee = Employee::all();
        // $sql="SELECT employee.nik, employee.nama,employee.tempat,
        // employee.tanggal_lahir,employee.alamat,employee.jenis_kelamin,
        // employee.status_PTKP,employee.kode_karyawan,company.name_company,
        // salaries.gaji_pokok, tunjangans.sc,tunjangans.natura,tunjangans.bpjs_kesehatan 
        // FROM employee 
        // LEFT JOIN company ON employee.id_company=company.id_company
        // LEFT JOIN 
        //     (SELECT nik, MAX(updated_at) AS max_updated_at 
        //     FROM salaries GROUP BY nik) 
        //     AS salaries ON employee.nik=salaries.nik
        // LEFT JOIN 
        //     (SELECT nik, MAX(updated_at) AS max_updated_at 
        //     FROM tunjangans GROUP BY nik) 
        //     AS tunjangans ON employee.nik=tunjangans.nik
        // ";

        $dataEmployee = DB::table('employee')
        ->join('company', 'employee.id_company', '=', 'company.id_company')
        ->select('employee.nik', 'employee.nama','employee.tempat',
        'employee.tanggal_lahir','employee.alamat','employee.jenis_kelamin',
        'employee.status_PTKP','employee.kode_karyawan',
        'employee.is_active',
        'company.id_company','company.name_company')
        ->get();
        // $dataEmployee = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('employee.Employee',compact('dataEmployee','dataPerusahaan'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $dataPerusahaan = Company::all();
        $dataPtkp = Ptkp::all();
        return view('employee.addEmployee',compact('dataPerusahaan','dataPtkp'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'nik' => 'required|integer',
            'tempat' => 'string',
            'tanggal_lahir' => 'date',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => 'string',
            'status_ptkp' => 'string',
            'kode_karyawan' => 'string',
            'id_company' => 'integer',
            'salary' => 'required|integer',

        ]);

        // dd($request->all());
        try{
            Employee::create([
                'nama'  => $request->nama,
                'nik' => $request->nik,
                'tempat' => $request->tempat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_ptkp' => $request->status_ptkp,
                'id_company' => $request->id_company,
                'kode_karyawan' => $request->kode_karyawan,
                'is_active' => 1,
                'created_at' => DB::raw('NOW()')
            ]);
        }   catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with([
                    'error' => 'Error, Data Karyawan Sudah terdapat didatabase.'
                ]);
            } else {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['error' => 'An error occurred while processing your request'], 500);
            }
        }
            
        Salary::create([
            'nik' => $request->nik,
            'gaji_pokok' => $request->salary
        ]);
        
        Tunjangan::create([
            'nik' => $request->nik,
            'sc' => $request->sc,
            'natura' => $request->natura,
            'bpjs_kesehatan' => $request->bpjs_kesehatan
        ]);
           return back()->with([
            'success' => 'Berhasil menambahkan data perusahaan.'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id_company)
    {
        
        $sql ="SELECT employee.nik, employee.nama,employee.tempat,
        employee.tanggal_lahir,employee.alamat,employee.jenis_kelamin,
        employee.status_PTKP,employee.kode_karyawan,company.id_company,company.name_company
        FROM employee 
        LEFT JOIN company ON employee.id_company=company.id_company
        WHERE employee.id_company =  $id_company
        ";

        $dataEmployee = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('employee.Employee',compact('dataEmployee','dataPerusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $nik)
    {
        //
        $dataPerusahaan = Company::all();
        $dataPtkp = Ptkp::all();

        $sql="SELECT employee.nik, employee.nama,employee.tempat,
        employee.tanggal_lahir,employee.alamat,employee.jenis_kelamin,
        employee.status_PTKP,employee.kode_karyawan,employee.is_active,
        company.id_company,company.name_company,
        salaries.gaji_pokok, tunjangans.sc,tunjangans.natura,tunjangans.bpjs_kesehatan 
        FROM employee 
        LEFT JOIN company ON employee.id_company=company.id_company
        LEFT JOIN 
            (SELECT nik, gaji_pokok 
            FROM salaries WHERE nik =  $nik ORDER BY updated_at desc limit 1) 
            AS salaries ON employee.nik=salaries.nik
        LEFT JOIN 
            (SELECT nik,sc,natura,bpjs_kesehatan
            FROM tunjangans WHERE nik =  $nik ORDER BY updated_at desc limit 1)
            AS tunjangans ON employee.nik=tunjangans.nik
        WHERE employee.nik =  $nik
        ";
        $dataEmployee = DB::select($sql)[0];
        return view('employee.EditEmployee', compact('dataEmployee','dataPerusahaan','dataPtkp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nik)
    {

        $sql="SELECT employee.nik, employee.nama,employee.tempat,
        employee.tanggal_lahir,employee.alamat,employee.jenis_kelamin,
        employee.status_PTKP,employee.kode_karyawan,company.id_company,company.name_company,
        salaries.gaji_pokok, tunjangans.sc,tunjangans.natura,tunjangans.bpjs_kesehatan 
        FROM employee 
        LEFT JOIN company ON employee.id_company=company.id_company
        LEFT JOIN 
            (SELECT nik, gaji_pokok 
            FROM salaries WHERE nik =  $nik ORDER BY updated_at desc limit 1) 
            AS salaries ON employee.nik=salaries.nik
        LEFT JOIN 
            (SELECT nik,sc,natura,bpjs_kesehatan
            FROM tunjangans WHERE nik =  $nik ORDER BY updated_at desc limit 1)
            AS tunjangans ON employee.nik=tunjangans.nik
        WHERE employee.nik =  $nik
        ";
        $dataEmployee = DB::select($sql)[0];

        DB::table('employee')
            ->where('nik', $nik)
                ->update([
                    'nama' => $request->nama,
                    'nik' => $request->nik,
                    'tempat' => $request->tempat,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'alamat' => $request->alamat,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'status_ptkp' => $request->status_PTKP,
                    'kode_karyawan' => $request->kode_karyawan,
                    'is_active' => $request->is_active,
                    'id_company' => $request->id_company,
                    // 'updated_at' => now() // Assuming you want to update the 'updated_at' column to the current timestamp
        ]);

        if($dataEmployee->gaji_pokok != $request->gaji_pokok){
            Salary::create([
                'nik' => $nik,
                'gaji_pokok' => $request->gaji_pokok
            ]);
            // return $dataEmployee->gaji_pokok == $request->gaji_pokok;
        }

        if($dataEmployee->sc != $request->sc || 
        $dataEmployee->natura != $request->natura || 
        $dataEmployee->bpjs_kesehatan != $request->bpjs_kesehatan)
        {
            Tunjangan::create([
                'nik' => $nik,
                'sc' => $request->sc,
                'natura' => $request->natura,
                'bpjs_kesehatan' => $request->bpjs_kesehatan
            ]);
            // return $dataEmployee->sc !== $request->sc || 
            // $dataEmployee->natura !== $request->natura || 
            // $dataEmployee->bpjs_kesehatan !== $request->bpjs_kesehatan;
        }

        return redirect()->route('employee.view')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function export_excel()
	{
		return Excel::download(new EmployeeExport, 'employee.xlsx');
	}

    public function import_excel(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// get file excel
		$file = $request->file('file');
 
		// make unique file
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_tunjangan di dalam folder public
		$file->move('file_tunjangan',$nama_file);
 
		// import data
		Excel::import(new TunjanganImport, public_path('/file_tunjangan/'.$nama_file));
 
		// notifikasi dengan session
		FacadesSession::flash('sukses','Data Berhasil Diimport!');
 
		// alihkan halaman kembali
		return redirect('/employee');
	}
}
