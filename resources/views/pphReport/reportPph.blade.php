@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="m-4  ">
        <h1 class="text-center">Laporan PPH 21 </h1>
        <form id="bpjsForm" action="#" method="POST">
            @csrf
            <!-- Other form fields -->
            <div class="d-flex justify-content-between mb-5">
                <div class="d-flex">
                    <div class="form-group w-35 ml-3">
                        <label><strong>Perusahaan</strong></label>
                        <select id="company" class="form-control" name="id_company">
                            <option value="">Pilih Perusahaan</option>
                            @foreach ($dataPerusahaan as $item)
                            <option value="{{ $item->id_company }}">{{ $item->name_company }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="DateReport"><strong>Tahun: </strong></label>
                        <select id="year" class="form-control" name="year">
                            <option value="{{ date('Y',strtotime('- 2 year')) }}">{{ date('Y',strtotime('- 2 year')) }}</option>
                            <option value="{{ date('Y',strtotime('- 1 year')) }}">{{ date('Y',strtotime('- 1 year')) }}</option>
                            <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                            <option value="{{ date('Y',strtotime('+ 1 year')) }}">{{ date('Y',strtotime('+ 1 year')) }}</option>
                            <option value="{{ date('Y',strtotime('+ 2 year')) }}">{{ date('Y',strtotime('+ 2 year')) }}</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex">
                    <button type="button" class="mt-4 btn btn-success" onclick="submitForm('show')">Cari</button>
                </div>
            </div>
            {{-- <div class="form-group ml-3">
                <label for="DateReport"><strong>Tahun: </strong></label>
                <select id="year" class="form-control" name="year">
                    <option value="{{ date('Y',strtotime('- 2 year')) }}">{{ date('Y',strtotime('- 2 year')) }}</option>
                    <option value="{{ date('Y',strtotime('- 1 year')) }}">{{ date('Y',strtotime('- 1 year')) }}</option>
                    <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                    <option value="{{ date('Y',strtotime('+ 1 year')) }}">{{ date('Y',strtotime('+ 1 year')) }}</option>
                    <option value="{{ date('Y',strtotime('+ 2 year')) }}">{{ date('Y',strtotime('+ 2 year')) }}</option>
                </select>
            </div> --}}
            <div class="d-flex">
                <button type="button" class="m-2 btn btn-success" onclick="exportExcel()">export</button>
            </div>
            </form>
        
        
        
        <div class="row table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">NIK</th>
                        <th scope="col">NPWP</th>
                        <th scope="col">Nama Perusahaan</th>
                        <th scope="col">JANUARY</th>
                        <th scope="col">FEBRUARY</th>
                        <th scope="col">MARCH</th>
                        <th scope="col">APRIL</th>
                        <th scope="col">MAY</th>
                        <th scope="col">JUNE</th>
                        <th scope="col">JULY</th>
                        <th scope="col">AUGUST</th>
                        <th scope="col">SEPTEMBER</th>
                        <th scope="col">OCTOBER</th>
                        <th scope="col">NOVEMBER</th>
                        <th scope="col">DECEMBER</th>
                        <th scope="col">Total</th>
                        {{-- <th scope="col">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataSalary as $item)
                        <tr>
                            <th scope="row">{{ $item->nama }}</th>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->npwp }}</td>
                            <td>{{ $item->name_company }}</td>
                            <td>Rp. {{ number_format($item->JANUARY,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->FEBRUARY,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->MARCH,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->APRIL,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->MAY,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->JUNE,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->JULY,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->AUGUST,'0',',','.')  }}</td>
                            <td>Rp. {{ number_format($item->SEPTEMBER,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->OCTOBER,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->NOVEMBER,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->DECEMBER,'0',',','.') }}</td>
                            <td>Rp. {{ number_format($item->total,'0',',','.') }}</td>
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
            var year = document.getElementById('year').value;
    
            if (companyId === '') {
                // Handle case where no company is selected
                alert('Please select a company.');
                return;
            }
    
            if (action === 'show') {
                // Redirect to showBpjs route
                window.location.href = "{{ url('reportSalary') }}/" + companyId +'/'+year;
            
            }
        }
    </script>

    <script>
        function exportExcel(){
            var form = document.getElementById('bpjsForm');
                var year = document.getElementById('year').value;

                window.location.href = "{{url('reportBpjs')}}/export_excel/";
            }
    </script>
@endsection
@endsection
@endsection
