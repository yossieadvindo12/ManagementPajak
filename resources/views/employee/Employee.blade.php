@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="m-4">
        <h1 class="text-center">Data Karyawan</h1>
        <form id="searchForm" action="#" method="POST">
            @csrf
            <!-- Other form fields -->
            <div class="d-flex justify-content-between p-3">
                <div class="form-group w-50">
                    <label><strong>Perusahaan</strong></label>
                    <select id="company" class="form-control" name="id_company">
                        <option value="">Pilih Perusahaan</option>
                        @foreach ($dataPerusahaan as $item)
                        <option value="{{ $item->id_company }}">{{ $item->name_company }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex">
                    <button type="button" class="mt-4  btn btn-success" onclick="submitForm('show')">Cari</button>
                    <button type="button" class="ml-3 mt-4 btn btn-success"><a class="text-decoration-none text-light" href="/addEmployee">Tambah +</a></button>
                </div>
            </div>
            <!-- Other form fields -->
        </form>

        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th scope="col">#</th> --}}
                        <th scope="col">NIK</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tempat/Tanggal Lahir</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Status PTKP</th>
                        <th scope="col">Status Karyawan</th>
                        <th scope="col">Perusahaan</th>
                        {{-- <th scope="col">Perusahaan</th> --}}
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataEmployee as $item)
                        
                    <tr>
                        {{-- <th scope="row">{{ $item->id }}</th> --}}
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->tempat. ', ' .$item->tanggal_lahir }} </td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->status_PTKP }}</td>
                        <td>{{ $item->kode_karyawan }}</td>
                        <td>{{ $item->name_company}}</td>
                        
                        <td>
                            <button type="button" class="btn btn-warning"> 
                                <a class="text-decoration-none text-light" href="{{ route('employee.edit', $item->nik) }}">Edit</a>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function submitForm(action) {
            var form = document.getElementById('searchForm');
            var companyId = document.getElementById('company').value;
    
            if (companyId === '') {
                // Handle case where no company is selected
                alert('Please select a company.');
                return;
            }
    
            if (action === 'show') {
                // Redirect to showEmployee route
                window.location.href = "{{ url('showEmployee') }}/" + companyId;
            }else if (action === 'add') {
                // Submit the form to storeBPJS route
                form.action = "{{ route('addEmployee') }}";
            }
        }
    </script>
@endsection
@endsection
@endsection
