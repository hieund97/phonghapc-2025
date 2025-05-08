<script>
    $(document).ready(function(){
        var district ='';
        var province ='';
        var ward ='';
        $('#province_id').change(function() {
            $.ajax({
                url: "{{ route('locations.district') }}",
                type: 'GET',
                data: {'province_id': $(this).val()},
                cache: false,
                success: function(data){
                    $('#district_id').html(data);
                }
            });
             province = $(this).find('option:selected').text();
            $('.address').val(province);
        });

        $('#district_id').change(function() {
            $.ajax({
                url: "{{ route('locations.ward') }}",
                type: 'GET',
                data: {'district_id': $(this).val()},
                cache: false,
                success: function(data){
                    $('#ward_id').html(data);
                }
            });
            district = $(this).find('option:selected').text();
            $('.address').val(province +','+ district);
        });
        $('#ward_id').change(function() {
            ward = $(this).find('option:selected').text();
            $('.address').val(ward +','+ district +','+province);
        });
    });
</script>
