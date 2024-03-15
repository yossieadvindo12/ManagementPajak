@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="m-4">
        <h1 class="text-center">Data Perusahaan</h1>
        <button type="button" class=" mb-4 btn btn-success"><a class="text-decoration-none text-light" href="/addCompany">Tambah +</a></button>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Perusahaan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataPerusahaan as $item)
                        
                    <tr>
                        <th scope="row">{{ $item->id_company }}</th>
                        <td>{{ $item->name_company }}</td>
                        
                        <td>
                            <button type="button" class="btn btn-warning">
                                <a class="text-decoration-none text-light" href="{{ route('company.edit', $item->id_company) }}">Edit</a>
                            </button>
                            {{-- <form method="POST" action="{{ route('company.destroy', ['id_company' => $item->id_company]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" >Delete</button>
                            </form> --}}
                            {{-- <button type="sumbit" class="btn btn-danger">
                                <a class="text-decoration-none text-light" href="{{ route('company.destroy', ['id_company' => $item->id_company]) }}">Delete</a>
                            </button> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if ($message = Session::get('success'))
        <script>
            Swal.fire('{{ $message }}');
        </script>
    @endif
@endsection
@endsection
@endsection
