@extends('layouts.app')
@section('page-title', ('Create banner or Edit banner'))
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('General Info') }}</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="type">{{ __('Type') }}</label>
                        <select name="type" id="type" class="form-control select2bs4">
                            @foreach(\App\Models\Banner::TYPES as $type)
                                <option value="{{ $type }}" @if($type == request('type')) selected @endif>
                                    {{ __($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="home_select" class="form-group" style="display: none;">
                        <label for="home">
                            {{ __('Select') }}
                        </label>

                        <select name="home" id="home" data-type="home" class="change-group form-control select2bs4">
                            <option value=""></option>
                            <option value="1">{{ __('Select') }}</option>                     
                        </select>
                    </div>

                    <div id="category_select" class="form-group" style="display: none;">
                        <label for="category">
                            {{ __(\App\Models\ProductCategory::class) }}
                        </label>

                        <select name="category" id="category" data-type="category" class="change-group form-control select2bs4">
                            <option value=""></option>
                            @include('partials.forms.product_category_options', ['selected' => (request('type') == \App\Models\ProductCategory::class ? request('id') : null)])
                        </select>
                    </div>

                    <div id="category_post_select" class="form-group" style="display: none;">
                        <label for="category_post">
                            {{ __(\App\Models\Category::class) }}
                        </label>

                        <select name="category_post" id="category_post" data-type="category_post" class="change-group form-control select2bs4">
                            <option value=""></option>
                            @include('partials.forms.category_options', ['selected' => (request('type') == \App\Models\Category::class ? request('id') : null)])
                        </select>
                    </div>

                    <div id="product_tag_select" class="form-group" style="display: none;">
                        <label for="product_tag">
                            {{ __(\App\Models\ProductTag::class) }}
                        </label>

                        <select name="product_tag" id="product_tag" data-type="product_tag" class="change-group form-control select2bs4">
                            <option value=""></option>

                            @include('partials.forms.product_tag_options', ['selected' => (request('type') == \App\Models\ProductTag::class ? request('id') : null)])
                        </select>
                    </div>

                    <div id="post_tag_select" class="form-group" style="display: none;">
                        <label for="post_tag">
                            {{ __(\App\Models\PostTag::class) }}
                        </label>

                        <select name="post_tag" id="post_tag" data-type="post_tag" class="change-group form-control select2bs4">
                            <option value=""></option>

                            @include('partials.forms.post_tag_options', ['selected' => (request('type') == \App\Models\PostTag::class ? request('id') : null)])
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card" id="card-banners" style="display: none;">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('Banners') }}
            </h3>

            <div class="card-tools">
                <button class="btn btn-success btn-sm" id="create_banner">
                    {{ __('Add') }}
                </button>
            </div>
        </div>

        <div class="card-body row" id="banners">

        </div>
    </div>
@endsection

@push('footer')
    @include('media::partials.media')

    <div class="modal fade" id="bannerInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="banner-info" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Banner Info') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="text-center max-w-img-full" id="banner-img"></div>

                    <div class="text-center my-2">
                        <button id="edit_banner" class="btn btn-primary btn-sm">
                            {{ __('Edit image') }}
                        </button>
                    </div>

                    <div class="row my-4">
                        <div class="col-md-6">
                            <div class="checkbox icheck-primary">
                                <input
                                    type="checkbox"
                                    id="status"
                                    name="status"
                                    value="1"
                                    checked
                                >

                                <label for="status">{{ __('Status') }}</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkbox icheck-primary">
                                <input
                                    type="checkbox"
                                    id="show_on_list"
                                    name="show_on_list"
                                    value="1"
                                >

                                <label for="show_on_list">{{ __('Show on list?') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">
                                    {{ __('Title') }} (<span class="text-danger">*</span>)
                                </label>

                                <input type="text" id="title" name="title" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="link">
                                    {{ __('Link') }} (<span class="text-danger">*</span>)
                                </label>

                                <input type="text" id="link" name="link" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="banner_type">
                            {{ __('Type') }} (<span class="text-danger">*</span>)
                        </label>

                        <select id="banner_type" name="type" class="form-control select2bs4" required>
                            @foreach(\App\Models\Banner::TYPE as $type)
                                <option value="{{ $type }}">{{ __("banners.type.$type") }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="rel">{{ __('Rel') }}</label>
                        <div class="input-group">    
                            <input 
                                id="rel" 
                                name="rel" 
                                class="form-control float-right" value=""
                                >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="target">{{ __('Target') }}</label>
                        <select name="target" id="target" class="form-control select2bs4">
                            <option value=""></option>
                            @foreach(config("admin.target") as $target)
                                <option value="{{ $target }}">
                                    {{ __($target) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('styles')
    <style>
        .max-w-img-full img {
            max-width: 100%;
            max-height: 200px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let ID = function () {
            return '_' + Math.random().toString(36).substr(2, 9);
        };

        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });

        $('#bannerInfoModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false,
        });

        $(function() {
            if ($('#type').val() === 'App\\Models\\ProductCategory') {
                loadBanners('#category');
            } 
            else if ($('#type').val() === 'App\\Models\\Category') {
                loadBanners('#category_post');
            }
            else if ($('#type').val() === 'Home') {
                loadBanners('#home');
            }
            else if ($('#type').val() === 'App\\Models\\ProductTag') {
                loadBanners('#product_tag');
            }
            else if ($('#type').val() === 'App\\Models\\PostTag') {
                loadBanners('#post_tag');
            }
        });

        $('.change-group').change(function() {
            loadBanners(this);
        });

        $('#bannerInfoModal').on('hidden.bs.modal', function() {
            $('input[name="thumbnail"]').remove();
            $('.demo-banner-image').remove();
            $('#current-selected-banner').remove();
            $('#banner-info').find('input').val('');
            $('#banner-info').find('select').val('').trigger('change');

            $('#status').val(1);
            $('#show_on_list').val(1);
            $('#status').prop('checked', true);
            $('#show_on_list').prop('checked', false);
        });

        function loadBanners(el)
        {
            let type = $(el).data('type');
            let id = $(el).val();

            $('#banners').html('');

            if (!type || !id) {
                $('#card-banners').hide();
                return false;
            }

            $.get('{{ url('/cp_admin/banners/list') }}/' + type + '/' + id).then(function(response) {

                $.each(response, function() {
                    displayBanner(this, ID());
                });

                $('#card-banners').show();
            });
        }

        function updateFilter(empty)
        {
            if (empty) {
                $('#home').val('').trigger('change');
                $('#category').val('').trigger('change');
                $('#category_post').val('').trigger('change');
                $('#product_tag').val('').trigger('change');
                $('#post_tag').val('').trigger('change');
            }

            let type = $('#type').val();

            if (type === 'App\\Models\\ProductCategory') {
                $('#home_select').hide();
                $('#category_select').show();
                $('#category_post_select').hide();
                $('#product_tag_select').hide();
                $('#post_tag_select').hide();                
            } 
            else if (type === 'App\\Models\\Category') {
                $('#home_select').hide();
                $('#category_select').hide();
                $('#category_post_select').show();
                $('#product_tag_select').hide();
                $('#post_tag_select').hide();                
            } 
            else if (type === 'Home') {
                $('#home_select').show();
                $('#category_select').hide();
                $('#category_post_select').hide();
                $('#product_tag_select').hide();
                $('#post_tag_select').hide();   
            }
            else if (type === 'App\\Models\\ProductTag') {
                $('#home_select').hide();
                $('#category_select').hide();
                $('#category_post_select').hide();
                $('#product_tag_select').show();
                $('#post_tag_select').hide();   
            }
            else if (type === 'App\\Models\\PostTag') {
                $('#home_select').hide();
                $('#category_select').hide();
                $('#category_post_select').hide();
                $('#product_tag_select').hide();
                $('#post_tag_select').show();  
            } else {
                $('#home_select').hide();
                $('#category_select').hide();
                $('#category_post_select').hide();
                $('#product_tag_select').hide();
                $('#post_tag_select').hide();   
            }
        }

        $('#type').change(function() {
            updateFilter(true);
        });

        updateFilter();

        function cut_text(text, length) {
            let result = text.substr(0, length);

            if (text.length > length) {
                result += '...';
            }

            return result;
        }

        function displayBanner(data, uniqueId) {
            let types = @json(collect(\App\Models\Banner::TYPE)->mapWithKeys(fn($item) => [$item => __("banners.type.$item")]))

            let html = '';
        
            html += '<div class="text-center"><img style="height: 200px !important;" src="' + data['thumbnail'] + '"></div>';
            html += '<table class="table table-sm mt-2">';
            html += '<tr><td>{{ __('Status') }}</td><td><span class="text-' + (data['status'] ? 'success' : 'danger') + '"><i class="fas fa-circle"></i></span></td></tr>';
            html += '<tr><td>{{ __('Show on list?') }}</td><td><span class="text-' + (data['show_on_list'] ? 'success' : 'danger') + '"><i class="fas fa-circle"></i></span></td></tr>';
            html += '<tr><td>{{ __('Title') }}</td><td title="' + data['title'] + '">' + cut_text(data['title'], 27) + '</td></tr>';
            html += '<tr><td>{{ __('Link') }}</td><td title="' + data['link'] + '">' + cut_text(data['link'], 27) + '</td></tr>';
            html += '<tr><td>{{ __('Type') }}</td><td>' + types[data['type']] + '</td></tr>';
            html += '<tr><td>{{ __('Action') }}</td><td>';
            html += '<a href="#" onclick="editBanner('+ data['id'] + ", '" + uniqueId + '\')"><i class="fas fa-fw fa-edit"></i></a>';
            html += '<a href="#" onclick="removeBanner('+ data['id'] + ", '" + uniqueId + '\')"><i class="fas fa-fw fa-trash"></i></a>';
            html += '</td></tr>';
            html += "<input type='hidden' value='" + JSON.stringify(data) + "'>";
            html += '</table>';

            if ($('#' + uniqueId).length) {
                $('#' + uniqueId).html(html);
            } else {
                $('#banners').append('<div class="col-md-4 max-w-img-full" id="' + uniqueId + '">' + html + '</div>');
            }
        }

        function editBanner(id, uniqueId)
        {
            let data = JSON.parse($('#' + uniqueId).find('input').val());

            $('#banner-info').append('<input type="hidden" name="unique_id" value="' + uniqueId + '">');

            $.each(data, function(key, value) {
                $('#banner-info').find('input[name="' + key + '"]').val(value);
                $('#banner-info').find('select[name="' + key + '"]').val(value).trigger('change');
                $('#banner-info').find('select[name="' + key + '[]"]').val(value).trigger('change');

                if (key === 'id') {
                    $('#banner-info').append('<input type="hidden" name="id" value="' + value + '">');
                }

                if (key === 'thumbnail') {
                    $('#banner-img').html('<img class="demo-banner-image" src="' + value + '">');
                    $('#banner-info').append('<input type="hidden" name="thumbnail" value="' + value + '">');
                }

                if (key === 'status') {
                    $('#status').val(1);
                    $('#status').prop('checked', value.toString() === '1');
                }

                if (key === 'show_on_list') {
                    $('#show_on_list').val(1);
                    $('#show_on_list').prop('checked', value.toString() === '1');
                }
            });

            $('#bannerInfoModal').modal('show');
        }

        function removeBanner(id, uniqueId)
        {
            $.ajax({
                url: '{{ url('/cp_admin/banners') }}/' + id,
                type: 'DELETE',
                success: function (result) {
                    $('#' + uniqueId).remove();
                },
                error: function () {
                    alert('Có lỗi xảy ra, vui lòng tải lại trang.');
                },
            });
        }

        $('#banner-info').submit(function(e) {
            e.preventDefault();

            let formData = {};

            $.each($(this).serializeArray(), function() {
                formData[this.name] = this.value;
            });

            if (!formData['unique_id']) {
                formData['unique_id'] = ID();
            }

            formData['model'] = $('#type').val();

            if (formData['model'] === 'App\\Models\\ProductCategory') {
                formData['model_id'] = $('#category').val();
            }
            else if (formData['model'] === 'App\\Models\\Category') {
                formData['model_id'] = $('#category_post').val();
            }
             else if (formData['model'] === 'Home') {
                formData['model_id'] = $('#home').val();
            }
            else if (formData['model'] === 'App\\Models\\ProductTag') {
                formData['model_id'] = $('#product_tag').val();
            }        
            else if (formData['model'] === 'App\\Models\\PostTag') {
                formData['model_id'] = $('#post_tag').val();
            }

            $.post('{{ route('banners.store') }}', formData).then(function(result) {

                displayBanner(result, formData['unique_id']);

                $('#bannerInfoModal').modal('hide');
            });

            return false;
        });

        $('#create_banner').rvMedia({
            onSelectFiles: function(files) {
                $('#banner-img').html('<img class="demo-banner-image" src="' + files[0].full_url + '">');
                $('#banner-info').append('<input type="hidden" name="thumbnail" value="' + files[0].full_url + '">');
                $('#bannerInfoModal').modal('show');
            },
        });

        $('#edit_banner').rvMedia({
            onSelectFiles: function(files) {
                console.log(files[0]);

                $('.demo-banner-image').attr('src', files[0].full_url);
                $('input[name="thumbnail"]').val(files[0].full_url);
            },
        });
    </script>
@endpush
