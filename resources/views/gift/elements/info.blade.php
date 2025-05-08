<div class="form-group">
    <label for="name">{{ __('Title') }}</label>
    <span class="text-danger">(*)</span>
    <input
            id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') ?: (!empty($gift) ? $gift->name : '') }}" required
    />

    @error('name')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

@php
    $selectedCategory = [];
    if(isset($gift)) {
       $selectedCategory = $gift->category->pluck('id')->toArray();
    }
    elseif (!empty(old('product_category_id'))) {
        $selectedCategory = old('product_category_id');
    }
@endphp
<div class="form-group">
    <label for="product_category_id">{{ __('Category') }}</label>
    <span class="text-danger">(*)</span>
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

<div class="form-group">
    <label for="content">{{ __('Content') }}</label>
    <textarea
            id="content" name="content"
            class="form-control @error('content') is-invalid @enderror"
    >{{ old('content') ?: (!empty($gift) ? $gift->content : '') }}</textarea>

    @error('content')
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
        @foreach(\App\Models\Gift::STATUS as $status => $label)
            <option
                    value="{{ $status }}"
                    @if(old('status') == $status || (!empty($gift) && $gift->status == $status)) selected @endif>
                {{ __("gift.status.$label") }}
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
        @include('partials.forms.seo', ['model' => !empty($gift) ? $gift:null])
    </div>
</div>
@include('partials.forms.slug', [
    'fromElement' => '#title',
    'toElement' => '#slug',
])
@include('partials.js.rv_media',['buttonMoreImages'=>[]])
@include('partials.editors.summernote',['editors'=>['content'],'buttons'=>[],'realButtons'=>[]])
