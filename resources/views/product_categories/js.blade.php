@push('scripts')
    <script>
        function showFormAdd(categoryId,isFocus) {
            $.ajax({
                url: "{{route('product_categories.create')}}",
                type: "GET",
                success: function(resp){
                    $('#category_info').html(resp);
                    if(isFocus==1){
                        $('#category_submit').focus();
                    }
                }
            });
        }
        function showFormEdit(url) {
            $.ajax({
                url: url,
                type: "GET",
                success: function(resp){
                    $('#category_info').html(resp);
                    $('#category_submit').focus();
                }
            });
        }
        function deleteCate(url) {
                Swal.fire({
                title: '{{ __('Are you sure?') }}',
                text: "{!! __("You won't be able to revert this!") !!}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dd3333',
                confirmButtonText: '{{ __('Yes, delete it!') }}',
                cancelButtonText: '{{ __('Cancel') }}',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(result) {
                            var parent_id = result.parentId;
                            var level     = result.level;
                            Swal.fire('{{ __('Deleted!') }}', '{{ __('Your file has been deleted.') }}', 'success').
                                then((result) => {
                                    if(level==1){
                                        window.location.reload();
                                    } else {
                                        loadSubCate(parent_id,level-1);
                                    }
                                });
                        }, error: function(error) {
                            console.log(error);
                            Swal.fire('{{ __('Error!') }}', '{{ __('An error occurred, please try again later!') }}',
                                'error');
                        },
                    });
                }
            });
        }
        function loadSubCate(id,level) {
            showFormAdd(0,0);
            //an cac box ko can load
            var total = $('.itemt').length;
            for(var i=level+1;i<=total;i++) {
                $('#itemt'+i+'').remove();
            }
            //active khi click
            $('#list_cate'+level+'').find('li').each(function(){
                if($(this).attr('rel')==id)
                    $(this).find('a:first').removeClass().addClass('active');
                else
                    $(this).find('a:first').removeClass('active');
            });
            $.ajax({
                url: "{{route('product_categories.load_sub_cate')}}",
                type: "GET",
                data:({
                    id:id,
                    level:level
                }),
                success: function(data){
                    if(data){
                        $('#list_cate').append(data);
                    }
                    //showFormEdit(cid);
                }
            });
            $('#level'+level+'').find('li').children().removeClass('active');
        }

        function saveOrder(level,type) {
            showOverlay('.card');
            var listCategories = [];
            $('#list_cate'+level+'').find('li').each(function(i){
                var parent_id = $(this).parents().first().closest('li').attr('rel');
                var id = $(this).attr('rel')
                if( typeof parent_id === 'undefined' || parent_id === null ){
                    parent_id = 0;
                }
                listCategories[i] = [id, parent_id];
            });
            if(listCategories.length>0) {
                $.ajax({
                    url: "{{route('product_categories.save_order_cate')}}",
                    type: "POST",
                    data:({
                        type:type,
                        list_categories:listCategories
                    }),
                    success: function(data){
                        if(data.status == 1) {
                            Toast.fire({
                                type: 'success',
                                title: '{{__('Update data successfully.')}}'
                            });
                        }
                        else {
                            Toast.fire({
                                type: 'error',
                                title: '{{__('Update error data.')}}'
                            });
                        }
                        removeOverlay();
                    }
                });
            }
        }
        // Menu
        var oldContainer;
        $("ol.nested_with_switch").sortable({
            group: 'nested',
            afterMove: function (placeholder, container) {
            if(oldContainer != container){
                if(oldContainer)
                oldContainer.el.removeClass("active");
                container.el.addClass("active");

                oldContainer = container;
            }
            },
            onDrop: function ($item, container, _super) {
            container.el.removeClass("active");
            _super($item, container);
            }
        });

    </script>
@endpush
