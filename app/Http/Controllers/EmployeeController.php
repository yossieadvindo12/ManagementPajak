<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Ptkp;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Tunjangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $dataEmployee = Employee::all();
        $dataEmployee = DB::table('employee')
        ->join('company', 'employee.id_company', '=', 'company.id_company')
        ->select('employee.nik', 'employee.nama','employee.tempat',
        'employee.tanggal_lahir','employee.alamat','employee.jenis_kelamin',
        'employee.status_PTKP','employee.kode_karyawan','company.name_company')
        ->get();
        return view('employee.Employee',compact('dataEmployee'));
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
        Employee::create([
            'nama'  => $request->nama,
            'nik' => $request->nik,
            'tempat' => $request->tempat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_ptkp' => $request->status_ptkp,
            'kode_karyawan' => $request->kode_karyawan,
            'id_employee' => $request->id_employee,
            'is_active' => 1,
            'created_at' => DB::raw('NOW()')
           ]);
        
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
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $nik)
    {
        //
        $dataPerusahaan = Company::all();
        $dataPtkp = Ptkp::all();

        $dataEmployee = Employee::where('nik', $nik)->firstOrFail();
        return view('employee.EditEmployee', compact('dataEmployee','dataPerusahaan','dataPtkp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nik)
    {
        DB::table('employee')
            ->where('nik', $nik)
                ->update([
                    'nama' => $request->nama,
                    // 'nik' => $request->nik,
                    'tempat' => $request->tempat,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'alamat' => $request->alamat,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'status_ptkp' => $request->status_PTKP,
                    'kode_karyawan' => $request->kode_karyawan,
                    'id_company' => $request->id_company,
                    // 'updated_at' => now() // Assuming you want to update the 'updated_at' column to the current timestamp
        ]);
        
        return redirect()->route('employee.view')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
