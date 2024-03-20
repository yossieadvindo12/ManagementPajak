@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="container">
        
        <a class=" text-body text-decoration-none" href="/employee"><i class=" fas fa-solid fa-arrow-left"></i></a>
    </div>
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Edit Data Karyawan!</h1>
        </div>
        @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <form class="user" action="{{ route('employee.update', $dataEmployee->nik) }}" method="post">
        @csrf
        @method('PUT')
        {{-- <div class="form-group">
            <input type="text" name="nik" class="form-control form-control-user"
                placeholder="NIK" value="{{ $dataEmployee->nik }}">
        </div>
        @error('nik')
            <small>{{ $message }}</small>
        @enderror --}}

        <div class="form-group">
            <label><strong>Nama Karyawan</strong></label>
            <input type="text" name="nama" class="form-control form-control-user"
                placeholder="Nama" value="{{ $dataEmployee->nama }}">

        </div>
        @error('name_employee')
            <small>{{ $message }}</small>
        @enderror

        <div class="form-group">
            <label><strong>Tempat Lahir</strong></label>
            <input type="text" name="tempat" class="form-control form-control-user"
                placeholder="Tempat Lahir" value="{{ $dataEmployee->tempat }}">

        </div>
        @error('tempat')
            <small>{{ $message }}</small>
        @enderror

        <div class="form-group">
            <label><strong>Tanggal Lahir</strong></label>
            <input type="text" name="tanggal_lahir" class="form-control form-control-user"
                placeholder="Tanggal Lahir" value="{{ $dataEmployee->tanggal_lahir }}">

        </div>
        @error('tanggal_lahir')
            <small>{{ $message }}</small>
        @enderror

        <div class="form-group">
            <label><strong>Alamat</strong></label>
            <input type="text" name="alamat" class="form-control form-control-user"
                placeholder="Tanggal Lahir" value="{{ $dataEmployee->alamat }}">

        </div>
        @error('alamat')
            <small>{{ $message }}</small>
        @enderror

        <div class="form-group">
            <label><strong>Jenis Kelamin</strong></label>
            <select class="form-control" name = "jenis_kelamin" value="{{ $dataEmployee->jenis_kelamin }}">
                <option value="">Pilih Jenis Kelamin</option>
                @if($dataEmployee->jenis_kelamin === "laki-laki"){
                    <option value = "laki-laki" selected > LAKI - LAKI </option>
                    <option value = "perempuan"> PEREMPUAN </option>
                }@elseif($dataEmployee->jenis_kelamin == "perempuan"){
                    <option value = "laki-laki"> LAKI - LAKI </option>
                    <option value = "perempuan" selected> PEREMPUAN </option>
                }
                @endif
            </select>
        </div>

        <div class="form-group">
            <label><strong>Status Karyawan</strong></label>
            <select class="form-control" name = "kode_karyawan" value="{{ $dataEmployee->kode_karyawan }}">
                <option value="">Pilih Status</option>
                @if($dataEmployee->kode_karyawan === "karyawan"){
                    <option value = "karyawan" selected> Karyawan </option>
                    <option value = "tukang"> Tukang </option>
                }@elseif($dataEmployee->kode_karyawan !== "karyawan"){
                    <option value = "karyawan" > Karyawan </option>
                    <option value = "tukang" selected> Tukang </option>
                }
                @endif
            </select>
        </div>

        <div class="form-group">
            <label><strong>Status PTKP</strong></label>
            <select id="ptkp" class="form-control" name = "status_PTKP">
                <option value="">Pilih Status PTKP</option>
                @foreach ($dataPtkp as $item)
                    @if($item->ptkp === $dataEmployee->status_PTKP){
                        <option value="{{ $item->ptkp }}" selected>{{ $item->ptkp }}</option>
                    }@elseif($item->ptkp !== $dataEmployee->status_PTKP){
                        <option value="{{ $item->ptkp }}">{{ $item->ptkp }}</option>
                    }
                    @endif
                    {{-- <option value="{{ $item->id_company }}" selected>{{ $dataEmployee->id_company }}</option> --}}
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label><strong>Perusahaan</strong></label>
            <select id="company" class="form-control" name = "id_company">
                <option value="">Pilih Perusahaan</option>
                @foreach ($dataPerusahaan as $item)
                    @if($item->id_company === $dataEmployee->id_company){
                        <option value="{{ $item->id_company }}" selected>{{ $item->name_company }}</option>
                    }@elseif($item->id_company !== $dataEmployee->id_company){
                        <option value="{{ $item->id_company }}">{{ $item->name_company }}</option>
                    }
                    @endif
                    {{-- <option value="{{ $item->id_company }}" selected>{{ $dataEmployee->id_company }}</option> --}}
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label><strong>Gaji Pokok</strong></label>
            <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok',$dataEmployee->gaji_pokok? $dataEmployee->gaji_pokok :0) }}"
                class="form-control form-control-user" placeholder="gaji pokok" />
        </div>
        @error('salary')
            <small>{{ $message }}</small>
        @enderror
        
        <div class="form-group">
            <label><strong>Tunjangan SC</strong></label>
            <input type="number" id="sc" name="sc" value="{{ old('sc',$dataEmployee->sc? $dataEmployee->sc :0) }}"
                class="form-control form-control-user" placeholder="Tunjangan SC" />
        </div>
        @error('salary')
        <small>{{ $message }}</small>
        @enderror
        
        <div class="form-group">
            <label><strong>Tunjangan Natura</strong></label>
            <input type="number" id="natura" name="natura" value="{{ old('natura',$dataEmployee->natura? $dataEmployee->natura :0) }}"
                class="form-control form-control-user" placeholder="Tunjangan Natura" />
        </div>
        @error('natura')
        <small>{{ $message }}</small>
        @enderror

        <div class="form-group">
            <label><strong>BPJS KESEHATAN</strong></label>
            <input type="number" id="bpjs_kesehatan" name="bpjs_kesehatan" value="{{ old('bpjs_kesehatan',$dataEmployee->bpjs_kesehatan? $dataEmployee->bpjs_kesehatan :0) }}"
                class="form-control form-control-user" placeholder="BPJS KESEHATAN" />
        </div>
        @error('bpjs_kesehatan')
            <small>{{ $message }}</small>
        @enderror


        <button type="submit" class="btn btn-primary btn-user btn-block">
            Update</button>

    </form>
    </div>
@endsection
@endsection
@endsection
