@canany(['product_categories.update', 'product_categories.store'])
<!-- Danh sach sach danh muc-->
<form id="form-info" method="post"
      action="{{ !empty($currentCategory) ? route('product_categories.update', ['product_category' => $currentCategory->id]) : route('product_categories.store') }}" enctype="multipart/form-data">
    @csrf
    @if (!empty($currentCategory)) @method('PUT') @endif
    <div class="card card-default">
        <div class="card-header">
        <h3 class="card-title">{{__('Category Product Info')}}</h3>
            <div class="card-tools">
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label><span class="text-danger">(*)</span>
                        <input
                            id="title"
                            type="text"
                            name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') ?: (!empty($currentCategory) ? $currentCategory->title : '') }}"
                            required
                        />

                        @error('title')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input
                            id="slug"
                            name="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug') ?: (!empty($currentCategory) ? $currentCategory->slug : '') }}"
                        />
                        @error('slug')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea
                            id="description"
                            name="description"
                            class="form-control @error('description') is-invalid @enderror"
                        >{{ old('description') ?: (!empty($currentCategory) ? $currentCategory->description : '') }}</textarea>

                        @error('description')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 image-box" >
                    <div class="form-group">
                        <label for="thumbnail">{{ __('Thumbnail') }}</label>
                        <div>
                            <div class="preview-image-wrapper ld-img-preview">
                                <img class="preview_image" src="{{ old('thumbnail') ?: (!empty($currentCategory->thumbnail) ? get_image_url($currentCategory->thumbnail, '') : '/preview-icon.png') }}">
                            </div>
                            <span>
                                <a data-result="image" data-action="select-image" class="btn_gallery btn btn-primary text-white">
                                <i class="fa fa-picture-o"></i> {{__('Choose')}}
                                </a>
                            </span>
                            <input type="hidden" id="thumbnail" name="thumbnail" class="image-data form-control @error('thumbnail') is-invalid @enderror" value="{{ old('thumbnail') ?: (!empty($currentCategory) ? $currentCategory->thumbnail : '') }}">
                        </div>

                        @error('thumbnail')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 image-box">
                    <div class="form-group">
                        <label for="icon">{{ __('Icon') }}</label>
                        <div>
                            <div class="preview-image-wrapper ld-img-preview">
                                <img class="preview_image" src="{{ old('icon') ?: (!empty($currentCategory->icon) ? $currentCategory->icon : '/preview-icon.png') }}" >
                            </div>
                            <span>
                                <a data-result="image" data-action="select-image" class="btn_gallery btn btn-primary text-white">
                                <i class="fa fa-picture-o"></i> {{__('Choose')}}
                                </a>
                            </span>
                            <input type="hidden" id="icon" name="icon" class="image-data form-control @error('icon') is-invalid @enderror" value="{{ old('icon') ?: (!empty($currentCategory) ? $currentCategory->icon : '') }}">
                        </div>

                        @error('icon')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="parent_id">{{ __('Parent') }}</label>
                        <select
                            id="parent_id"
                            name="parent_id"
                            class="form-control select2bs4 @error('parent_id') is-invalid @enderror"
                        >
                            <option value="">{{ __('No parent') }}</option>
                            @include('partials.forms.product_category_options', ['current' => $currentCategory ?? null, 'selected' => !empty($currentCategory->parent_id) ? [$currentCategory->parent_id] : []])
                        </select>

                        @error('parent_id')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="menu_bottom">
                            {{__('Status')}}
                        </label>
                        <select
                            id="status"
                            name="status"
                            class="form-control select2bs4 @error('status') is-invalid @enderror"
                        >
                        @foreach(\App\Models\ProductCategory::$STATUS as $key=>$value)
                                <option value="{{ $key }}" @if (old('status') == $key || (!empty($currentCategory) && $currentCategory->status == $key)) selected @endif>
                                    {{ __($value) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group clearfix">
                        <input type="hidden"  name="is_menu_home"  value="0" />
                        <div class="icheck-primary d-inline">
                          <input type="checkbox" id="is_menu_home" name="is_menu_home" value="1" @if (old('is_menu_home') == 1 || (!empty($currentCategory) && $currentCategory->is_menu_home == 1)) checked @endif>
                          <label for="is_menu_home">
                            {{__('Show Home?')}}
                          </label>
                        </div>
                      </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @php
                        if (!empty(old('posts'))) {
                            $posts = collect(old('posts'))->map(fn($post) => ['value' => $post, 'label' => "ID: $post"])->toArray();
                        } elseif (!empty($currentCategory) && !empty($currentCategory->posts)) {
                            $posts = $currentCategory->posts->map(fn($posts) => ['value' => $posts->id, 'label' => $posts->title])->toArray();
                        }
                    @endphp
            
                    @include('partials.modals.choose-post', [
                        'label' => __('Posts'),
                        'name' => 'posts',
                        'data' => $posts ?? [],
                        'dataUrl' => route('getPostForProduct', ['type' => 'all']),
                    ])
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @include('partials.forms.seo', ['model' => !empty($currentCategory) ? $currentCategory:null])
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="button" id="category_submit" class="btn btn-primary btn-sm">
                {{ __('Save') }}
            </button>
        </div>
    </div>
    <!-- /.card -->
</form>
@include('partials.forms.slug', [
    'fromElement' => '#title',
    'toElement' => '#slug',
])
@include('partials.js.rv_media',['buttonMoreImages'=>[],'disablePush'=>1])
@include('partials.editors.summernote',['editors'=>['description'],'buttons'=>[],'realButtons'=>[]])
@push('scripts')
<script>
    $( document ).ready(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });

        $(document).on("click", '#category_submit', function() { 
            CKEDITOR.instances.description.updateElement();
            $.ajax({
                url:  $('#form-info').attr('action'),
                type: $('#form-info').attr('method'),
                data: $('#form-info').serialize(),
                success: function(result){
                    jQuery.each(result.errors, function(key, value){
                  			jQuery('.alert-danger').show();
                  			jQuery('.alert-danger').append('<p>'+value+'</p>');
                  		});
                    if(result.success){
                        var parent_id = result.parentId;
                        var level     = result.level;
                        if(level==1){
                            window.location.reload();
                        } else {
                                loadSubCate(parent_id,level-1);
                            }

                        window.location.reload();
                       }
                },
                error: function (request, status, error) {
                    if (typeof request.responseJSON.errors !== "undefined") {
                        jQuery.each(request.responseJSON.errors, function(key, value){
                                jQuery('.alert-danger').show();
                                jQuery('.alert-danger').append('<p>'+value+'</p>');
                                jQuery('[name='+key+']').addClass('is-invalid');
                            });
                    }
                }
            });
        });
    });
</script>
@endpush
@endcanany
