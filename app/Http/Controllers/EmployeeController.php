<?php

namespace App\Http\Controllers;

use App\Models\Ptkp;
use App\Models\Company;
use App\Models\Employee;
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
        $dataEmployee = Employee::all();
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
            'id_company' => 'integer'
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
            'id_company' => $request->id_company,
            'is_active' => 1,
            'created_at' => DB::raw('NOW()')
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
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
