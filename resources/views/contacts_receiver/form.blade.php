@extends('layouts.app')

@section('page-title', !empty($receiver) ? __('Edit contact receiver: :title', ['title' => $receiver->title]) : __('Create contact receiver'))
{{--@section('preview-page')--}}
{{--    @if(!empty($receiver))--}}
{{--        <li class="nav-item d-none d-sm-inline-block">--}}
{{--            <a--}}
{{--                    target="_blank"--}}
{{--                    href="{{ route('fe.post',["slug"=>$receiver->slug,'id'=>$receiver->id]) }}"--}}
{{--                    data-toggle="tooltip"--}}
{{--                    class="nav-link"--}}
{{--                    href="xxx"--}}
{{--            >Xem bài viết--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item d-none d-sm-inline-block">--}}
{{--            <a--}}
{{--                    data-toggle="tooltip"--}}
{{--                    title="Copy to Clipboard"--}}
{{--                    class="copy_text nav-link"--}}
{{--                    href="{{ route('fe.post',["slug"=>$receiver->slug,'id'=>$receiver->id]) }}"--}}
{{--            >Lấy link Url--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    @endif--}}
{{--@endsection--}}
@section('content')
    <div class="row">
        <div class="col">
            <form
                    class="row"
                    action="{{ empty($receiver) ? route('contacts_receiver.store') : route('contacts_receiver.update', ['contacts_receiver' => $receiver->id]) }}"
                    method="post"
            >
                @csrf
                @if (!empty($receiver)) @method('PUT') @endif
                <div class="col-md-8">
                    <div class="card">
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
                                                value="{{ old('title') ?: (!empty($receiver) ? $receiver->title : '') }}"
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
                                        <label for="description">{{ __('Description') }}</label>
                                        <span
                                                class="text-danger"
                                        >(*)
                                        </span>
                                        <div style="height: 34px;">
                                            <span class="editor-action-item" style="">
                                                <a
                                                        href="#" class="btn_gallery btn btn-primary" data-result="description"
                                                        data-multiple="true" data-action="media-insert-ckeditor"
                                                >
                                                    <i class="far fa-image"></i>
                                                    Thêm tập tin
                                                </a>
                                            </span>
                                        </div>
                                        <textarea
                                                id="description" name="description"
                                                class="form-control @error('description') is-invalid @enderror" rows="5"
                                                placeholder="Enter ..."
                                        >{{ old('description') ?: (!empty($receiver) ? $receiver->description : '') }}</textarea>
                                        @error('description')
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
                <div class="col-md-4">
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
                                            @foreach(\App\Models\ContactReceiver::STATUS as $status => $label)
                                                <option
                                                        value="{{ $status }}"
                                                        @if(old('status') == $status || (!empty($receiver) && $receiver->status == $status)) selected @endif>
                                                    {{ __("contact_receiver.status.$label") }}
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Actions') }}</h3>
                        </div>

                        <div class="card-body">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save fa-fw"></i>
                                {{ __('Save') }}
                            </button>
                            <a href="{{ route('contacts_receiver.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                {{ __('Create') }}
                            </a>
                            <a href="{{ route('contacts_receiver.index') }}" class="btn btn-danger">
                                <i class="fas fa-ban fa-fw"></i>
                                {{ __('Cancel') }}
                            </a>
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
    @include('partials.editors.summernote',['editors'=>['description'],'buttons'=>[]])
    <script src="{{ asset('tokenfield/bootstrap-tokenfield.min.js') }}"></script>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

    </script>

@endpush
