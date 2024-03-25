@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="m-4  ">
        <h1 class="text-center">Laporan PPH21</h1>
        <form id="bpjsForm" action="#" method="POST">
            @csrf
            <!-- Other form fields -->
            <div class="d-flex justify-content-between p-3">
                <div class="d-flex">
                    <div class="form-group w-50">
                        <label><strong>Perusahaan</strong></label>
                        <select id="company" class="form-control" name="id_company">
                            <option value="">Pilih Perusahaan</option>
                            @foreach ($dataPerusahaan as $item)
                                <option value="{{ $item->id_company }}">{{ $item->name_company }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="DateReport">Bulan:</label>
                        <select id="month" class="form-control" name="month">
                            <option value="">Pilih Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
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
                        <th scope="col">NPWP</th>
                        <th scope="col">Gaji Pokok</th>
                        <th scope="col">BPJS</th>
                        <th scope="col">SC</th>
                        <th scope="col">NATURA</th>
                        <th scope="col">THR</th>
                        <th scope="col">LAIN - LAIN</th>
                        <th scope="col">GAJI BRUTO</th>
                        <th scope="col">Ter Alias</th>
                        <th scope="col">PPH 21</th>
                        <th scope="col">THP</th>
                        <th scope="col">GROSS UP</th>
                        <th scope="col">KETERANGAN PPH</th>
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
                            <td>{{ $item->npwp }}</td>
                            <td>{{ $item->gaji_pokok }}</td>
                            <td>{{ $item->A5 }}</td>
                            <td>{{ $item->sc }}</td>
                            <td>{{ $item->natura }}</td>
                            <td>{{ $item->thr }}</td>
                            <td>{{ $item->lain_lain }}</td>
                            <td>{{ $item->gaji_bruto }}</td>
                            <td>{{ $item->ter_alias }}</td>
                            <td>{{ $item->pph21 }}</td>
                            <td>{{ $item->thp }}</td>
                            <td>{{ $item->gross_up }}</td>
                            <td>{{ $item->keterangan_pph }}</td>
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
            var monthnum = document.getElementById('month').value;
            if (companyId === '') {
                // Handle case where no company is selected
                alert('Please select a company.');
                return;
            }

            if (action === 'show') {
                // Redirect to showBpjs route
                window.location.href = "{{ url('reportPph') }}/" + companyId +'/'+ monthnum ;

            }
        }
    </script>
@endsection
@endsection
@endsection
