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


                    <form id="ocrForm" class="d-flex justify-content-between" action="/extract-text" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-3">
                            <input type="file" id="image" name="image">
                        </div>
                        <button class="btn btn-success mt-3" type="submit" name="submit">Upload & OCR</button>
                    </form>
                    <div class=" mt-5" id="ocrResult"></div>





                </div>
            </div>
        </div>
    </div>

    <script>
        // Menangkap respon dari form submission menggunakan JavaScript
        document.querySelector('form').addEventListener('submit', async function(event) {
            event.preventDefault();

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
                    const pktpoptions = data.ptkpOptions;
                    const companyOptions = data.companyOptions;
                    console.log(dataktp);
                    var html = '<form class="user" action="/storeEmployee" method="post">';
                    html += '@csrf'
                    // html +='<input type="text" value="'+data[1]+'" /><br>';
                    var nik, nama, tempat, tanggal_lahir, alamat;
                    for (var key in dataktp) {
                        if (key.toLowerCase().includes('nik')) {
                            nik = dataktp[key];
                        }
                        if (key.toLowerCase().includes('nama')) {
                            nama = dataktp[key];
                        }
                        if (key.toLowerCase().includes('tempat')) {
                            tempat = dataktp[key].split(',')[0];
                        }
                        if (key.toLowerCase().includes('tgl lahir')) {
                            var inputString = dataktp[key].split(',')[1].trim();

                            // Split the string into day, month, and year
                            var dateComponents = inputString.split('-');

                            // Rearrange the components to form the yyyy-MM-dd format
                            tanggal_lahir = dateComponents[2] + "-" + dateComponents[1] + "-" +
                                dateComponents[0];
                        }
                        if (key.toLowerCase().includes('alamat')) {
                            alamat = dataktp[key];
                        }
                        console.log(tanggal_lahir);
                    }
                    if (nik) {
                        html += '<div class="form-group">';
                        html += '<label><strong>NIK</strong></label>';
                        html += '<input type="text" name="nik" value="' + nik +
                            '" class="form-control form-control-user" />';
                        html += '</div>';
                        html += '@error('+"nik"+')<small>{{ $message }}</small>@enderror'
                    } else {
                        html += '<div class="form-group">';
                        html += '<label><strong>NIK</strong></label>';
                        html +=
                            '<input type="text" name="nik" value="{{ old('nik') }}" class="form-control form-control-user" placeholder="NIK"  />';
                        html += '</div>';
                        html += '@error('+"nik"+')<small>{{ $message }}</small>@enderror'
                    }
                    if (nama) {
                        html += '<div class="form-group">';
                        html += '<label><strong>Nama</strong></label>';
                        html += '<input type="text" name="nama" value="' + nama +
                            '" class="form-control form-control-user" />';
                        html += '</div>';
                        html += '@error('+"nama"+')<small>{{ $message }}</small>@enderror';
                    } else {
                        html += '<div class="form-group">';
                        html += '<label><strong>Nama</strong></label>';
                        html +=
                            '<input type="text" name="nama" value="{{ old('nama') }}" class="form-control form-control-user" placeholder="NAMA"  />';
                        html += '</div>';
                        html += '@error('+"nama"+')<small>{{ $message }}</small>@enderror';
                    }
                    if (tempat) {
                        html += '<div class="form-group">';
                        html += '<label><strong>Tempat Lahir</strong></label>';
                        html += '<input type="text"  name="tempat" value="' + tempat +
                            '" class="form-control form-control-user" />';
                        html += '</div>';
                        html += '@error('+"tempat"+')<small>{{ $message }}</small>@enderror';
                    } else {
                        html += '<div class="form-group">';
                        html += '<label><strong>Tempat Lahir</strong></label>';
                        html +=
                            '<input type="text" name="tempat" value="{{ old('tempat') }}" class="form-control form-control-user" placeholder="Tempat Lahir"  />';
                        html += '</div>';
                        html += '@error('+"tempat"+')<small>{{ $message }}</small>@enderror';
                    }
                    if (tanggal_lahir) {
                        html += '<div class="form-group">';
                        html += '<label><strong>Tgl Lahir</strong></label>';
                        html += '<input type="date"  name="tanggal_lahir" value="' + tanggal_lahir +
                            '" class="form-control form-control-user" />';
                        html += '</div>';
                        html += '@error('+"tanggal_lahir"+')<small>{{ $message }}</small>@enderror';
                    }else {
                        html += '<div class="form-group">';
                        html += '<label><strong>Tgl Lahir</strong></label>';
                        html +=
                            '<input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control form-control-user" placeholder="Tgl Lahir"  />';
                        html += '</div>';
                        html += '@error('+"tanggal_lahir"+')<small>{{ $message }}</small>@enderror';
                    }
                    if (alamat) {
                        html += '<div class="form-group">';
                        html += '<label><strong>Alamat</strong></label>';
                        html += '<input type="text"  name="alamat" value="' + alamat +
                            '" class="form-control form-control-user" />';
                        html += '</div>';
                        html += '@error('+"alamat"+')<small>{{ $message }}</small>@enderror';
                    }else {
                        html += '<div class="form-group">';
                        html += '<label><strong>Alamat</strong></label>';
                        html +=
                            '<input type="text" name="alamat" value="{{ old('alamat') }}" class="form-control form-control-user" placeholder="Alamat"  />';
                        html += '</div>';
                        html += '@error('+"alamat"+')<small>{{ $message }}</small>@enderror';
                    }



                    // jeniskelamin
                    html += '<div class="form-group">';
                    html += '<label><strong>Jenis Kelamin</strong></label>';
                    html += '<select class="form-control" name = "jenis_kelamin" >';
                    html += '<option value = "laki-laki" > LAKI - LAKI </option> ';
                    html += '<option value = "perempuan" > PEREMPUAN </option> ';
                    html += '</select>';
                    html += '</div>';

                    html += '<div class="form-group">';
                    html += '<label><strong>Status Ptkp</strong></label>';
                    html += '<select class="form-control" name = "status_ptkp" >';
                    for (var key in pktpoptions) {
                        html += '<option value = "' + key + '" > ' + key +
                            '</option> ';
                    }
                    html += '</select>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label><strong>Perusahaan</strong></label>';
                    html += '<select class="form-control" name = "id_company" >';
                    for (var key in companyOptions) {
                        html += '<option value = "' + key + '" > ' + companyOptions[key] +
                            '</option> ';
                    }
                    html += '</select>';
                    html += '</div>';
                    html += '<button type="submit" class="btn btn-primary btn-user btn-block">Tambah</button>';
                    html += '</form>';
                    return html;
                }

                // Displaying the generated HTML
                document.getElementById('ocrResult').innerHTML = generateDataKTP(jsonData);

            } catch (error) {
                console.error('Error:', error);
            }

        });
    </script>
@endsection
@endsection
@endsection
