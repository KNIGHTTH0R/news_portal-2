@extends('admin.layouts.app')
@section('pageTitle', 'Новая статья')
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_style.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-8 mar-auto">
                @if (session('flash_message_error'))
                    <div class="alert alert-danger" role="alert" id="alert">{{ session('flash_message_error') }}</div>
                @endif
                    {!! Form::open(['action' => 'Admin\NewsController@store', 'method' => 'post', 'files' => true]) !!}
                        @include('admin.news.__form', ['submitButton' => 'Создать'])
                    {!! Form::close() !!}

            </div>
        </div>
    </div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
    <script>
        $.getScript("{{asset('js/textarea-editor/froala_editor.js')}}", function () {
            $( "#froala-editor" ).froalaEditor({
                // Set the image upload parameter.
                imageUploadParam: 'image',

                // Set the image upload URL.
                imageUploadURL: '/upload_image',

                // Additional upload params.
                imageUploadParams: {
//                    id: 'my_editor',
                    _token:'{{csrf_token()}}'
                },

                // Set request type.
                imageUploadMethod: 'POST',

                // Set max image size to 5MB.
                imageMaxSize: 5 * 1024 * 1024,

                // Allow to upload PNG and JPG.
                imageAllowedTypes: ['jpeg', 'jpg', 'png']
            })
                .on('froalaEditor.image.beforeUpload', function (e, editor, images) {
                    // Return false if you want to stop the image upload.
                })
                .on('froalaEditor.image.uploaded', function (e, editor, response) {
                    // Image was uploaded to the server.
                })
                .on('froalaEditor.image.inserted', function (e, editor, $img, response) {
                    // Image was inserted in the editor.
                })
                .on('froalaEditor.image.replaced', function (e, editor, $img, response) {
                    // Image was replaced in the editor.
                })
                .on('froalaEditor.image.error', function (e, editor, error, response) {
                    // Bad link.
                    if (error.code == 1) {  }

                    // No link in upload response.
                    else if (error.code == 2) {  }

                    // Error during image upload.
                    else if (error.code == 3) {  }

                    // Parsing response failed.
                    else if (error.code == 4) {  }

                    // Image too text-large.
                    else if (error.code == 5) {  }

                    // Invalid image type.
                    else if (error.code == 6) {  }

                    // Image can be uploaded only to same domain in IE 8 and IE 9.
                    else if (error.code == 7) {  }

                    // Response contains the original server response to the request if available.
                });


            document.getElementsByClassName('fr-wrapper')[0].style.minHeight = "500px";
//            console.log(document.getElementsByClassName('fr-wrapper')[0].style.minHeight = "500px")

        });





    </script>

@endsection
