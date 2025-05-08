@extends('layouts.app')

@section('page-title', !empty($brand) ? __('Edit brand: :title', ['title' => $brand->title]) : __('Create brand'))

@section('content')
    <div class="row">
        <div class="col">
            <form class="card" action="{{ empty($brand) ? route('brands.store') : route('brands.update', ['brand' => $brand->id]) }}" method="post">
                @csrf
                @if (!empty($brand)) @method('PUT') @endif

                <div class="card-header">
                    <h3 class="card-title">
                        {{ !empty($brand) ? __('Edit brand: :title', ['title' => $brand->title]) : __('Create brand') }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('brands.index') }}" class="btn btn-primary btn-sm">
                            {{ __('List of brands') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{ __('Title') }}</label><span class="text-danger">(*)</span>
                                <input
                                    id="title"
                                    type="text"
                                    name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') ?: (!empty($brand) ? $brand->title : '') }}"
                                    required
                                />
                                    @error('title')
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
                                >{{ old('description') ?: (!empty($brand) ? $brand->description : '') }}</textarea>
                                @error('description')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">{{ __('Slug') }}</label><span class="text-danger">(*)</span>
                                <input
                                        id="slug"
                                        type="text"
                                        name="slug"
                                        class="form-control @error('slug') is-invalid @enderror"
                                        value="{{ old('slug') ?: (!empty($brand) ? $brand->slug : '') }}"
                                        required
                                />
                                @error('slug')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="product_category_id">{{ __('Category') }}</label><span class="text-danger">(*)</span>
                                <select  id="product_category_id" 
                                         name="product_category_id" 
                                        class="form-control @error('product_category_id') is-invalid @enderror">
                                    <option
                                        value=""
                                    >
                                        {{ __('Select') }}
                                    </option>
                                @foreach($productCategories as $row)
                                    <option
                                        value="{{ $row->id }}"
                                        @if (old('product_category_id') == $row->id || (!empty($brand) && $brand->product_category_id == $row->id)))
                                        selected
                                        @endif
                                    >
                                        {{ $row->title }}
                                    </option>
                                @endforeach
                                </select>  
                                    @error('product_category_id')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div> 
                        </div>
                    </div>  
                    <div class="row image-box">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{ __('Thumbnail') }} </label><span class="text-danger">(*)</span>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a data-result="image" data-action="select-image" class="btn_gallery btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> {{__('Choose')}}
                                        </a>
                                    </span>
                                    <input id="thumbnail" name="thumbnail" readonly class="image-data form-control @error('thumbnail') is-invalid @enderror" value="{{ old('thumbnail') ?: (!empty($brand) ? $brand->thumbnail : '') }}">
                                </div>        
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="preview-image-wrapper img-fluid">
                                    <img class="preview_image" src="{{ old('thumbnail') ?: (!empty($brand) ? $brand->thumbnail : '/preview-icon.png') }}" >
                                </div>
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
@include('partials.js.rv_media',['buttonMoreImages'=>[]])
@include('partials.forms.slug', ['fromElement' => '#title', 'toElement' => '#slug'])
