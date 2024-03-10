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

                function generateHTML(data) {
                    var html = '<form>';
                    // html +='<input type="text" value="'+data[1]+'" /><br>';
                    for (var key in data) {
                        // if (key.toLowerCase().includes('nik')) {
                            html += '<li><strong>' + key + ':</strong> ' + data[key] + '</li>';
                        // }
                    }
                    html += '</form>';
                    return html;
                }

                // Displaying the generated HTML
                document.getElementById('ocrResult').innerHTML = generateHTML(jsonData);
                // Menampilkan data JSON di halaman
                // document.getElementById('ocrResult').innerHTML =
                //     `<pre>${JSON.stringify(jsonData, null, 2)}</pre>`;
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>
@endsection
@endsection
@endsection
