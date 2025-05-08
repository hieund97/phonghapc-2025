<div class="form-group">
    <label for="title">{{ __('Title') }}</label>
    <span class="text-danger">(*)</span>
    <input
            id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title') ?: (!empty($currentAttrValue) ? $currentAttrValue->title : '') }}" required
    />

    @error('title')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="slug">{{ __('Slug') }}</label>
    (
    <span class="text-danger">*</span>
    )
    <input
            id="slug"
            name="slug"
            class="form-control @error('slug') is-invalid @enderror"
            value="{{ old('slug') ?: (!empty($currentAttrValue) ? $currentAttrValue->slug : '') }}"
    />
    @error('slug')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="attr_id">{{ __('Attribute_category') }}</label>
    <span class="text-danger">(*)</span>
    <select id="attr_id" name="attr_id" class="form-control select2bs4 @error('attr_id') is-invalid @enderror">
        <option value="">{{ __('Choose Attribute Category') }}</option>
        @include('partials.forms.attribute_group_options', ['selected' => (old('attr_id'))?:(!empty($currentAttrValue) ?$currentAttrValue->attr_id : null)])
        )
    </select>

    @error('attr_id')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="form-group">
    <label for="parent_id">{{ __('Parent') }}</label>
    <span class="text-danger">(*)</span>
    <select id="parent_id" name="parent_id" class="form-control select2bs4 @error('parent_id') is-invalid @enderror">
        <option value="">{{ __('No parent') }}</option>
        @include('partials.forms.attribute_value_options', ['selected' => (old('parent_id'))?:(!empty($currentAttrValue) ?$currentAttrValue->parent_id : null)])
        )
    </select>

    @error('parent_id')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea
            id="description" name="description"
            class="form-control @error('description') is-invalid @enderror"
    >{{ old('title') ?: (!empty($currentAttrValue) ? $currentAttrValue->description : '') }}</textarea>

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
        @foreach(\App\Models\Attribute::STATUS as $status => $label)
            <option
                    value="{{ $status }}"
                    @if(old('status') == $status || (!empty($currentAttrValue) && $currentAttrValue->status == $status)) selected @endif>
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
        @include('partials.forms.seo', ['model' => !empty($currentAttrValue) ? $currentAttrValue:null])
    </div>
</div>
@include('partials.forms.slug', [
    'fromElement' => '#title',
    'toElement' => '#slug',
])
@include('partials.js.rv_media',['buttonMoreImages'=>[]])
@include('partials.editors.summernote',['editors'=>['description'],'buttons'=>[],'realButtons'=>[]])
