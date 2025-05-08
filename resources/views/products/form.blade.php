@extends('layouts.app')

@section('page-title', !empty($product) ? __('Edit Product: :name', ['name' => $product->name]) : __('Create Product'))

@section('preview-page')
    @if(!empty($product))
        <li class="nav-item d-none d-sm-inline-block">
            <a
                    target="_blank"
                    href="{{ route('fe.product',["slug"=>$product->slug]) }}"
                    data-toggle="tooltip"
                    class="nav-link"
                    href="xxx"
            >Xem sản phẩm
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a
                    data-toggle="tooltip"
                    title="Copy to Clipboard"
                    class="copy_text nav-link"
                    href="{{ route('fe.product',["slug"=>$product->slug]) }}"
            >Copy link Url
            </a>
        </li>
    @endif
@endsection


@section('content')
    <form
            action="{{ !empty($product) ? route('products.update', ['product' => $product->id]) : route('products.store') }}"
            method="post"
            class="row"
            enctype="multipart/form-data"
            autocomplete="off"
    >
        @csrf
        @if (!empty($product))
            @method('PUT')
        @endif

        <div class="col-md-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="category-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-tabs-info-tab" data-toggle="pill"
                               href="#product-tabs-info" role="tab" aria-controls="product-tabs-info"
                               aria-selected="true">{{ __('Info') }}</a>
                        </li>

                        <!-- Thuộc tính -->
                        <li class="nav-item">
                            <a class="nav-link" id="product-tabs-config-tab" data-toggle="pill"
                               href="#product-tabs-config" role="tab" aria-controls="product-tabs-config"
                               aria-selected="true">{{ __('Config Product') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="product-tabs-content">
                        <div class="tab-pane fade show active" id="product-tabs-info" role="tabpanel"
                             aria-labelledby="product-tabs-info-tab">
                            @include('products.elements.info')
                        </div>

                        <div class="tab-pane fade" id="product-tabs-config" role="tabpanel"
                             aria-labelledby="product-tabs-config-tab">
                            @include('products.elements.config')
                        </div>
                    </div>
                </div>
            </div>



            <div class="card" id="list-attribute">
                <div class="card-header" data-card-widget="collapse">
                    <h3 class="card-title">{{ __('Attribute') }}</h3>(<span class="text-danger">*</span>)
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" id="list-attribute-item">
                    @if(!empty($product))
                        @include('products.elements.attribute', ['arrAttribute' => $arrAttribute, 'selectAttribute' => $selectAttribute, 'product' => $product])
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header" data-card-widget="collapse">
                    <h3 class="card-title">{{ __('Content') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row" id="description-form">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">
                                    {{ __('Description') }} (
                                    <span class="text-danger">*</span>
                                    )
                                </label>
                                <textarea
                                        id="description"
                                        name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        rows="3"
                                        required
                                >{{ old('description') ?: (!empty($product) ? $product->description : '') }}</textarea>

                                @error('description')
                                <span class="error invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="technical_specification">
                                    <span
                                            id="technical_specification_label"
                                    >{{ __('Technical Info') }}</span>
                                </label>
                                <div style="height: 34px;">
                                    <span class="editor-action-item" style="">
                                        <a
                                                href="#" class="btn_gallery btn btn-primary"
                                                data-result="technical_specification"
                                                data-multiple="true" data-action="media-insert-ckeditor"
                                        >
                                            <i class="far fa-image"></i>
                                            Thêm tập tin
                                        </a>
                                    </span>
                                </div>
                                <textarea
                                        id="technical_specification"
                                        name="technical_specification"
                                        class="form-control @error('technical_specification') is-invalid @enderror"
                                        rows="3"
                                    {{--required--}}
                                >{{ old('technical_specification') ?: (!empty($product) ? $product->technical_specification : '') }}</textarea>

                                @error('technical_specification')
                                <span class="error invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="technical_specification">
                                    <span
                                            id="technical_specification_label"
                                    >{{ __('Outstanding features') }}</span>
                                </label>
                                <div style="height: 34px;">
                                    <span class="editor-action-item" style="">
                                        <a
                                                href="#" class="btn_gallery btn btn-primary"
                                                data-result="outstanding_features"
                                                data-multiple="true" data-action="media-insert-ckeditor"
                                        >
                                            <i class="far fa-image"></i>
                                            Thêm tập tin
                                        </a>
                                    </span>
                                </div>
                                <textarea
                                        id="outstanding_features"
                                        name="outstanding_features"
                                        class="form-control @error('outstanding_features') is-invalid @enderror"
                                        rows="3"
                                    {{--required--}}
                                >{{ old('outstanding_features') ?: (!empty($product) ? $product->outstanding_features : '') }}</textarea>

                                @error('technical_specification')
                                <span class="error invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="technical_specification">
                                    <span
                                            id="technical_specification_label"
                                    >{{ __('Gift Product') }}</span>
                                </label>

                                <div style="height: 34px;">
                                    <span class="editor-action-item" style="">
                                        <a
                                                href="#" class="btn_gallery btn btn-primary" data-result="gift_product"
                                                data-multiple="true" data-action="media-insert-ckeditor"
                                        >
                                            <i class="far fa-image"></i>
                                            Thêm tập tin
                                        </a>
                                    </span>
                                </div>
                                <textarea
                                        id="gift_product"
                                        name="gift_product"
                                        class="form-control @error('gift_product') is-invalid @enderror"
                                        rows="3"
                                    {{--required--}}
                                >{{ old('gift_product') ?: (!empty($product) ? $product->gift_product : '') }}</textarea>

                                @error('technical_specification')
                                <span class="error invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    @include('partials.forms.seo', ['model' => !empty($product) ? $product:null])
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Actions') }}</h3>
                </div>

                <div class="card-body">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save fa-fw"></i>
                        {{ __('Save') }}
                    </button>

                    <a href="{{ route('products.index') }}" class="btn btn-danger">
                        <i class="fas fa-ban fa-fw"></i>
                        {{ __('Cancel') }}
                    </a>
                </div>
            </div>

            @if (empty($product) || !$product->is_default)
                <div class="card">
                    <div class="card-header" data-card-widget="collapse">
                        <h3 class="card-title">{{ __('Options') }}</h3>
                        <div class="card-tools">

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input
                                                type="checkbox"
                                                name="show_on_top"
                                                value="1"
                                                id="show_on_top"
                                                @if (old('show_on_top') || (!empty($product) && $product->show_on_top == 1)) checked @endif>
                                        <label for="show_on_top">{{ __('Show on top?') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Category') }}</h3>
                </div>

                @php
                    $selectedCategory = [];
                    if(isset($product)) {
                       $selectedCategory = $product->categories->pluck('id')->toArray();
                    }
                    elseif (!empty(old('product_category_id'))) {
                        $selectedCategory = old('product_category_id');
                    }
                @endphp
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select
                                        class="form-control select2bs4 @error('product_category_id') is-invalid @enderror"
                                        id="product_category_id"
                                        name="product_category_id[]"
                                        required
                                        multiple
                                >
                                    <option value="">{{ __('Select Category') }}</option>
                                    @include('partials.forms.product_category_options', ['disableParents' => true,'selected' => $selectedCategory])
                                </select>

                                @error('product_category_id')
                                <span class="error invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" id="original-select" style="display: none;">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ __('Original Product') }}{{-- (<span class="text-danger">*</span>)--}}
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                if (!empty(old('parent_id'))) {
                                    $parents = [['value' => old('parent_id'), 'label' => 'ID: ' . old('parent_id')]];
                                } elseif (!empty($product) && !empty($product->parent)) {
                                    $parents = [['value' => $product->parent->id, 'label' => $product->parent->name]];
                                }
                            @endphp

                            @include('partials.modals.choose-products', [
                                'label' => __('Original Product'),
                                'name' => 'parent_id',
                                'data' => $parents ?? [],
                                'dataUrl' => route('products.accessories', ['type' => 'all', 'hide_children' => 1]),
                                'required' => true,
                                'single' => true,
                                'hide_label' => true,
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ __('Status') }} (
                        <span class="text-danger">*</span>
                        )
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select
                                        name="status"
                                        id="status"
                                        class="form-control select2bs4 @error('status') is-invalid @enderror"
                                        required
                                >
                                    @foreach(config('admin.product_status') as $status => $label)
                                        <option
                                                value="{{ $status }}"
                                                @if(old('status') == $status || (!empty($product) && $product->status == $status)) selected @endif>
                                            {{ __("products.status.$label") }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('status')
                                <span class="error invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card image-box">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ __('Feature Image') }} (
                        <span class="text-danger">*</span>
                        )
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="preview-image-wrapper img-fluid">
                                    <img
                                            class="preview_image"
                                            src="{{ old('feature_img') ?: (!empty($product->feature_img) ? get_image_url($product->feature_img, '') : '/preview-icon.png') }}"
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <span class="input-group-btn">
                                        <a
                                                href="javascript:void(0)"
                                                data-result="image" data-action="select-image"
                                                class="btn_gallery btn btn-primary text-white"
                                        >
                                            <i class="fa fa-picture-o"></i> {{__('Choose')}}
                                        </a>
                                        <a class="btn_remove_image btn btn-primary text-white"> <i
                                                    class="fa fa-trash-alt"></i></a>
                                    </span>
                                    <input
                                            name="feature_img" type="hidden" maxlength="999"
                                            class="image-data form-control @error('feature_img') is-invalid @enderror"
                                            value="{{ old('feature_img') ?: (!empty($product) ? $product->feature_img : '') }}"
                                    >
                                </div>
                                @error('feature_img')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ __('Warranty') }}
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input
                                        id="warranty"
                                        type="text"
                                        class="form-control @error('warranty') is-invalid @enderror"
                                        name="warranty"
                                        value="{{ old('warranty') ?: (!empty($product) ? $product->warranty : '') }}"
                                >

                                @error('warranty')
                                <span class="error invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" data-card-widget="collapse">
                    <h3 class="card-title">{{ __('Related Product') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                if (!empty(old('similars'))) {
                                    $similars = collect(old('similars'))->map(fn($similar) => ['value' => $similar, 'label' => "ID: $similar"])->toArray();
                                } elseif (!empty($product) && !empty($product->relates)) {
                                    $similars = $product->similars->map(fn($similar) => ['value' => $similar->id, 'label' => $similar->name])->toArray();
                                }
                            @endphp

                            @include('partials.modals.choose-products', [
                                'label' => __('Similar_products'),
                                'name' => 'similars',
                                'data' => $similars ?? [],
                                'dataUrl' => route('products.accessories', ['type' => 'all']),
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-footer">
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@push('footer')
    <div
            class="modal fade" id="featureModal" tabindex="-1" role="dialog" aria-labelledby="featureModalTitle"
            aria-hidden="true"
    >
        <form id="fillFeaturesForm">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="featureModalTitle">{{ __('Quick Fill Features') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fillFeaturesInput"></label>

                            <textarea
                                    id="fillFeaturesInput"
                                    name="fillFeaturesInput" class="form-control"
                                    rows="10" placeholder="Mỗi tính năng là 1 dòng"
                            ></textarea>

                            <span class="form-text">
                                Nhập vào tính năng nổi bật là một dòng
                            </span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endpush
@push('footer')
    @include('partials.modals.edit_gallery_item')
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('theme/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('tokenfield/css/bootstrap-tokenfield.min.css') }}">
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"
    >
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <style>
        .card-header{
            cursor:pointer;
        }

        .card-header .card-title{
            font-weight:bold;
        }

        .gallery_image_wrapper img{
            object-fit:cover;
        }
    </style>
@endpush

@push('scripts')

    @include('partials.js.rv_media',['buttonMoreImages'=>['btn_picture','btn_real_images']])
    @include('partials.editors.summernote',['editors'=>['technical_specification', 'description', 'outstanding_features', 'gift_product'],'buttons'=>[],'realButtons'=>[]])
    @include('partials.forms.slug', ['fromElement' => '#name', 'toElement' => '#slug'])

    <script src="{{ asset('jquery.mask.min.js') }}"></script>
    <script src="{{ asset('tokenfield/bootstrap-tokenfield.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


    <script>

        $(document).ready(function () {
            @if(empty($product))
            $('#list-attribute').hide();
            @endif

            $('input[number-mask]').attr('type', 'text').mask('00,000,000,000', {reverse: true})

            $(document).on("focus", ".currencyMask", function() {
                $(this).mask('00,000,000,000', {
                    reverse: true
                });
            });


            //Chọn ngày tháng
            $('input[name="date_preorder"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput : false
            })
            $('input[name="date_preorder"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY'))
            })

            $('input[name="date_preorder"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('')
            })

            //Chọn ngày bán
            $('input[name="date_of_sale"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput : false
            })
            $('input[name="date_of_sale"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY'))
            })

            $('input[name="date_of_sale"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('')
            })

            // Thêm nhanh tính năng nổi bật
            $('#fillFeaturesForm').submit(function (e) {
                e.preventDefault()
                var text = $('#fillFeaturesInput').val()
                var ul = $('#product_feature_add').find('ul').attr('id')
                var button = $('#product_feature_add').find('button')
                var random = ul.replace('list-values-features', '')
                var lines = text.split('\n')
                $.each(lines, function (index, line) {
                    if (line.trim() !== '') {
                        $('#input-value-features' + random).val(line)
                        button.trigger('click')
                    }
                })
                $('#featureModal').modal('hide')
            })
        })

        $('.select2bs4').select2({
            theme      : 'bootstrap4',
            placeholder: "Chọn danh mục",
        })

        $('.datetimerange').daterangepicker({
            autoUpdateInput    : false,
            timePicker         : true,
            timePickerIncrement: 5,
            timePicker24Hour   : true,
            timePickerSeconds  : true,
            locale             : {
                format: 'YYYY-MM-DD HH:mm:ss'
            }
        }).on('click', function (e) {
            e.preventDefault()
            $(this).attr('autocomplete', 'off')
        })
        $('.datetimerange').on('apply.daterangepicker', function (ev, picker) {
            $(this)
                .val(picker.startDate.format('YYYY-MM-DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm:ss'))
        })

        $('.datetimerange').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('')
        })

        $('#publishedat').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        })

        $('.invalid-feedback').closest('.collapsed-card').CardWidget('toggle')

        if (!$('#collapseAdvancedSalePrice').hasClass('show')) {
            $('input[name="sale_time"]').val(null)
        }

        function validateYoutubeUrl(url) {
            if (!url) {
                alert('{{ __('Youtube URL is require.') }}')
                return false
            }

            let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/
            let match = url.match(regExp)
            if (!match || match[2].length !== 11) {
                alert('{{ __('Your url you enter is not a valid supported url.') }}')
                return false
            }

            return true
        }

        $('#collapseAdvancedPrice').on('show.bs.collapse', function () {
            $('#btn-advanced-price i').removeClass('fa-chevron-down').addClass('fa-chevron-up')
        }).on('hide.bs.collapse', function () {
            $('#btn-advanced-price i').removeClass('fa-chevron-up').addClass('fa-chevron-down')
        })

        $('#collapseAdvancedSalePrice').on('show.bs.collapse', function () {
            $('#btn-advanced-sale-price').html('{{ __('With Time') }} <i class="fas fa-chevron-up fa-sm fa-fw"></i>')
        }).on('hide.bs.collapse', function () {
            $('#btn-advanced-sale-price')
                .html('{{ __('No Sale Time') }} <i class="fas fa-chevron-down fa-sm fa-fw"></i>')
            $('input[name="sale_time"]').val(null)
            $('input[name="hide_sale_time"]').prop('checked', false)
        })

        if ($('select[name="product_category_id"]').find(':selected').data('type') == '3') {
            $('#original-select').show()
            $('#condition-select').show()
            $('form').append('<input type="hidden" name="is_old" value="1">')
        }

        $('#product_category_id').change(function () {
            var aryCategory = [];
            $('.option-category').each(function (index, item) {
                if ($(item).is(':selected')) {
                    aryCategory.push($(item).val())
                }
            });

            if (aryCategory.length == 0) {
                $('#list-attribute').hide();
                return;
            }

            aryCategory = JSON.stringify(aryCategory);
            $.ajax({
                url    : '{{ route('products.get.attribute') }}',
                type   : 'GET',
                data   : ({
                    aryCategory: aryCategory,
                }),
                success: function (result) {
                    $('#list-attribute').show();
                    $('#list-attribute-item').html(result)
                },
                error  : function (error) {

                }
            });
        })

    </script>

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
            Toast.fire({
                type : 'error',
                title: '{{ $error }}',
            });
            @endforeach

        </script>
    @endif

@endpush

