@extends('layout.main')

{{-- @section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item active">Employee>AddEmployee</li>
    </ol>
@endsection --}}
@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="container mt-2">
        <h1>Add Employee</h1>
        <div class="row col-sm-16 mx-auto">
            <div class="card  mt-2 "style="width: 100%;">
                <div class="container">
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    <form id="ocrForm" class="d-flex justify-content-between" action="/extract-text" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-3">
                            <input type="file" id="image" name="image">
                        </div>
                        <button class="btn btn-success mt-3" type="submit" name="submit">Upload & OCR</button>
                    </form>
                    
                    <div class=" mt-5" id="ocrResult"></div>

                    <form id="formEmployee" class="user " action="/storeEmployee" method="post">
                        @csrf
                        <div class="form-group">
                            <label><strong>NIK</strong></label>
                            <input type="text" name="nik" id="nik" value=""
                                class="form-control form-control-user" placeholder="NIK" />
                        </div>
                        @error('nik')
                            <small>{{ $message }}</small>
                        @enderror


                        <div class="form-group">
                            <label><strong>Nama</strong></label>
                            <input type="text" id="nama" name="nama" value=""
                                class="form-control form-control-user"placeholder="NAMA" />
                        </div>
                        @error('nama')
                            <small>{{ $message }}</small>
                        @enderror


                        <div class="form-group">
                            <label><strong>Tempat Lahir</strong></label>
                            <input type="text" id="tempat" name="tempat" value=""
                                class="form-control form-control-user" placeholder="Tempat Lahir" />
                        </div>
                        @error('tempat')
                            <small>{{ $message }}</small>
                        @enderror

                        <div class="form-group">
                            <label><strong>Tanggal Lahir</strong></label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value=""
                                class="form-control form-control-user" placeholder="Tgl Lahir" />
                        </div>
                        @error('tanggal_lahir')
                            <small>{{ $message }}</small>
                        @enderror


                        <div class="form-group">
                            <label><strong>Alamat</strong></label>
                            <input type="text" id="alamat" name="alamat" value=""
                                class="form-control form-control-user" placeholder="Alamat" />
                        </div>
                        @error('alamat')
                            <small>{{ $message }}</small>
                        @enderror


                        <div class="form-group">
                            <label><strong>Jenis Kelamin</strong></label>
                            <select class="form-control" name = "jenis_kelamin">
                                <option value = "laki-laki"> LAKI - LAKI </option>
                                <option value = "perempuan"> PEREMPUAN </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong>Status Karyawan</strong></label>
                            <select class="form-control" name = "kode_karyawan">
                                <option value = "karyawan"> karyawan </option>
                                <option value = "tukang"> tukang </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><strong>Status PTKP</strong></label>
                            <select id='ptkp' class="form-control" name ="status_ptkp">
                                <option value="">Pilih Status PTKP</option>
                                @foreach ($dataPtkp as $item)
                                
                                <option value="{{  $item->ptkp}}">{{ $item->ptkp }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong>Perusahaan</strong></label>
                            <select id="company" class="form-control" name = "id_company">
                                <option value="">Pilih Perusahaan</option>
                                @foreach ($dataPerusahaan as $item)
                                
                                <option value="{{  $item->id_company}}">{{ $item->name_company }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong>Gaji Pokok</strong></label>
                            <input type="text" id="salary" name="salary" value=""
                                class="form-control form-control-user" placeholder="gaji pokok" />
                        </div>
                        <div class="form-group">
                            <label><strong>Tunjangan SC</strong></label>
                            <input type="text" id="sc" name="sc" value="{{ old('sc') }}"
                                class="form-control form-control-user" placeholder="Tunjangan SC" />
                        </div>
                        @error('salary')
                        <small>{{ $message }}</small>
                    @enderror
                        <div class="form-group">
                            <label><strong>Tunjangan Natura</strong></label>
                            <input type="text" id="natura" name="natura" value="{{ old('natura') }}"
                                class="form-control form-control-user" placeholder="Tunjangan Natura" />
                        </div>
                        @error('natura')
                        <small>{{ $message }}</small>
                    @enderror
                        <div class="form-group">
                            <label><strong>BPJS KESEHATAN</strong></label>
                            <input type="text" id="bpjs_kesehatan" name="bpjs_kesehatan" value="{{ old('bpjs_kesehatan') }}"
                                class="form-control form-control-user" placeholder="BPJS KESEHATAN" />
                        </div>
                        @error('bpjs_kesehatan')
                            <small>{{ $message }}</small>
                        @enderror
                        <button type="submit" class="btn btn-primary btn-user btn-block">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Menangkap respon dari form submission menggunakan JavaScript
        document.querySelector('form').addEventListener('submit', async function(event) {
            event.preventDefault();

            var formEmployee = document.getElementById('formEmployee');
            if (formEmployee.classList.contains('d-none')) {
                formEmployee.classList.remove('d-none');
                formEmployee.classList.add('d-block');
            }

            const formData = new FormData(this);

            try {
                const response = await fetch(this.getAttribute('action'), {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Ada kesalahan saat memproses form.');
                }

                const jsonData = await response.json();

                function generateDataKTP(data) {
                    const dataktp = data.dataKTP;
                    const ptkpoptions = data.ptkpOptions;
                    const companyOptions = data.companyOptions;
                    console.log(dataktp);
                    // html +='<input type="text" value="'+data[1]+'" /><br>
                    var nik, nama, tempat, tanggal_lahir, alamat;
                    for (var key in dataktp) {
                        if (key.toLowerCase().includes('nik')) {
                            var resultInput = document.getElementById('nik');
                            nik = dataktp[key];
                            resultInput.value = nik;
                        }
                        if (key.toLowerCase().includes('nama')) {
                            var resultInput = document.getElementById('nama');
                            nama = dataktp[key];
                            resultInput.value = nama;
                        }
                        if (key.toLowerCase().includes('tempat')) {
                            var resultInput = document.getElementById('tempat');
                            tempat = dataktp[key].split(',')[0];
                            resultInput.value = tempat;
                        }
                        if (key.toLowerCase().includes('tgl lahir')) {
                            var inputString = dataktp[key].split(',')[1].trim();

                            // Split the string into day, month, and year
                            var dateComponents = inputString.split('-');

                            // Rearrange the components to form the yyyy-MM-dd format
                            tanggal_lahir = dateComponents[2] + "-" + dateComponents[1] + "-" +
                                dateComponents[0];
                            var resultInput = document.getElementById('tanggal_lahir');
                            resultInput.value = tanggal_lahir;
                        }
                        if (key.toLowerCase().includes('alamat')) {
                            var resultInput = document.getElementById('alamat');
                            alamat = dataktp[key];
                            resultInput.value = alamat;
                        }
                    }
                    // var ptkpOption = document.getElementById('ptkp');
                    // for (var key in ptkpoptions) {
                    //     var optionElement = document.createElement("Option");
                    //     optionElement.text = key;
                    //     optionElement.value = ptkpoptions[key];
                    //     console.log(optionElement);
                    //     ptkpOption.appendChild(optionElement);
                    // }

                    // var companyOption = document.getElementById('company');
                    // for (var key in companyOptions) {
                    //     var optionElement = document.createElement("Option");
                    //     optionElement.text = companyOptions[key];
                    //     optionElement.value = key;
                    //     console.log(optionElement);
                    //     companyOption.appendChild(optionElement);
                    // }

                }

                // Displaying the generated HTML
                generateDataKTP(jsonData);

            } catch (error) {
                console.error('Error:', error);
            }

        });
    </script>
@endsection
@endsection
@endsection
