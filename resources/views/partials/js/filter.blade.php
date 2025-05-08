@push('scripts')
    <script>
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2').select2();

            // Id filter
            var element = '#filter-box';
            // Ẩn hiện form tìm kiếm
            $("#btn_filter").click(function(){          
                if($(element).is(":hidden")){
                    $(element).show();
                } else {
                    $(element).hide();
                }      
            });
            $("#btn_reset").click(function(){   
            });
            //Chọn ngày tháng
            $('#reservation').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
            $('#reservation').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            // Check rquest empty
            @if(!empty($requestAll) && count($requestAll) > 0)
                $(element).show();
            @else
                $(element).hide();
            @endif
        });
    </script>
@endpush