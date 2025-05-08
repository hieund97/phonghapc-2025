@push('footer')
    @include('media::partials.media')
@endpush
@if(empty($disablePush))
    @push('scripts')
@endif
<script>
    "use strict";
    $(document).ready(function () {
        var initSortable = function (data_item,data_gallery) {
            let el = document.getElementById(data_item);
            $("#"+data_item).sortable( {
                stop: function(evt, ui) {
                    updateItems(data_item,data_gallery);
                }
            });
        };
        var updateItems = function (data_list,data_gallery) {
            let items = [];
            $.each($('#'+data_list+' .photo-gallery-item'), (index, widget) => {
                //$(widget).data('id', index);
                items.push({url: $(widget).data('img'), title: $(widget).data('description'), media_file_id: $(widget).data('file-id'), sort: $(widget).data('sort'), link: $(widget).data('link')});
            });
            $('#'+data_gallery).val(JSON.stringify(items));
        };

        var edit_gallery_modal = $('#edit-gallery-item');

        edit_gallery_modal.on('click', '#delete-gallery-item', function (event) {
                event.preventDefault();

                edit_gallery_modal.modal('hide');
                var list_photo_gallery = $('#btn-gallery-list').data('id');
                var data_item          = $('#btn-gallery-item').data('id');
                var data_gallery       = $('#btn-gallery-data').data('id');
                $('#'+list_photo_gallery).find('.photo-gallery-item[data-id=' + $(this).data('id') + ']').remove();
                updateItems(data_item,data_gallery);
            });

        edit_gallery_modal.on('click', '#update-gallery-item', function (event) {
            event.preventDefault();
            edit_gallery_modal.modal('hide');
            var list_photo_gallery = $('#btn-gallery-list').data('id');
            var data_item          = $('#btn-gallery-item').data('id');
            var data_gallery       = $('#btn-gallery-data').data('id');
            $('#'+list_photo_gallery).find('.photo-gallery-item[data-id=' + $(this).data('id') + ']').data('description', $('#gallery-item-description').val());
            $('#'+list_photo_gallery).find('.photo-gallery-item[data-id=' + $(this).data('id') + ']').data('sort', $('#gallery-item-sort').val());
            $('#'+list_photo_gallery).find('.photo-gallery-item[data-id=' + $(this).data('id') + ']').data('link', $('#gallery-item-link').val());
            updateItems(data_item,data_gallery);
        });
        @if(!empty($buttonMoreImages))
                @foreach($buttonMoreImages as $button)
                    $('#{{ $button }}').rvMedia({
                        onSelectFiles: function (files) {
                            var data_list    = $('#{{ $button }}').data('list');
                            var data_item    = $('#{{ $button }}').data('item');
                            var data_gallery = $('#{{ $button }}').data('gallery');

                            var last_index = $('.photo-gallery-item:last-child').data('id') + 1;
                            if(isNaN(last_index)){
                                last_index = 0;
                            }
                            $.each(files, function (index, file) {
                                var html = '<div class="col-md-2 col-sm-3 col-4 photo-gallery-item" data-id="' + (last_index + index) + '" data-img="' + file.full_url + '" data-description="" data-sort="0" data-link="" data-file-id="'+file.id+'">';
                                    html +='<div class="gallery_image_wrapper">';
                                    html +='<img src="'+file.thumb+'"/>';
                                    html +='<\//div>';
                                    html +='<\//div>';
                                $('#'+data_list+' .row').append(html);
                            });
                            initSortable(data_item,data_gallery);
                            updateItems(data_list,data_gallery);
                        }
                    });

                    initSortable($('#{{ $button }}').data('item'),$('#{{ $button }}').data('gallery'));

                    $('#'+$('#{{ $button }}').data('list')).on('click', '.photo-gallery-item', function () {
                        var id = $(this).data('id');

                        $('#delete-gallery-item').data('id', id);
                        $('#update-gallery-item').data('id', id);
                        $('#gallery-item-description').val($(this).data('description'));
                        $('#gallery-item-sort').val($(this).data('sort'));
                        $('#gallery-item-link').val($(this).data('link'));
                        $('#btn-gallery-list').data('id', $('#{{ $button }}').data('list'));
                        $('#btn-gallery-item').data('id', $('#{{ $button }}').data('item'));
                        $('#btn-gallery-data').data('id', $('#{{ $button }}').data('gallery'));
                        edit_gallery_modal.modal('show');
                    });


            @endforeach
        @endif
        /* Đây upload ảnh*/


        $(document).find(".btn_gallery").rvMedia({
            multiple: !1,
            onSelectFiles: function(e, t) {
                switch (t.data("action")) {
                case "media-insert-ckeditor":
                    $.each(e, function(e, a) {
                        var n = a.full_url;
                        "youtube" === a.type ? (n = n.replace("watch?v=", "embed/"),
                        CKEDITOR.instances[t.data("result")].insertHtml('<iframe width="420" height="315" src="' + n + '" frameborder="0" allowfullscreen></iframe>')) : "image" === a.type ? CKEDITOR.instances[t.data("result")].insertHtml('<img src="' + n + '" alt="' + a.name + '" />') : CKEDITOR.instances[t.data("result")].insertHtml('<a href="' + n + '">' + a.name + "</a>")
                    });
                    break;
                case "media-insert-tinymce":
                    $.each(e, function(e, t) {
                        var a = t.full_url
                            , n = "";
                        n = "youtube" === t.type ? '<iframe width="420" height="315" src="' + (a = a.replace("watch?v=", "embed/")) + '" frameborder="0" allowfullscreen></iframe>' : "image" === t.type ? '<img src="' + a + '" alt="' + t.name + '" />' : '<a href="' + a + '">' + t.name + "</a>",
                        tinymce.activeEditor.execCommand("mceInsertContent", !1, n)
                    });
                    break;
                case "select-image":
                    var a = _.first(e);
                    t.closest(".image-box").find(".image-data").val(a.full_url),
                    t.closest(".image-box").find(".preview_image_full").attr("src", a.full_url),
                    t.closest(".image-box").find(".preview_image").attr("src", a.thumb),
                    t.closest(".image-box").find(".preview-image-wrapper").show();
                    break;
                case "attachment":
                    var n = _.first(e);
                    t.closest(".attachment-wrapper").find(".attachment-url").val(n.url),
                    $(".attachment-details").html('<a href="' + n.full_url + '" target="_blank">' + n.full_url + "</a>")
                }
            }
        });
        $(document).on("click", ".btn_remove_image", function(e) {
            e.preventDefault(),
            $(e.currentTarget).closest(".image-box").find(".preview-image-wrapper").hide(),
            $(e.currentTarget).closest(".image-box").find(".image-data").val("")
        });
        $(document).on("click", ".btn_remove_attachment", function(e) {
            e.preventDefault(),
            $(e.currentTarget).closest(".attachment-wrapper").find(".attachment-details a").remove(),
            $(e.currentTarget).closest(".attachment-wrapper").find(".attachment-url").val("")
        });
    });

</script>
@if(empty($disablePush))
    @endpush
@endif

