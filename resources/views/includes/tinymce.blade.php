<script src="{{ asset('third_party/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        branding: false,
        height: 400,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table directionality',
            'emoticons template paste textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons',
        toolbar2: '',
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        // without images_upload_url set, Upload tab won't show up
        images_upload_url: './storage/app/public/images/',

        // we override default upload handler to simulate successful upload
        images_upload_handler: function (blobInfo, success, failure) {
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "/file",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 60000,
                success: function (response) {
                    console.log(response);
                    if(response.file_uploaded === true){
                        success(response.location);
                    } else {
                        failure(response);
                    }
                    return;
                },
                error: function (e) {
                    failure(e.responseText);
                    return;
                }
            });
        }
    });
</script>
<textarea id="{{ $id ?? 'tinymce-field' }}" name="{{ $name ?? 'body' }}">{{ $content ?? $body ?? '' }}</textarea>