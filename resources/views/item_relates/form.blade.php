@extends('layouts.app')

@section('page-title', !empty($itemRelate) ?  __('Edit Item Relate: :title', ['title' => $itemRelate->title]) : __('Create Item Relate'))
@section('content')

<div class="row">
    <div class="col">
        <form
        class="card"
        action="{{ empty($itemRelate) ? route('item_relates.store',['model'=>$model,'model_id'=>$modelId]) :route('item_relates.update',['item_relate'=>$itemRelate->id,'model'=>$model,'model_id'=>$modelId]) }}"
        method="post"
        >
            @csrf
            @if (!empty($itemRelate)) @method('PUT') @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        {{-- @php
                            $model = old('model') ?: ($slider->model ?? null);
                            $model_id = old('model_id') ?: ($slider->model_id ?? null);
                        @endphp --}}
                        <input type="hidden" value="{{$model}}" name="model">
                        <input type="hidden" value="{{$modelId}}" name="model_id">
                        <div class="form-group">
                            <label for="name">{{ __('Title') }}(
                                <span class="text-danger">*</span>
                                                               )
                            </label>
                            <input
                                id="title"
                                type="text"
                                name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') ?: (!empty($itemRelate) ? $itemRelate->title : '') }}"

                            />
                            @error('title')
                            <span class="error invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="link">{{ __('Link') }}(
                                <span class="text-danger">*</span>
                                                              )
                            </label>
                            <div class="input-group">
                                <input
                                    id="link"
                                    type="url"
                                    name="link"
                                    class="form-control float-right @error('link') is-invalid @enderror"
                                    value="{{old('link') ?: (!empty($itemRelate) ? $itemRelate->link : '')}}"
                                >
                            </div>
                            @error('link')
                            <span class="error invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="card image-box">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ __('Thumbnail') }} (
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
                                                    src="{{ old('image') ?: (!empty($itemRelate) ? get_image_url($itemRelate->image, '') : '/preview-icon.png') }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div>
                                                <span class="input-group-btn">
                                                    <a
                                                        data-result="image" data-action="select-image"
                                                        class="btn_gallery btn btn-primary text-white"
                                                    >
                                                        <i class="fa fa-picture-o"></i> {{__('Choose')}}
                                                    </a>
                                                </span>
                                                <input
                                                    name="image" type="hidden"
                                                    class="image-data form-control @error('thumbnail') is-invalid @enderror"
                                                    value="{{ old('thumbnail') ?: (!empty($itemRelate) ? $itemRelate->image : '') }}"
                                                >
                                            </div>
                                            @error('thumbnail')
                                            <span class="error invalid-feedback" style="display: block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="rel">{{ __('Rel') }}</label>
                            <div class="input-group">
                                <input
                                    id="rel"
                                    name="rel"
                                    class="form-control float-right @error('rel') is-invalid @enderror"
                                    value="{{old('rel') ?: (!empty($itemRelate) ? $itemRelate->rel : '')}}"
                                >
                            </div>
                            @error('rel')
                            <span class="error invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="target">{{ __('Target') }}</label>
                            <select name="target" id="target" class="form-control select2bs4">
                                <option value=""></option>
                                @foreach(config("admin.target") as $target)
                                    <option
                                        value="{{ $target }}"
                                        @if(old('target') == $target || (!empty($itemRelate) && $itemRelate->target == $target)) selected @endif>
                                        {{ __($target) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card-footer clearfix">
                <div class="float-right">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection

@push('scripts')

    @include('partials.js.rv_media',['buttonMoreImages'=>['btn_picture','btn_real_images']])
    @include('partials.editors.summernote',['editors'=>['technical_specification', 'description'],'buttons'=>[],'realButtons'=>[]])
    @include('partials.forms.slug', ['fromElement' => '#name', 'toElement' => '#slug'])

    <script src="{{ asset('jquery.mask.min.js') }}"></script>
    <script src="{{ asset('tokenfield/bootstrap-tokenfield.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


    <script>

        $(document).ready(function () {
            $('input[number-mask]').attr('type', 'text').mask('00,000,000,000', {reverse: true})

            //Chọn ngày tháng
            $('input[name="date_preorder"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false
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
                autoUpdateInput: false
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
            theme: 'bootstrap4'
        })

        $('.datetimerange').daterangepicker({
            autoUpdateInput: false,
            timePicker: true,
            timePickerIncrement: 5,
            timePicker24Hour: true,
            timePickerSeconds: true,
            locale: {
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

        $('select[name="product_category_id"]').change(function () {
            if ($(this).find(':selected').data('type') == '3') {
                $('#original-select').show()
                $('#condition-select').show()
                $('form').append('<input type="hidden" name="is_old" value="1">')
                $('#note-form').hide()
                $('#description-form').hide()
                $('#source-form').hide()
                $('#date-preorder-form').hide()
                $('#day-order-form').hide()
                $('#technical_specification_label').text('{{ __('Thông số kỹ thuật') }}')
            } else {
                $('#original-select').hide()
                $('#condition-select').hide()
                $('input[name="is_old"]').remove()
                $('#note-form').show()
                $('#description-form').show()
                $('#source-form').show()
                $('#date-preorder-form').show()
                $('#day-order-form').show()
                $('#technical_specification_label').text('{{ __('Technical Specification') }}')
            }
        })

    </script>

@endpush
