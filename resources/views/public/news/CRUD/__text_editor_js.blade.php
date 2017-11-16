{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
<script>
    $.getScript("{{asset('js/textarea-editor/froala_editor.js')}}", function () {
        $( "#froala-editor" ).froalaEditor({
            // Set the image upload parameter.
            imageUploadParam: 'image',

            // Set the image upload URL.
            imageUploadURL: '/api/ajax/upload_image',

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