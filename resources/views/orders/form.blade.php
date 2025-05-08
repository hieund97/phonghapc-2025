@extends('layouts.app')

@section('page-title', !empty($order) ? __('Edit order: :customer_name', ['customer_name' => $order->customer_name]) : __('Create order'))

@section('content')
    <div class="row">
        <div class="col">
            <form class="card" action="{{ empty($order) ? route('orders.store') : route('orders.update', ['order' => $order->id]) }}" method="post">
                @csrf
                @if (!empty($order)) @method('PUT') @endif

                <div class="card-header">
                    <h3 class="card-title">
                        {{ !empty($order) ? __('Edit order: :customer_name', ['customer_name' => $order->customer_name]) : __('Create order') }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">
                            {{ __('List of orders') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ __('Customer Name') }}</label><span class="text-danger">(*)</span>
                                <input
                                    id="customer_name"
                                    name="customer_name"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    value="{{ old('customer_name') ?: (!empty($order) ? $order->customer_name : '') }}"
                                    required
                                />
                                    @error('customer_name')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>                 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ __('Mobile') }}</label><span class="text-danger">(*)</span>
                                <input
                                    id="customer_mobile"
                                    name="customer_mobile"
                                    class="form-control @error('customer_mobile') is-invalid @enderror"
                                    value="{{ old('customer_mobile') ?: (!empty($order) ? $order->customer_mobile : '') }}"
                                    required
                                />
                                    @error('customer_mobile')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>   
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ __('Address') }}</label><span class="text-danger">(*)</span>
                                <input
                                    id="customer_address"
                                    name="customer_address"
                                    class="form-control @error('customer_address') is-invalid @enderror"
                                    value="{{ old('customer_address') ?: (!empty($order) ? $order->customer_address : '') }}"
                                    required
                                />
                                    @error('customer_address')
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
                                <label for="name">{{ __('Note') }}</label>
                                <textarea id="note" name="note" class="form-control @error('note') is-invalid @enderror" rows="5" placeholder="Enter ...">{{ old('note') ?: (!empty($order) ? $order->note : '') }}</textarea>
                                @error('note')
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
                                <label for="name">{{ __('Customer Note') }}</label>
                                <textarea id="customer_note" name="customer_note" class="form-control @error('customer_note') is-invalid @enderror" rows="5" placeholder="Enter ...">{{ old('customer_note') ?: (!empty($order) ? $order->customer_note : '') }}</textarea>
                                @error('customer_note')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ __('Total Price') }}</label><span class="text-danger">(*)</span>
                                <input
                                    id="total_price"
                                    name="total_price"
                                    class="form-control @error('total_price') is-invalid @enderror"
                                    value="{{ old('total_price') ?: (!empty($order) ? $order->total_price : '') }}"
                                    required
                                />
                                    @error('total_price')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>                 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ __('Extra Name') }}</label>
                                <input
                                    id="extra_name"
                                    name="extra_name"
                                    class="form-control @error('extra_name') is-invalid @enderror"
                                    value="{{ old('extra_name') ?: (!empty($order) ? $order->extra_name : '') }}"
                                    
                                />
                                    @error('extra_name')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>   
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ __('Extra Price') }}</label>
                                <input
                                    id="extra_price"
                                    name="extra_price"
                                    class="form-control @error('extra_price') is-invalid @enderror"
                                    value="{{ old('customer_address') ?: (!empty($order) ? $order->extra_price : '') }}"
                                    
                                />
                                    @error('extra_price')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>   
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ __('Total Payment Price') }}</label><span class="text-danger">(*)</span>
                                <input
                                    id="total_payment_price"
                                    name="total_payment_price"
                                    class="form-control @error('total_payment_price') is-invalid @enderror"
                                    value="{{ old('total_payment_price') ?: (!empty($order) ? $order->total_payment_price : '') }}"
                                    required
                                />
                                    @error('total_payment_price')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>                 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ __('Coupon Code') }}</label>
                                <input
                                    id="coupon_code"
                                    name="coupon_code"
                                    class="form-control @error('coupon_code') is-invalid @enderror"
                                    value="{{ old('coupon_code') ?: (!empty($order) ? $order->coupon_code : '') }}"
                                    
                                />
                                    @error('coupon_code')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>   
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">{{ __('Status') }}</label><span class="text-danger">(*)</span>
                                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option
                                        value=""
                                    >
                                        {{ __('Select') }}
                                    </option>
                                @foreach($orderStatus as $key=>$row)
                                    <option
                                        value="{{ $key }}"
                                        @if (old('status') == $key || (!empty($order) && $order->status == $key)))
                                        selected
                                        @endif
                                    >
                                        {{ __($row) }}
                                    </option>
                                @endforeach
                                </select>  
                                    @error('status')
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
                                        <a  data-result="image" data-action="select-image" class="btn_gallery btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> {{__('Choose')}}
                                        </a>
                                    </span>
                                    <input id="thumbnail" name="thumbnail" readonly class="image-data form-control @error('thumbnail') is-invalid @enderror" value="{{ old('thumbnail') ?: (!empty($order) ? $order->thumbnail : '') }}">
                                </div>        
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="preview-image-wrapper img-fluid">
                                    <img class="preview_image" src="{{ old('thumbnail') ?: (!empty($order) ? get_image_url($order->thumbnail, '') : '/preview-icon.png') }}" style="height: 5rem;">
                                </div>
                            </div>
                        </div>    
                    </div>
                    @include('orders.product')
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
