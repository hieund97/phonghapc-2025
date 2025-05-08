@extends('layouts.app')

@section('page-title', !empty($slider) ? __('Edit slider: :title', ['title' => $slider->title]) : __('Create slider'))

@section('content')
    <div class="row">
        <div class="col">
            <form
                    class="card"
                    action="{{ empty($slider) ? route('sliders.store') : route('sliders.update', ['slider' => $slider->id]) }}"
                    method="post"
            >
                @csrf
                @if (!empty($slider))
                    @method('PUT')
                @endif

                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="slider-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tabs-info-tab" data-toggle="pill"
                               href="#tabs-info" role="tab" aria-controls="tabs-info"
                               aria-selected="true">{{ __('Info') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tabs-image-tab" data-toggle="pill"
                               href="#tabs-image" role="tab" aria-controls="tabs-image"
                               aria-selected="false">{{ __('Image') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="tabs-content-info">
                        {{--Info--}}
                        <div class="tab-pane fade show active" id="tabs-info" role="tabpanel"
                             aria-labelledby="tabs-info-tab">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">{{ __('Title') }}(
                                        <span class="text-danger">*</span>
                                        )
                                    </label>
                                    <input
                                            id="title"
                                            type="text"
                                            name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') ?: (!empty($slider) ? $slider->title : '') }}"

                                    />
                                    @error('title')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="link">{{ __('Link') }}
                                    </label>
                                    <div class="input-group">
                                        <input
                                                id="link"
                                                type="url"
                                                name="link"
                                                class="form-control float-right @error('link') is-invalid @enderror"
                                                value="{{ old('link') ?: (!empty($slider) ? $slider->link : '') }}"
                                        >
                                    </div>
                                    @error('link')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="target">{{ __('Description') }}(
                                        <span class="text-danger">*</span>
                                        )</label>
                                    <textarea
                                            id="description" name="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                    >{{ old('title') ?: (!empty($slider) ? $slider->description : '') }}</textarea>

                                    @error('description')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status">{{ __('Status') }}(
                                        <span class="text-danger">*</span>
                                        )
                                    </label>
                                    <div class="form-group">
                                        <select
                                                name="status"
                                                id="status"
                                                class="form-control select2bs4 @error('status') is-invalid @enderror"
                                                required
                                        >
                                            @foreach(config('admin.default_status') as $status => $label)
                                                <option
                                                        value="{{ $status }}"
                                                        @if(old('status') == $status || (!empty($slider) && $slider->status == $status)) selected @endif>
                                                    {{ __("$label") }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('status')
                                        <span class="error invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>

                                    @error('status')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>

                            </div>

                        </div>
                        {{--End Info--}}

                        {{--Image--}}
                        <div class="tab-pane fade" id="tabs-image" role="tabpanel"
                             aria-labelledby="tabs-image-tab">
                            @include('sliders.forms.picture',['product'=> !empty($slider) ? $slider : []])
                        </div>
                        {{--End Image--}}
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

@push('footer')
    @include('partials.modals.edit_gallery_item')
@endpush

@include('partials.editors.summernote',['editors'=>['info'],'buttons'=>[]])
@include('partials.js.rv_media',['buttonMoreImages'=>[]])
@include('text_links.js')

@push('scripts')
    @include('partials.editors.summernote',['editors'=>['description'],'buttons'=>[],'realButtons'=>[]])
    @include('partials.js.rv_media',['buttonMoreImages'=>['btn_picture','btn_real_images']])

    <script src="{{ asset('jquery.mask.min.js') }}"></script>
    <script src="{{ asset('tokenfield/bootstrap-tokenfield.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <script>
        $(function () {
            $('input[data-bootstrap-switch]').each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'))
            })

            if ($('#type').val() === '{{ \App\Models\Slider::TYPE_MOBILE }}') {
                console.log('hide desktop')
                $('.desktop-only').hide()
            } else {
                console.log('show desktop')
                $('.desktop-only').show()
            }
        })

        $('#type').change(function () {
            let el = $('.desktop-only')

            console.log('change type', $(this).val())

            if ($(this).val() === '{{ \App\Models\Slider::TYPE_MOBILE }}') {
                console.log('hide desktop')
                el.hide()
            } else {
                console.log('show desktop')
                el.show()
            }
        })
    </script>
@endpush
