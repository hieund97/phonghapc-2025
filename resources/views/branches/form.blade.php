@extends('layouts.app')

@section('page-title', !empty($branch) ? __('Edit branch: :title', ['title' => $branch->title]) : __('Create branch'))

@section('content')
    <div class="row">
        <div class="col">
            <form class="card" action="{{ empty($branch) ? route('branches.store') : route('branches.update', ['branch' => $branch->id]) }}" method="post">
                @csrf
                @if (!empty($branch)) @method('PUT') @endif

                <div class="card-header">
                    <h3 class="card-title">
                        {{ !empty($branch) ? __('Edit branch: :title', ['title' => $branch->title]) : __('Create branch') }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('branches.index') }}" class="btn btn-primary btn-sm">
                            {{ __('List of branches') }}
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
                                    value="{{ old('title') ?: (!empty($branch) ? $branch->title : '') }}"
                                    required
                                />
                                    @error('title')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('Address') }}</label>
                                <input
                                    id="address"
                                    type="text"
                                    name="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address') ?: (!empty($branch) ? $branch->address : '') }}"
                                    required
                                />
                                @error('address')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="col-md-6">    
                            <div class="form-group">
                                <label for="hotline">{{ __('Hotline') }}</label><span class="text-danger">(*)</span>
                                <div class="input-group">    
                                    <input 
                                        id="hotline" 
                                        name="hotline" 
                                        class="form-control float-right @error('hotline') is-invalid @enderror" 
                                        value="{{ old('hotline') ?: (!empty($branch) ? $branch->hotline : '') }}"
                                        required
                                        >
                                </div>
                                @error('hotline')
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
                                <label for="name">{{ __('Thumbnail') }} </label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a data-result="image" data-action="select-image" class="btn_gallery btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> {{__('Choose')}}
                                        </a>
                                    </span>
                                    <input  id="thumbnail" 
                                            name="thumbnail" 
                                            readonly 
                                            class="image-data form-control @error('thumbnail') is-invalid @enderror" 
                                            value="{{ old('thumbnail') ?: (!empty($branch) ? $branch->thumbnail : '') }}"
                                    >
                                </div>        
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="preview-image-wrapper img-fluid">
                                    <img class="preview_image" src="{{ old('thumbnail') ?: (!empty($branch) ? $branch->thumbnail : '/preview-icon.png') }}" >
                                </div>
                            </div>
                        </div>    
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="province">{{ __('Province') }}</label> <span class="text-danger">(*)</span>

                                <select name="province" id="province" class="form-control select2bs4 @error('province') is-invalid @enderror" required>
                                    <option value=""></option>
                                    @foreach(\App\Models\Province::all(['name']) as $province)
                                        <option value="{{ $province->name }}" @if(old('province', !empty($branch->province) ? $branch->province : '') == $province->name) selected @endif>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('province')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="district">{{ __('District') }}</label> <span class="text-danger">(*)</span>

                                <select name="district" id="district" class="form-control select2bs4 @error('district') is-invalid @enderror" required>
                                    <option value=""></option>
                                    @foreach(\App\Models\District::all(['name']) as $district)
                                        <option value="{{ $district->name }}" @if(old('district', !empty($branch->district) ? $branch->district : '') == $district->name) selected @endif>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('district')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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

@push('scripts')
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });
    </script>
@endpush
