<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use App\Imports\TunjanganImport;
use App\Imports\SalaryImport;
use App\Models\Ptkp;
use App\Models\Salary;
use App\Models\Upah_bpjs;
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
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $dataEmployee = Employee::all();
        $sql="   SELECT emp.id,emp.nik, emp.nama,emp.tempat,
        emp.tanggal_lahir,emp.alamat,emp.jenis_kelamin,
        emp.status_PTKP,emp.kode_karyawan,emp.is_active,c.name_company,emp.status_BPJS,
        max(s.gaji_pokok) gaji_pokok, max(t.sc) sc,max(t.natura) natura,max(t.bpjs_kesehatan) bpjs_kesehatan, max(t.lain_lain) lain_lain
        FROM employee emp
        LEFT JOIN
        (SELECT id_employee, nik, npwp, MAX(updated_at) AS max_updated_at FROM salaries WHERE MONTH(updated_at) <= month(NOW()) GROUP BY id_employee, nik, npwp) AS max_salaries
        ON emp.id = max_salaries.id_employee
        LEFT JOIN
        salaries AS s
        ON emp.id = s.id_employee AND s.updated_at = max_salaries.max_updated_at
        LEFT JOIN
        company AS c
        ON emp.id_company = c.id_company
        LEFT JOIN
        (SELECT id_employee, nik, npwp, MAX(updated_at) AS max_updated_at FROM tunjangans WHERE MONTH(updated_at) <= month(NOW()) GROUP BY id_employee, nik, npwp) AS max_tunjangans
        ON emp.id = max_tunjangans.id_employee
        LEFT JOIN
        tunjangans AS t
        ON emp.id = t.id_employee AND t.updated_at = max_tunjangans.max_updated_at
        group by emp.id,emp.nik, emp.nama,emp.tempat,
        emp.tanggal_lahir,emp.alamat,emp.jenis_kelamin,
        emp.status_PTKP,emp.kode_karyawan,emp.is_active,c.name_company
        ORDER BY emp.id
        ";

        // $dataEmployee = DB::table('employee')
        // ->join('company', 'employee.id_company', '=', 'company.id_company')
        // ->join('salaries', 'employee.id', '=', 'salaries.id_employee')
        // ->select('employee.id', 'employee.npwp', 'employee.nik', 'employee.nama','employee.tempat',
        // 'employee.tanggal_lahir','employee.alamat','employee.jenis_kelamin',
        // 'employee.status_PTKP','employee.kode_karyawan',
        // 'employee.is_active',
        // 'company.id_company','company.name_company')
        // ->get();
        $dataEmployee = DB::select($sql);
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
        if ($request->npwp !== null) {
            $request->validate([
                // 'nama'  => 'string|max:255',
                // 'nik' => 'integer',
                'npwp' => 'required|integer',
                // 'tempat' => 'string',
                // 'tanggal_lahir' => 'date',
                // 'alamat' => 'string|max:255',
                'jenis_kelamin' => 'string',
                'status_ptkp' => 'string',
                'kode_karyawan' => 'string',
                'id_company' => 'integer',
                'salary' => 'required|integer',
            ]);

        }else{
            $request->validate([
                'nama'  => 'required|string|max:255',
                'nik' => 'required|integer',
                // 'npwp' => 'integer',
                'tempat' => 'string',
                'tanggal_lahir' => 'date',
                'alamat' => 'required|string|max:255',
                'jenis_kelamin' => 'string',
                'status_ptkp' => 'string',
                'kode_karyawan' => 'string',
                'id_company' => 'integer',
                'salary' => 'required|integer',
            ]);
        }

        // dd($request->all());
        try{
            Employee::create([
                'nama'  => $request->nama,
                'nik' => $request->nik,
                'npwp' => $request->npwp,
                'tempat' => $request->tempat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_ptkp' => $request->status_ptkp,
                'id_company' => $request->id_company,
                'kode_karyawan' => $request->kode_karyawan,
                'status_bpjs' => $request->status_bpjs,
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

        $dataEmployee = DB::table('employee')
        ->select('employee.id','employee.npwp','employee.nik')
        ->where('employee.npwp','=',$request->npwp)
        ->where('employee.nik', '=', $request->nik)
        ->get();

        // dd($dataEmployee[0]);
        Salary::create([
            'id_employee' => $dataEmployee[0]->id,
            'nik' =>  $request->nik,
            'npwp' =>  $request->npwp,
            'gaji_pokok' => $request->salary
        ]);

        Upah_bpjs::create([
            'id_employee' => $dataEmployee[0]->id,
            'nik' =>  $request->nik,
            'npwp' =>  $request->npwp,
            'upah_bpjs' => $request->upah_bpjs
        ]);

        Tunjangan::create([
            'id_employee' => $dataEmployee[0]->id,
            'nik' =>  $request->nik,
            'npwp' =>  $request->npwp,
            'sc' => $request->sc,
            'natura' => $request->natura,
            'bpjs_kesehatan' => $request->bpjs_kesehatan,
            'thr' => $request->thr,
            'lain_lain' => $request->lain_lain
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

        $sql =" SELECT emp.id,emp.nik, emp.nama,emp.tempat,
        emp.tanggal_lahir,emp.alamat,emp.jenis_kelamin,
        emp.status_PTKP,emp.kode_karyawan,emp.is_active,c.name_company,emp.status_BPJS,
        max(s.gaji_pokok) gaji_pokok, max(t.sc) sc,max(t.natura) natura,max(t.bpjs_kesehatan) bpjs_kesehatan, max(t.lain_lain) lain_lain
        FROM employee emp
        LEFT JOIN
        (SELECT id_employee, nik, npwp, MAX(updated_at) AS max_updated_at FROM salaries WHERE MONTH(updated_at) <= month(NOW()) GROUP BY id_employee, nik, npwp) AS max_salaries
        ON emp.id = max_salaries.id_employee
        LEFT JOIN
        salaries AS s
        ON emp.id = s.id_employee AND s.updated_at = max_salaries.max_updated_at
        LEFT JOIN
        company AS c
        ON emp.id_company = c.id_company
        LEFT JOIN
        (SELECT id_employee, nik, npwp, MAX(updated_at) AS max_updated_at FROM tunjangans WHERE MONTH(updated_at) <= month(NOW()) GROUP BY id_employee, nik, npwp) AS max_tunjangans
        ON emp.id = max_tunjangans.id_employee
        LEFT JOIN
        tunjangans AS t
        ON emp.id = t.id_employee AND t.updated_at = max_tunjangans.max_updated_at
        WHERE emp.id_company =  $id_company
        group by emp.id,emp.nik, emp.nama,emp.tempat,
        emp.tanggal_lahir,emp.alamat,emp.jenis_kelamin,
        emp.status_PTKP,emp.kode_karyawan,emp.is_active,c.name_company
        ORDER BY emp.id";

        $dataEmployee = DB::select($sql);
        $dataPerusahaan = Company::all();
        return view('employee.Employee',compact('dataEmployee','dataPerusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_employee)
    {
        //
        $dataPerusahaan = Company::all();
        $dataPtkp = Ptkp::all();

        $sql="  SELECT emp.id,emp.nik, emp.npwp, emp.nama,emp.tempat,
        emp.tanggal_lahir,emp.alamat,emp.jenis_kelamin,
        emp.status_PTKP,emp.kode_karyawan,emp.is_active,c.id_company,emp.status_BPJS,
        max(s.gaji_pokok) gaji_pokok, max(t.sc) sc,max(t.natura) natura,max(t.bpjs_kesehatan) bpjs_kesehatan, max(t.lain_lain) lain_lain,max(t.thr) thr
        FROM employee emp
        LEFT JOIN
        (SELECT id_employee, nik, npwp, MAX(updated_at) AS max_updated_at FROM salaries WHERE MONTH(updated_at) <= month(NOW()) GROUP BY id_employee, nik, npwp) AS max_salaries
        ON emp.id = max_salaries.id_employee
        LEFT JOIN
        salaries AS s
        ON emp.id = s.id_employee AND s.updated_at = max_salaries.max_updated_at
        LEFT JOIN
        company AS c
        ON emp.id_company = c.id_company
        LEFT JOIN
        (SELECT id_employee, nik, npwp, MAX(updated_at) AS max_updated_at FROM tunjangans WHERE MONTH(updated_at) <= month(NOW()) GROUP BY id_employee, nik, npwp) AS max_tunjangans
        ON emp.id = max_tunjangans.id_employee
        LEFT JOIN
        tunjangans AS t
        ON emp.id = t.id_employee AND t.updated_at = max_tunjangans.max_updated_at
        WHERE emp.id =  $id_employee
        group by emp.id,emp.nik, emp.nama,emp.tempat,
        emp.tanggal_lahir,emp.alamat,emp.jenis_kelamin,
        emp.status_PTKP,emp.kode_karyawan,emp.is_active,c.name_company
        ";
        $dataEmployee = DB::select($sql)[0];
        return view('employee.EditEmployee', compact('dataEmployee','dataPerusahaan','dataPtkp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_employee)
    {

        $sql=" SELECT emp.id,emp.nik, emp.npwp, emp.nama,emp.tempat,
        emp.tanggal_lahir,emp.alamat,emp.jenis_kelamin,
        emp.status_PTKP,emp.kode_karyawan,emp.is_active,c.id_company,emp.status_BPJS,
        max(s.gaji_pokok) gaji_pokok, max(t.sc) sc,max(t.natura) natura,max(t.bpjs_kesehatan) bpjs_kesehatan, max(t.lain_lain) lain_lain,max(t.thr) thr
        FROM employee emp
        LEFT JOIN
        (SELECT id_employee, nik, npwp, MAX(updated_at) AS max_updated_at FROM salaries WHERE MONTH(updated_at) <= month(NOW()) GROUP BY id_employee, nik, npwp) AS max_salaries
        ON emp.id = max_salaries.id_employee
        LEFT JOIN
        salaries AS s
        ON emp.id = s.id_employee AND s.updated_at = max_salaries.max_updated_at
        LEFT JOIN
        company AS c
        ON emp.id_company = c.id_company
        LEFT JOIN
        (SELECT id_employee, nik, npwp, MAX(updated_at) AS max_updated_at FROM tunjangans WHERE MONTH(updated_at) <= month(NOW()) GROUP BY id_employee, nik, npwp) AS max_tunjangans
        ON emp.id = max_tunjangans.id_employee
        LEFT JOIN
        tunjangans AS t
        ON emp.id = t.id_employee AND t.updated_at = max_tunjangans.max_updated_at
        WHERE emp.id =  $id_employee
        group by emp.id,emp.nik, emp.nama,emp.tempat,
        emp.tanggal_lahir,emp.alamat,emp.jenis_kelamin,
        emp.status_PTKP,emp.kode_karyawan,emp.is_active,c.name_company
        ";
        $dataEmployee = DB::select($sql)[0];

        DB::table('employee')
            ->where('id', $id_employee)
                ->update([
                    'nama' => $request->nama,
                    'nik' => $request->nik,
                    'npwp'=> $request->npwp,
                    'tempat' => $request->tempat,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'alamat' => $request->alamat,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'status_ptkp' => $request->status_PTKP,
                    'kode_karyawan' => $request->kode_karyawan,
                    'is_active' => $request->is_active,
                    'id_company' => $request->id_company,
                    'status_bpjs' => $request->status_BPJS,
                    'is_active' => $request->is_active,

                    'updated_at' => now() // Assuming you want to update the 'updated_at' column to the current timestamp
        ]);

        if($dataEmployee->gaji_pokok != $request->gaji_pokok){
            Salary::create([
                'id_employee' => $id_employee,
                'gaji_pokok' => $request->gaji_pokok
            ]);
        }

        if($dataEmployee->sc != $request->sc ||
        $dataEmployee->natura != $request->natura ||
        $dataEmployee->bpjs_kesehatan != $request->bpjs_kesehatan||
        $dataEmployee->thr != $request->thr)
        {
            Tunjangan::create([
                'id_employee' => $id_employee,
                'nik' => $request->nik,
                'npwp'=> $request->npwp,
                'sc' => $request->sc,
                'natura' => $request->natura,
                'bpjs_kesehatan' => $request->bpjs_kesehatan,
                'thr' => $request->thr,
                'lain_lain' => $request->lain_lain
            ]);
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
        $data = Employee::query()->select(
            DB::raw('emp.id as id_employee'),
            'emp.nama',
            'emp.nik',
            'emp.npwp',
            'sc',
            'natura',
            'bpjs_kesehatan',
            'thr',
            'lain_lain',
            'gaji_pokok')
            ->from('employee AS emp')
            ->leftJoin('salaries AS s', 'emp.id', '=', 's.id_employee')
            ->leftJoin('tunjangans AS t', 'emp.id', '=', 't.id_employee')
            ->leftJoin('company AS c', 'emp.id_company', '=', 'c.id_company')
            ->groupBy('emp.id',)
            ->get();

		return Excel::download(new EmployeeExport($data), 'employee.xlsx');
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
		$path = $file->storeAs('public/excel',$nama_file);

		// import data
		Excel::import(new TunjanganImport, storage_path('app/public/excel/'.$nama_file));
        Excel::import(new SalaryImport, storage_path('app/public/excel/'.$nama_file));

		// notifikasi dengan session
		FacadesSession::flash('sukses','Data Berhasil Diimport!');
        Storage::delete($path);

		// alihkan halaman kembali
		return redirect('/employee');
	}
}
