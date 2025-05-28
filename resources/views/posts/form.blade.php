@extends('layouts.app')

@section('page-title', !empty($post) ? __('Edit post: :title', ['title' => $post->title]) : __('Create Post'))

@section('preview-page')
    @if(!empty($post))
        <li class="nav-item d-none d-sm-inline-block">
            <a
                target="_blank"
                href="{{ route('fe.post',["slug"=>$post->slug,'id'=>$post->id]) }}"
                data-toggle="tooltip"
                class="nav-link"
                href="xxx"
            >Xem bài viết
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a
                data-toggle="tooltip"
                title="Copy to Clipboard"
                class="copy_text nav-link"
                href="{{ route('fe.post',["slug"=>$post->slug,'id'=>$post->id]) }}"
            >Lấy link Url
            </a>
        </li>
    @endif
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <form
                class="row"
                action="{{ empty($post) ? route('posts.store') : route('posts.update', ['post' => $post->id]) }}"
                method="post"
            >
                @csrf
                @if (!empty($post)) @method('PUT') @endif
                <div class="col-md-8">
                    <div class="card">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Title') }}</label>
                                        <span class="text-danger">(*)</span>
                                        <input
                                            id="title"
                                            type="text"
                                            name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') ?: (!empty($post) ? $post->title : '') }}"
                                            required
                                        />
                                        @error('title')
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
                                        <label for="slug">{{ __('Slug') }}</label>
                                        <input
                                            id="slug"
                                            name="slug"
                                            class="form-control @error('slug') is-invalid @enderror"
                                            value="{{ old('slug') ?: (!empty($post) ? $post->slug : '') }}"
                                        />
                                        @error('slug')
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
                                        <label for="excerpt">{{ __('Excerpt') }}</label>
                                        <span
                                            class="text-danger"
                                        >(*)
                                        </span>
                                        <textarea
                                            id="excerpt" name="excerpt"
                                            class="form-control @error('excerpt') is-invalid @enderror" rows="5"
                                            placeholder="Enter ..."
                                        >{{ old('excerpt') ?: (!empty($post) ? $post->excerpt : '') }}</textarea>
                                        @error('excerpt')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="content">{{ __('content') }}</label>
                                        <span
                                            class="text-danger"
                                        >(*)
                                        </span>
                                        <div style="height: 34px;">
                                            <span class="editor-action-item" style="">
                                                <a
                                                    href="#" class="btn_gallery btn btn-primary" data-result="content"
                                                    data-multiple="true" data-action="media-insert-ckeditor"
                                                >
                                                    <i class="far fa-image"></i>
                                                    Thêm tập tin
                                                </a>
                                            </span>
                                        </div>
                                        <textarea
                                            id="content" name="content"
                                            class="form-control @error('content') is-invalid @enderror" rows="5"
                                            placeholder="Enter ..."
                                        >{{ old('content') ?: (!empty($post) ? $post->content : '') }}</textarea>
                                        @error('content')
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
                                        <label>{{ __('Tags') }}</label>
                                        <select
                                            class="form-control select2bs4 @error('post_tags') is-invalid @enderror"
                                            id="categories"
                                            name="post_tags[]"
                                            multiple
                                        >
                                            <option value="">{{ __('Select Tag') }}</option>
                                            @include('partials.forms.post_tag_options', ['selected' => old('post_tags', !empty($post) && $post->postTags->isNotEmpty() ? $post->postTags->pluck('id')->toArray() : [])])
                                        </select>
                                        @error('post_tags')
                                        <span class="error invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    @include('partials.forms.seo', ['model' => !empty($post) ? $post:null])
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
                            <a href="{{ route('posts.index') }}" class="btn btn-danger">
                                <i class="fas fa-ban fa-fw"></i>
                                {{ __('Cancel') }}
                            </a>

                        </div>
                    </div>
                    <div class="card image-box">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Thumbnail') }} (
                                <span class="text-danger">*</span>
                                                      )
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="preview-image-wrapper img-fluid">
                                            <img
                                                class="preview_image"
                                                src="{{ old('thumbnail') ?: (!empty($post) ? get_image_url($post->thumbnail, '') : '/preview-icon.png') }}"
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
                                                value="{{ old('thumbnail') ?: (!empty($post) ? get_image_url($post->thumbnail, '') : '') }}"
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Category') }} (
                                <span class="text-danger">*</span>
                                                     )
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        @include('partials.forms.category', ['selected' => old('categories') ?: (!empty($post) ? $post->categories->pluck('id')->toArray() : null)])

                                        @error('categories')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Nổi bật') }}
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="checkbox" name="is_featured" id="is_featured" @if(!empty($post) && $post->is_featured) checked @endif>
                                        Nổi bật
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Status') }} (
                                <span class="text-danger">*</span>
                                                   )
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select
                                            name="status"
                                            id="status"
                                            class="form-control select2bs4 @error('status') is-invalid @enderror"
                                            required
                                        >
                                            @foreach(\App\Models\Post::STATUS as $status => $label)
                                                <option
                                                    value="{{ $status }}"
                                                    @if(old('status') == $status || (!empty($post) && $post->status == $status)) selected @endif>
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

@include('partials.forms.slug', [
    'fromElement' => '#title',
    'toElement' => '#slug',
])

@include('partials.js.rv_media',['buttonMoreImages'=>[]])

@push('styles')
    <link rel="stylesheet" href="{{ asset('tokenfield/css/bootstrap-tokenfield.min.css') }}">
@endpush

@push('scripts')
    @include('partials.editors.summernote',['editors'=>['content', 'excerpt'],'buttons'=>[]])
    <script src="{{ asset('tokenfield/bootstrap-tokenfield.min.js') }}"></script>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#publishedat').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        })

    </script>

@endpush
