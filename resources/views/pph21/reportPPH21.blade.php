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
                        <th scope="col">BPJS</th>
                        <th scope="col">SC</th>
                        <th scope="col">NATURA</th>
                        <th scope="col">GAJI BRUTO</th>
                        <th scope="col">Ter Alias</th>
                        <th scope="col">PPH 21</th>
                        <th scope="col">THP</th>
                        <th scope="col">GROSS UP</th>
                        <th scope="col">BULAN</th>
                        <th scope="col">TAHUN</th>
                        {{-- <th scope="col">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataPPH21 as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->name_company }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->gaji_pokok }}</td>
                            <td>{{ $item->A5 }}</td>
                            <td>{{ $item->sc }}</td>
                            <td>{{ $item->natura }}</td>
                            <td>{{ $item->gaji_bruto }}</td>
                            <td>{{ $item->ter_alias }}</td>
                            <td>{{ $item->pph21 }}</td>
                            <td>{{ $item->thp }}</td>
                            <td>{{ $item->gross_up }}</td>
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
                window.location.href = "{{ url('reportPph') }}/" + companyId;
            
            }
        }
    </script>
@endsection
@endsection
@endsection
