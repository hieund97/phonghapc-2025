@extends('layouts.app')
@section('page-title', !empty($page) ? __('Edit page: :title', ['title' => $page->title]) : __('Create Page'))
@section('content')
    <form method="POST" action="{{ !empty($page) ? route('pages.update', ['page' => $page->id]) : route('pages.store') }}" class="card form-horizontal">
        @csrf
        @if(!empty($page)) @method('PUT') @endif

        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('pages.index') }}" class="btn btn-sm btn-primary">
                    {{ __('List') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">{{ __('Title') }} (<span class="text-danger">*</span>)</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') ?: (!empty($page) ? $page->title : null) }}" required>
                        @error('title')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }} (<span class="text-danger">*</span>)</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug" value="{{ old('slug') ?: (!empty($page) ? $page->slug : null) }}" required>
                        @error('slug')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="content">{{ __('Content') }} (<span class="text-danger">*</span>)</label>
                        @error('content')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong> </span>
                        @enderror
                        <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="10" required>{{ old('content') ?: (!empty($page) ? $page->content : null) }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    @include('partials.forms.seo', ['model' => !empty($page) ? $page:null])
                </div>
            </div>
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-sm btn-primary">
                {{ __('Save') }}
            </button>
        </div>
    </form>
@endsection

@push('styles')
    <style>
        .card-collapsable {
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
    @include('partials.forms.slug', ['fromElement' => '#title', 'toElement' => '#slug'])
    @include('partials.editors.summernote',['editors'=>['content']])
    @include('partials.js.rv_media',['buttonMoreImages'=>[]])

    <script>
        $('.card-collapsable').on('click', function () {
            $(this).CardWidget('toggle');
        });
    </script>
@endpush
