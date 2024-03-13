@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="m-4">
        <h1 class="text-center">Data BPJS</h1>
        <form action="/storeBPJS" method="POST">
            @csrf
            <!-- Other form fields -->
            <div class="d-flex justify-content-between p-3">
                <div class="form-group w-50">
                    <label><strong>Perusahaan</strong></label>
                    <select id="company" class="form-control" name = "id_company">
                        <option value="">Pilih Perusahaan</option>
                        @foreach ($dataPerusahaan as $item)
                            <option value="{{ $item->id_company }}">{{ $item->name_company }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class=" mt-4 btn btn-success">Tambah +</a></button>
            </div>
            <!-- Other form fields -->
        </form>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">NIK</th>
                        <th scope="col">Gaji Pokok</th>
                        <th scope="col">JHT KARYAWAN</th>
                        <th scope="col">JHT PT</th>
                        <th scope="col">JKM</th>
                        <th scope="col">JKK</th>
                        <th scope="col">JP KARYAWAN</th>
                        <th scope="col">JP PT</th>
                        <th scope="col">BULAN</th>
                        <th scope="col">TAHUN</th>
                        <th scope="col">Perusahaan</th>
                        {{-- <th scope="col">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataBPJS as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->gaji_pokok }}</td>
                            <td>{{ $item->jht_karyawan }}</td>
                            <td>{{ $item->jht_pt }}</td>
                            <td>{{ $item->jkm }}</td>
                            <td>{{ $item->jkk }}</td>
                            <td>{{ $item->jp_karyawan }}</td>
                            <td>{{ $item->jp_pt }}</td>
                            <td>{{ $item->bulan }}</td>
                            <td>{{ $item->year }}</td>
                            <td>{{ $item->name_company }}</td>
                            {{-- <td>Pelukis</td> --}}

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@endsection
@endsection
