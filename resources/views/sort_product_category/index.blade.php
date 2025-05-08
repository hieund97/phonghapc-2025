@extends('layouts.app')

@section('page-title', __('Sắp xếp danh mục'))

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" class="card-outline-tabs">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="setting-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tabs-home-tab" data-toggle="pill"
                                           href="#tabs-home" role="tab" aria-controls="tabs-home"
                                           aria-selected="false">{{ __('Sort Home Category') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-feature-tab" data-toggle="pill"
                                           href="#tabs-feature" role="tab" aria-controls="tabs-feature"
                                           aria-selected="true">{{ __('Sort Feature Category') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-build-pc-tab" data-toggle="pill"
                                           href="#tabs-build-pc" role="tab" aria-controls="tabs-build-pc"
                                           aria-selected="false">{{ __('Sort Build PC Category') }}</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="tab-content" id="tabs-content-feature">
                                    {{--Home--}}
                                    <div class="tab-pane fade show active" id="tabs-home" role="tabpanel"
                                         aria-labelledby="tabs-home-tab">
                                        @include('sort_product_category.elements.list', ['categories' => $cateHome, 'flag' => 2])
                                    </div>
                                    {{--End Home--}}

                                    {{--Feature--}}
                                    <div class="tab-pane fade" id="tabs-feature" role="tabpanel"
                                         aria-labelledby="tabs-feature-tab">
                                        @include('sort_product_category.elements.list', ['categories' => $cateFeature, 'flag' => 1])
                                    </div>
                                    {{--End Feature--}}

                                    {{--Build PC--}}
                                    <div class="tab-pane fade" id="tabs-build-pc" role="tabpanel"
                                         aria-labelledby="tabs-build-pc-tab">
                                        @include('sort_product_category.elements.list', ['categories' => $cateBuildPC, 'flag' =>3])
                                    </div>
                                    {{--End Build PC--}}
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('scripts')
    @include('partials.js.rv_media',['buttonMoreImages'=>[]])
    @include('partials.editors.summernote',['editors'=>['popup','post_description'],'buttons'=>[],'realButtons'=>[]])
    @include('partials.editors.summernote',['editors'=>['popup','policy_sell_product'],'buttons'=>[],'realButtons'=>[]])
    @include('partials.editors.summernote',['editors'=>['popup','policy_exchange'],'buttons'=>[],'realButtons'=>[]])

    <script>
        var page = 1;
        $(document).ready(function () {
            $('.quick-update').change(function () {
                var type = $(this).data('type')
                var id = $(this).data('id')
                var value = $(this).val()
                var ordering;
                switch (type) {
                    case 1:
                        dataOrder = {
                            _token  : '{{ csrf_token() }}',
                            value   : value,
                            id      : id,
                            ordering: 'ordering_menu_top',
                        };
                        break
                    case 2:
                        dataOrder = {
                            _token  : '{{ csrf_token() }}',
                            value   : value,
                            id      : id,
                            ordering: 'ordering_menu_home',
                        };
                        break
                    case 3:
                        dataOrder = {
                            _token  : '{{ csrf_token() }}',
                            value   : value,
                            id      : id,
                            ordering: 'ordering_menu_build',
                        };
                        break
                }
                $.ajax({
                    url    : "{{route('update.sort.category')}}",
                    type   : 'POST',
                    data   : dataOrder,
                    success: function (data) {
                        if (data.status == 1) {
                            Toast.fire({
                                type : 'success',
                                title: '{{__('Update data successfully.')}}',
                            })
                        } else {
                            Toast.fire({
                                type : 'error',
                                title: '{{__('Update error data.')}}',
                            })
                        }
                        removeOverlay()
                    },
                })
            })

            $('.show-product-btn').on('click', function () {
                page = 1;
                var id = $(this).data('id');

                if ($(this).attr('aria-expanded') === "false") {
                    ajaxCall(id, page)
                } else {
                    $('#btn-show-more-' + id).addClass('hidden')
                }
            })
        })

        $(document).on('change', '.quick-update-product', function () {
            var type = $(this).data('type')
            var product_id = $(this).data('id')

            if (type == 'ordering_in_cate') {
                var value = $(this).val()
            } else {
                var value = $(this).is(':checked') ? 1 : 0
            }
            $.ajax({
                url    : "{{route('update.sort.product')}}",
                type   : 'POST',
                data   : ({
                    _token: '{{ csrf_token() }}',
                    type  : type,
                    value : value,
                    id    : product_id,
                }),
                success: function (data) {
                    if (data.status == 1) {
                        Toast.fire({
                            type : 'success',
                            title: '{{__('Update data successfully.')}}',
                        })
                    } else {
                        Toast.fire({
                            type : 'error',
                            title: '{{__('Update error data.')}}',
                        })
                    }
                    removeOverlay()
                },
            })
        })

        $(document).on('click', '.btn-show-more', function () {
            var id = $(this).data('id');
            page += 1;

            ajaxCall(id, page)
        })

        function ajaxCall(id, page) {
            $.ajax({
                url    : '/cp_admin/get-product-by-cate-id?id=' + id + '&page=' + page,
                type   : 'GET',
                success: function (response) {

                    if (response.isShowMore) {
                        $('#btn-show-more-' + id).removeClass('hidden')
                    } else {
                        $('#btn-show-more-' + id).addClass('hidden')
                    }

                    if (page == 1) {
                        $('#category-' + id).html(response.htmlView)
                    } else {
                        $('#category-' + id).append(response.htmlView)
                    }
                },
            })
        }
    </script>
@endpush
