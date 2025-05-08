@push('scripts')
    <script>
        $( document ).ready(function() {
            $('#model').change(function() {
                $.ajax({
                    url: "{{ route('text_links.get_category') }}",
                    type: 'GET',
                    data: {'model': $(this).val()},
                    success: function (result) {
                        var html ='<option value=""></option>';
                        html += result;
                        $('#model_id').html(html);
                    },
                    error: function () {
                        alert('Có lỗi xảy ra, vui lòng tải lại trang.');
                    },
                });
             });
        });
       
    </script>
@endpush  