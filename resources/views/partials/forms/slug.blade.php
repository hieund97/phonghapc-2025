
    @push('scripts')
    <script>
        function convertToSlug(title,toEl, dash = '-') {
            let slug;

           var slugTemp ='';
           $.post( '{{ route('ajax.slug') }}', { title: title })
                .done(function( data ) {
                    $(toEl).val(data);
            });
            return ;

            //Đổi chữ hoa thành chữ thường
            slug = title.toLowerCase();

            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');

            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');

            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, dash);

            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, dash);
            slug = slug.replace(/\-\-\-\-/gi, dash);
            slug = slug.replace(/\-\-\-/gi, dash);
            slug = slug.replace(/\-\-/gi, dash);

            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');

            return slug;
        }

        function ChangeToSlug(fromEl, toEl,dash='-')
        {
            //$(toEl).val(convertToSlug($(fromEl).val(),toEl, dash));
            convertToSlug($(fromEl).val(),toEl, dash);
        }

        @if(!empty($fromElement) && !empty($toElement))
            {{--if (!$('{{ $toElement }}').val()) {--}}
                $('{{ $fromElement }}').on('change', function () {
                    ChangeToSlug('{{ $fromElement }}', '{{ $toElement }}');
                });
            // }
        @endif
    </script>
@endpush
