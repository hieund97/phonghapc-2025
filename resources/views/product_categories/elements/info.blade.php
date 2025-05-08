<div class="form-group">
    <label for="title">{{ __('Title') }}</label><span class="text-danger">(*)</span>
    <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title') ?: (!empty($currentCategory) ? $currentCategory->title : '') }}" required />

    @error('title')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="slug">{{ __('Slug') }}</label>(<span class="text-danger">*</span>)
    <input id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
        value="{{ old('slug') ?: (!empty($currentCategory) ? $currentCategory->slug : '') }}" />
    @error('slug')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
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
                    <img class="preview_image" src="{{ old('icon') ?: (!empty($currentCategory->icon) ? get_image_url($currentCategory->icon, '') : '/preview-icon.png') }}" >
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

<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea id="description" name="description"
        class="form-control @error('description') is-invalid @enderror">{{ old('title') ?: (!empty($currentCategory) ? $currentCategory->description : '') }}</textarea>

    @error('description')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="parent_id">{{ __('Parent') }}</label>
    <select id="parent_id" name="parent_id" class="form-control select2bs4 @error('parent_id') is-invalid @enderror">
        <option value="">{{ __('No parent') }}</option>
        @include('partials.forms.product_category_options', ['selected' => [(old('parent_id'))?:(!empty($currentCategory) ? $currentCategory->parent_id : null)]]))
    </select>

    @error('parent_id')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="d-flex justify-content-between">
    <div class="form-group clearfix">
        <input type="hidden" name="is_menu_home" value="0" />
        <div class="icheck-primary d-inline">
            <input type="checkbox" id="is_menu_home" name="is_menu_home" value="1" @if (old('is_menu_home')==1 ||
            (!empty($currentCategory) && $currentCategory->is_menu_home == 1)) checked @endif>
            <label for="is_menu_home">
                {{__('Show Home?')}}
            </label>
        </div>
    </div>
    <div class="form-group clearfix">
        <input type="hidden" name="is_build" value="0" />
        <div class="icheck-primary d-inline">
            <input type="checkbox" id="is_build" name="is_build" value="1" @if (old('is_build')==1 ||
            (!empty($currentCategory) && $currentCategory->is_build == 1)) checked @endif>
            <label for="is_build">
                {{__('Category build PC')}}
            </label>
        </div>
    </div>
    <div class="form-group clearfix">
        <input type="hidden" name="is_feature" value="0" />
        <div class="icheck-primary d-inline">
            <input type="checkbox" id="is_feature" name="is_feature" value="1" @if (old('is_feature')==1 ||
            (!empty($currentCategory) && $currentCategory->is_feature == 1)) checked @endif>
            <label for="is_feature">
                {{__('Feature Category')}}
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="menu_bottom">
        {{__('Status')}}
    </label>
    <select id="status" name="status" class="form-control select2bs4 @error('status') is-invalid @enderror">
        @foreach(\App\Models\ProductCategory::$STATUS as $key=>$value)
        <option value="{{ $key }}" @if (old('status')==$key || (!empty($currentCategory) && $currentCategory->status == $key)) selected @endif>
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

    <div class="row">
        <div class="col-md-12">
            @include('partials.forms.seo', ['model' => !empty($currentCategory) ? $currentCategory:null])
        </div>
    </div>
    @include('partials.forms.slug', [
    'fromElement' => '#title',
    'toElement' => '#slug',
    ])
    @include('partials.js.rv_media',['buttonMoreImages'=>[]])
    @include('partials.editors.summernote',['editors'=>['description'],'buttons'=>[],'realButtons'=>[]])