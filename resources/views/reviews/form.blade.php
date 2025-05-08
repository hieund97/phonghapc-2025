@extends('layouts.app')

@section('content')
    <form
            action="{{ empty($review) ? route('reviews.store') : route('reviews.update', ['review' => $review->id]) }}"
            method="post"
            class="card"
    >
        @csrf
        @if (!empty($review))
            @method('PUT')
        @endif
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('reviews.index') }}" class="btn btn-primary btn-sm">
                    {{ __('List') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label for="approved" class="col-sm-2 col-form-label">
                    {{ __('Is active?') }}
                </label>

                <div class="col-sm-3">
                    <select
                            name="approved"
                            class="form-control select2bs4"
                            required
                    >
                        <option
                                value="0"
                                @if($review->approved == 0) selected @endif>
                            Chưa duyệt
                        </option>
                        <option
                                value="1"
                                @if($review->approved == 1) selected @endif>
                            Duyệt
                        </option>
                    </select>
                </div>
            </div>

            {{--<div class="row">--}}
            {{--    <div class="col-md-12">--}}
            {{--        <div class="form-group">--}}
            {{--            <label for="title">{{ __('Title') }}</label>--}}

            {{--            <input--}}
            {{--                type="text"--}}
            {{--                class="form-control @error('title') is-invalid @enderror"--}}
            {{--                name="title"--}}
            {{--                id="title"--}}
            {{--                value="{{ old('title') }}"--}}
            {{--            >--}}

            {{--            @error('title')--}}
            {{--            <span class="error invalid-feedback" style="display: block" role="alert">--}}
            {{--                <strong>{{ $message }}</strong>--}}
            {{--            </span>--}}
            {{--            @enderror--}}
            {{--        </div>--}}
            {{--    </div>--}}
            {{--</div>--}}

            <div class="row">
                <div class="col-lg-4">
                    <label for="">Họ tên</label>
                    <input
                            type="text"
                            class="form-control"
                            name="full_name"
                            placeholder="Họ tên"
                            value="{{ old('full_name') ?: (!empty($review) ? $review->full_name : '') }}"
                    >
                    @error('full_name')
                    <span class="error invalid-feedback" style="display: block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4">
                    <label for="">Số điện thoại</label>
                    <input
                            type="text"
                            class="form-control"
                            name="phone_number"
                            placeholder="Số điện thoại"
                            value="{{ old('phone_number') ?: (!empty($review) ? $review->phone_number : '') }}"
                    >
                    @error('phone_number')
                    <span class="error invalid-feedback" style="display: block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-lg-4">
                    <label for="">Email</label>
                    <input
                            type="email"
                            class="form-control"
                            name="email"
                            placeholder="Email"
                            value="{{ old('email') ?: (!empty($review) ? $review->email : '') }}"
                    >
                    @error('email')
                    <span class="error invalid-feedback" style="display: block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="rating">
                            {{ __('Rating') }} (
                            <span class="text-danger">*</span>
                            )
                        </label>

                        <select
                                name="rating"
                                id="rating"
                                class="form-control @error('rating') is-invalid @enderror"
                                required
                        >
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" @if($i == old('rating', 5)) selected @endif>
                                    {{ $i . ' Sao' }}
                                </option>
                            @endfor
                        </select>

                        @error('rating')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="publish_at">{{ __('Publish At') }}</label>

                        <input
                                type="text"
                                class="form-control datetimepicker-input @error('publish_at') is-invalid @enderror"
                                id="publish_at"
                                name="publish_at"
                                value="{{ old('publish_at') }}"
                                data-toggle="datetimepicker"
                                data-target="#publish_at"
                        >

                        @error('publish_at')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @php
                        if (!empty(old('product_id'))) {
                            $products = collect()->push(old('product_id'))->filter()->map(fn($product) => ['value' => $product, 'label' => "ID: $product"])->toArray();
                        }elseif (!empty($review) && !empty($review->product)) {
                                            $products = collect([$review->product])->map(fn($product) => ['value' => $product->id, 'label' => $product->name.' - '.number_format($product->price)])->toArray();
                                        }
                    @endphp

                    @include('partials.modals.choose-products', [
                        'label' => __('Products'),
                        'name' => 'product_id',
                        'data' => $products ?? [],
                        'dataUrl' => route('products.accessories', ['type' => 'all']),
                        'single' => true,
                        'required' => true,
                    ])
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="body">
                            {{ __('Content') }} (
                            <span class="text-danger">*</span>
                            )
                        </label>

                        <textarea
                                name="body"
                                id="body"
                                class="form-control @error('body') is-invalid @enderror"
                                rows="5"
                        >{{ old('body') ?: (!empty($review) ? $review->body : '')}}</textarea>

                        @error('body')
                        <span class="error invalid-feedback" style="display: block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success btn-sm float-right" type="submit">
                {{ __('Save') }}
            </button>
        </div>
    </form>
@endsection

@push('styles')
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css"
    />
@endpush

@push('scripts')
    @include('partials.editors.summernote',['editors'=>['body'],'buttons'=>[]])
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script
            type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"
    ></script>
    <script src="{{ asset('theme/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

    <script>
        $('input[data-bootstrap-switch]').each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'))
        })

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
            icons: {
                time    : 'far fa-clock',
                date    : 'far fa-calendar',
                up      : 'far fa-arrow-up',
                down    : 'far fa-arrow-down',
                previous: 'far fa-chevron-left',
                next    : 'far fa-chevron-right',
                today   : 'far fa-calendar-check-o',
                clear   : 'far fa-trash',
                close   : 'far fa-times'
            }
        })

        $('#publish_at').datetimepicker({
            format     : 'YYYY-MM-DD HH:mm:ss',
            defaultDate: '{{ old('publish_at') }}'
        })
    </script>
@endpush
