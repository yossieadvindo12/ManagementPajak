@extends('layout.main')

{{-- @section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item active">Employee>AddEmployee</li>
    </ol>
@endsection --}}
@section('wrapper')
@section('content-wrapper')
@section('content')
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-sm-8 mx-auto">
                <div class="jumbotron">
                    <h1 class="display-4">Read Text from Images</h1>
                    <p class="lead">


                        <?php if ($_POST) : ?>
                        <pre>
                                    <?= $fileRead ?>
                                </pre>
                        <?php endif; ?>


                    </p>
                    <hr class="my-4">
                </div>
            </div>
        </div>
        <div class="row col-sm-8 mx-auto">
            <div class="card mt-5">
                <div class="card-body">


                    <form id="ocrForm" action="/extract-text" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="image" name="image">
                        <button type="submit">Upload & OCR</button>
                    </form>
                    <div id="ocrResult"></div>





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
    
                // Menampilkan data JSON di halaman
                document.getElementById('ocrResult').innerHTML = `<pre>${JSON.stringify(jsonData, null, 2)}</pre>`;
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>
@endsection
@endsection
@endsection
