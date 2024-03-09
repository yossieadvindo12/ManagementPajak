@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="m-4">
        <h1 class="text-center">Data Karyawan</h1>
        <button type="button" class=" mb-4 btn btn-success"><a class="text-decoration-none text-light" href="/addemployee">Tambah +</a></button>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">NIK</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Jenis Kelamin</th>
                        {{-- <th scope="col">Perusahaan</th> --}}
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataKaryawan as $item)
                        
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->Nama }}</td>
                        <td>{{ $item->NIK }}</td>
                        <td>{{ $item->Alamat }}</td>
                        <td>{{ $item->JenisKelamin }}</td>
                        {{-- <td>Pelukis</td> --}}
                        
                        <td>
                            <button type="button" class="btn btn-warning">Edit</button>
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
