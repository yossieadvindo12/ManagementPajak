<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dataPerusahaan = Company::all();
        return view('company.Company',compact('dataPerusahaan'));
    }

    public function addCompany()
    {
        //
        return view('company.AddCompany');
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
            'name_company'  => 'required|string|max:255',
            
        ]);


        // User::create($data);
        Company::create([
            'name_company' => $request->name_company,
            'created_at' => DB::raw('NOW()'),
            'updated_at' =>  DB::raw('NOW()')
           ]);
        
        return back()->with([
            'success' => 'Berhasil menambahkan data perusahaan.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_company)
    {
        //

        $dataCompany = Company::where('id_company', $id_company)->firstOrFail();
        return view('company.EditCompany', compact('dataCompany'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id_company)
    {
        //
        $data = Company::where('id_company', $id_company)->firstOrFail();
    // Update your data here
        // dd($data);
        DB::table('company')
            ->where('id_company', $id_company)
                ->update([
                    'name_company' => $request->name_company,
                    'updated_at' => now() // Assuming you want to update the 'updated_at' column to the current timestamp
        ]);
        
        return redirect()->route('company.view')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_company)
    {
        //
        DB::delete("DELETE FROM company WHERE id_company = ?", [$id_company]);
        return redirect()->route('company.view')->with('success', 'Data updated delete.');

    }
}
