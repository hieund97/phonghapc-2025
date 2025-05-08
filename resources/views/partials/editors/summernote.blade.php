
<script>
    $(document).ready(function(){
            // Initialize summernote with LFM button in the popover button group
            // Please note that you can add this button to any other button group you'd like
            @if(config('admin.editor')==0)
                @foreach($editors as $editor)
                    $('#{{$editor}}').summernote({
                        height: {{ $height ?? 500 }},
                        dialogsInBody: true,
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['fontname', ['fontname']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['undo',['undo']],
                            ['redo',['redo']],
                            ['table',['table']],
                            ['popovers', ['lfm']],
                            ['insert', ['link', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']]
                        ]
                    });
                @endforeach
            @else
                @foreach($editors as $editor)
                    if ( typeof CKEDITOR !== 'undefined' ) {
                        CKEDITOR.disableAutoInline = true;
                        CKEDITOR.addCss( 'img {max-width:100%; height: auto;}' );
                        var editor = CKEDITOR.replace( '{{$editor}}', {
                            
                            filebrowserImageBrowseUrl: RV_MEDIA_URL.base + "?media-action=select-files&method=ckeditor&type=image",
                            filebrowserImageUploadUrl: RV_MEDIA_URL.media_upload_from_editor + "?method=ckeditor&type=image&_token=" + $('meta[name="csrf-token"]').attr("content"),
                            filebrowserWindowWidth: "1200",
                            filebrowserWindowHeight: "750",
                            height: 90 * $("#{{$editor}}").prop("rows"),
                            allowedContent: !0
                        } );
                    } ;
                @endforeach
            @endif
        });
</script>

