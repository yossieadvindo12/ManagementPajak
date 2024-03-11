@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="container">
        
        <a class=" text-body text-decoration-none" href="/company"><i class=" fas fa-solid fa-arrow-left"></i></a>
    </div>
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Tambahkan Data Perusahaan!</h1>
        </div>
        @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <form class="user" action="{{ route('company.update', $dataCompany->id_company) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <input type="text" name="name_company" class="form-control form-control-user"
                placeholder="Nama Perusahaan" value="{{ $dataCompany->name_company }}">

        </div>
        @error('name_company')
            <small>{{ $message }}</small>
        @enderror
        
        <button type="submit" class="btn btn-primary btn-user btn-block">
            update</button>

    </form>
    </div>
@endsection
@endsection
@endsection
