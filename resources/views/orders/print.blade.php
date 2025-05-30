@extends('layouts.print')
@section('content')
<div class="row">
  <div class="col-12">
    <!-- Main content -->
    <div class="invoice p-3 mb-3">
      <!-- title row -->
      <div class="row">
        <div class="col-12">
          <h4>
            <i class="fas fa-globe"></i> {{config('app.name')}}
          <small class="float-right">Date:{{ formatDateTimeShow($order->created_at) }}</small>
          </h4>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          {{ __('Customer') }}
          <address>
          <strong>{{$order->customer_name}}</strong><br>
          {{$order->customer_mobile}}<br>
          {{$order->customer_address}}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          {{ __('Payment') }}
          <address>
            {{number_format($order->total_price)}}<br>
            {{$order->extra_name}}<br>
            {{number_format($order->extra_price)}}<br>
            <strong> {{number_format($order->total_payment_price)}}</strong>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>{{ __('ID') }}  #{{$order->id}}</b><br>
          <br>
          <b>{{ __('Coupon Code') }}:</b> {{$order->coupon_code }}<br>
          <b>{{ __('Created At') }}:</b> {{ formatDateTimeShow($order->created_at) }}<br>
          <b>{{ __('Status') }}:</b> {{ __($orderStatus[$order->status]) }}
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      @include('orders.product')
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
          {{__('Note')}} : {{$order->customer_note}}
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.invoice -->
  </div><!-- /.col -->
</div><!-- /.row -->
@endsection
