@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="m-4">
        <h1 class="text-center">Data Karyawan</h1>
        <button type="button" class=" mb-4 btn btn-success"><a class="text-decoration-none text-light" href="/addEmployee">Tambah +</a></button>
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
@endsection
@endsection
@endsection
