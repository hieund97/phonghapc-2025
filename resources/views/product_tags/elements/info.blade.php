<div class="form-group">
    <label for="title">{{ __('Title') }}</label><span class="text-danger">(*)</span>
    <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title') ?: (!empty($currentProductTag) ? $currentProductTag->title : '') }}" required />

    @error('title')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="slug">{{ __('Slug') }}</label>(<span class="text-danger">*</span>)
    <input
        id="slug"
        name="slug"
        class="form-control @error('slug') is-invalid @enderror"
        value="{{ old('slug') ?: (!empty($currentProductTag) ? $currentProductTag->slug : '') }}"
    />
    @error('slug')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group image-box">
    <label for="thumbnail">{{ __('Thumbnail') }}</label><span class="text-danger"></span>
    <div class="input-group ">
        <div class="preview-image-wrapper ld-img-preview">
            <img class="preview_image"
                src="{{ old('thumbnail') ?: (!empty($currentProductTag->thumbnail) ? $currentProductTag->thumbnail : '/preview-icon.png') }}">
        </div>
        <span>
            <a data-result="image" data-action="select-image" class="btn_gallery btn btn-primary text-white">
                <i class="fa fa-picture-o"></i> {{__('Choose')}}
            </a>
        </span>
        <input  type="hidden" id="thumbnail" name="thumbnail"
            class="image-data form-control @error('title') is-invalid @enderror"
            value="{{ old('thumbnail') ?: (!empty($currentProductTag) ? $currentProductTag->thumbnail : '') }}">
    </div>

    @error('thumbnail')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea id="description" name="description"
        class="form-control @error('description') is-invalid @enderror">{{ old('title') ?: (!empty($currentProductTag) ? $currentProductTag->description : '') }}</textarea>

    @error('description')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="form-group">
    <label for="status">{{ __('Status') }}</label>
    <select
        name="status"
        id="status"
        class="form-control select2bs4 @error('status') is-invalid @enderror"
        required
    >
        @foreach(\App\Models\Category::STATUS as $status => $label)
            <option
                value="{{ $status }}"
                @if(old('status') == $status || (!empty($currentProductTag) && $currentProductTag->status == $status)) selected @endif>
                {{ __("post.status.$label") }}
            </option>
        @endforeach
    </select>

    @error('status')
    <span class="error invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="row">
    <div class="col-md-12">
        @include('partials.forms.seo', ['model' => !empty($currentProductTag) ? $currentProductTag:null])
    </div>
</div>
@include('partials.forms.slug', [
    'fromElement' => '#title',
    'toElement' => '#slug',
])
@include('partials.js.rv_media',['buttonMoreImages'=>[]])
@include('partials.editors.summernote',['editors'=>['description'],'buttons'=>[],'realButtons'=>[]])
