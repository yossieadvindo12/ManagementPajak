@extends('layout.main')

@section('wrapper')
@section('content-wrapper')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item active">Employee>AddEmployee</li>
    </ol>
@endsection
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
@endsection
@endsection
@endsection
