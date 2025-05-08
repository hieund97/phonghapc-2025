@extends('layouts.app')

@section('page-title', !empty($textLink) ? __('Edit Text Link: :title', ['title' => $textLink->id]) : __('Create Text Link'))

@section('content')
    <div class="row">
        <div class="col">
            <form
                class="row"
                action="{{ empty($textLink) ? route('text_links.store') : route('text_links.update', ['text_link' => $textLink->id]) }}"
                method="post"
            >
                @csrf
                @if (!empty($textLink)) @method('PUT') @endif
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="type">{{ __('Type') }}</label>
                                        <select name="type" id="type" class="form-control select2bs4">
                                            @foreach(config('admin.textlink_type') as $type => $label)
                                                <option
                                                    value="{{ $type }}"
                                                    @if(old('type') == $type || (!empty($textLink) && $textLink->type == $type)) selected @endif>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    @php
                                        $model = old('model') ?: ($textLink->model ?? null);
                                        $model_id = old('model_id') ?: ($textLink->model_id ?? null);
                                    @endphp

                                    <div class="form-group">
                                        <label for="model">{{ __('Page') }}</label>
                                        <select name="model" id="model" class="form-control select2bs4">
                                            @foreach(\App\Models\TextLink::MODEL as $label)
                                                <option
                                                    value="{{ $label }}"
                                                    @if($model == $label) selected @endif>
                                                    {{ __($label) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="category_select" class="form-group">
                                        <label for="model_id">
                                            {{ __('Category') }}
                                        </label>

                                        <select
                                            name="model_id"
                                            id="model_id"
                                            data-type="model_id"
                                            class="change-group form-control select2bs4"
                                        >
                                            <option value=""></option>
                                            @if($model=='App\Models\ProductCategory')
                                                @include('partials.forms.product_category_options', ['selected' => $model_id])
                                            @elseif($model=='App\Models\Category')
                                                @include('partials.forms.category_options', ['selected' => $model_id])
                                            @elseif($model=='App\Models\ProductTag')
                                                @include('partials.forms.product_tag_options', ['selected' => $model_id])
                                            @elseif($model=='App\Models\PostTag')
                                                @include('partials.forms.post_tag_options', ['selected' => $model_id])
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="link">{{ __('Link') }}</label>
                                        <input
                                            id="link"
                                            type="text"
                                            name="link"
                                            class="form-control @error('link') is-invalid @enderror"
                                            value="{{ old('link') ?: (!empty($textLink) ? $textLink->link : '') }}"
                                            required
                                            placeholder="https:// or http://..."
                                        />
                                        @error('link')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="list_id">{{ __('List id product or post') }}</label>
                                        <input
                                            id="list_id"
                                            type="text"
                                            name="list_id"
                                            class="form-control @error('list_id') is-invalid @enderror"
                                            value="{{ old('list_id') ?: (!empty($textLink) ? $textLink->list_id : '') }}"
                                            placeholder="Id cách nhau bởi dấu ','"
                                        />
                                        @error('list_id')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>



                                     <div class="form-group">
                                        <label for="index">{{ __('Text link index') }}</label>
                                        <input
                                            id="index"
                                            type="number"
                                            name="index"
                                            class="form-control @error('index') is-invalid @enderror"
                                            value="{{ old('index') ?: (!empty($textLink) ? $textLink->index : '') }}"
                                            placeholder="Trọng số "
                                        />
                                        @error('index')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rel">{{ __('Rel') }}</label>
                                        <input
                                            id="rel"
                                            name="rel"
                                            class="form-control @error('rel') is-invalid @enderror"
                                            value="{{ old('rel') ?: (!empty($textLink) ? $textLink->rel : '') }}"
                                            placeholder="ugc,nofollow,..."
                                        />
                                        @error('rel')
                                        <span
                                            class="error invalid-feedback" style="display: block"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="text">{{ __('Text') }}</label>
                                        <span
                                            class="text-danger"
                                        ></span>
                                        <textarea
                                            id="text" name="text"
                                            class="form-control @error('text') is-invalid @enderror" rows="5"
                                            placeholder="Enter ..."
                                        >{{ old('text') ?: (!empty($textLink) ? $textLink->text : '') }}</textarea>
                                        @error('text')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input
                                                type="checkbox"
                                                name="is_home"
                                                value="1"
                                                id="is_home"
                                                @if (old('is_home') || ($textLink->is_home ?? false)) checked @endif>
                                            <label for="is_home">{{ __('Is Home?') }}</label>
                                        </div>
                                        @error('is_home')
                                        <span
                                            class="error invalid-feedback" style="display: block"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input
                                                type="checkbox"
                                                name="status"
                                                value="1"
                                                id="status"
                                                @if (old('status') || old('status')==null || ($textLink->status ?? false)) checked @endif>
                                            <label for="status">{{ __('Status') }}</label>
                                        </div>
                                        @error('status')
                                        <span
                                            class="error invalid-feedback" style="display: block"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="sort">{{ __('Sort') }}</label>
                                        <input
                                            id="sort"
                                            name="sort"
                                            type="number"
                                            class="form-control @error('rel') is-invalid @enderror"
                                            value="{{ old('sort') ?: (!empty($textLink) ? $textLink->rsortel : 0) }}"
                                        />
                                        @error('sort')
                                        <span
                                            class="error invalid-feedback" style="display: block"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

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
                            <a href="{{ route('text_links.index') }}" class="btn btn-danger">
                                <i class="fas fa-ban fa-fw"></i>
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </div>
                    <div class="card image-box">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Thumbnail') }}
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-danger mb-2">
                                        {{ __('Recommend Size: :size', ['size' => '168x41']) }}
                                    </div>

                                    <div class="form-group">
                                        <div class="preview-image-wrapper img-fluid">
                                            <img
                                                class="preview_image"
                                                src="{{ old('thumbnail') ?: (!empty($textLink) ? $textLink->thumbnail : '/preview-icon.png') }}"
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
                                                name="thumbnail" type="hidden"
                                                class="image-data form-control @error('thumbnail') is-invalid @enderror"
                                                value="{{ old('thumbnail') ?: (!empty($textLink) ? $textLink->thumbnail : '') }}"
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
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-footer clearfix">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.select2bs4').select2();
    </script>
    @include('partials.editors.summernote',['editors'=>[],'buttons'=>[]])
    @include('partials.js.rv_media',['buttonMoreImages'=>[]])
    @include('text_links.js')
@endpush


