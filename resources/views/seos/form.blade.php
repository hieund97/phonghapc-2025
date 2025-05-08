@extends('layouts.app')

@section('page-title', !empty($seo->$with->$name) ? __('Edit Seo: :title', ['title' => $seo->$with->$name]) : __('Edit Seo'))

@section('content')
    <div class="row">
        <div class="col">
            <form class="row"
                  action="{{ empty($seo) ? route('seos.store') : route('seos.update', ['seo' => $seo->id]) }}"
                  method="post">
                @csrf
                @if (!empty($seo)) @method('PUT') @endif
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
    
                                    @php 
                                        $model = old('model') ?: ($seo->model ?? null);
                                       
                                    @endphp

                                    <div class="form-group">
                                        <label for="model">{{ __('Page') }}</label>
                                        <select name="model" id="model" class="form-control select2bs4" disabled>
                                            @foreach(config("admin.seo_model") as $label)
                                                <option value="{{ $label }}" 
                                                @if($model == $label) selected @endif>
                                                {{ __($label) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>                            
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    @include('partials.forms.seo', ['model' => !empty($seo->$with) ? $seo->$with:null,'is_show'=>1])
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
                            <a href="{{ route('seos.index',['model' =>$seo->model]) }}" class="btn btn-danger">
                                <i class="fas fa-ban fa-fw"></i>
                                {{ __('Cancel') }}
                            </a>
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


@include('partials.editors.summernote',['editors'=>[],'buttons'=>[]])
@include('partials.js.rv_media',['buttonMoreImages'=>[]])


      


