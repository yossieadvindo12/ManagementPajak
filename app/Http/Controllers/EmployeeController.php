<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

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
        return view('employee.addEmployee');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
            // 'nama'  => 'required|string|max:255',
            // 'nik' => 'required|integer|max:16',
            // 'tempat' => 'string',
            // 'tanggal_lahir' => 'date',
            // 'alamat' => 'required|string|max:255',
            // 'jenis_kelamin' => 'string',
            // 'status_ptkp' => 'integer',
            // 'kode_karyawan' => 'string',
            // 'id_company' => 'integer'
        // ]);

        dd($request->all()); 
        // User::create($data);
        // Company::create([
        //     'name_company' => $request->name_company,
        //     'created_at' => DB::raw('NOW()'),
        //     'updated_at' =>  DB::raw('NOW()')
        //    ]);
        
        // return back()->with([
        //     'success' => 'Berhasil menambahkan data perusahaan.'
        // ]);
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
