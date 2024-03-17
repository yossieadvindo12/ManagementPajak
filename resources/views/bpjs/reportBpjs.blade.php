@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="m-4  ">
        <h1 class="text-center">Data BPJS</h1>
        <form id="bpjsForm" action="#" method="POST">
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
                    <button type="button" class="mt-4 btn btn-success" onclick="submitForm('show')">Cari</button>
                </div>
            </div>
            <!-- Other form fields -->
        </form>
        
        
        
        <div class="row table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Nama Perusahaan</th>
                        <th scope="col">NIK</th>
                        <th scope="col">Gaji Pokok</th>
                        <th scope="col">JHT KARYAWAN</th>
                        <th scope="col">JHT PT</th>
                        <th scope="col">JKM</th>
                        <th scope="col">JKK</th>
                        <th scope="col">JP KARYAWAN</th>
                        <th scope="col">JP PT</th>
                        <th scope="col">BPJS KESEHATAN</th>
                        <th scope="col">DITANGGUNG KARYAWAN</th>
                        <th scope="col">DITANGGUNG PT</th>
                        <th scope="col">BULAN</th>
                        <th scope="col">TAHUN</th>
                        {{-- <th scope="col">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataBPJS as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->name_company }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->gaji_pokok }}</td>
                            <td>{{ $item->jht_karyawan }}</td>
                            <td>{{ $item->jht_pt }}</td>
                            <td>{{ $item->jkm }}</td>
                            <td>{{ $item->jkk }}</td>
                            <td>{{ $item->jp_karyawan }}</td>
                            <td>{{ $item->jp_pt }}</td>
                            <td>{{ $item->bpjs_kesehatan }}</td>
                            <td>{{ $item->ditanggung_karyawan }}</td>
                            <td>{{ $item->ditanggung_pt }}</td>
                            <td>{{ $item->bulan }}</td>
                            <td>{{ $item->year }}</td>
                            {{-- <td>Pelukis</td> --}}

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function submitForm(action) {
            var form = document.getElementById('bpjsForm');
            var companyId = document.getElementById('company').value;
    
            if (companyId === '') {
                // Handle case where no company is selected
                alert('Please select a company.');
                return;
            }
    
            if (action === 'show') {
                // Redirect to showBpjs route
                window.location.href = "{{ url('reportBpjs') }}/" + companyId;
            
            }
        }
    </script>
@endsection
@endsection
@endsection
