@extends('layouts.app')

@section('page-title', __('List of orders'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('orders.search')

            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 10px">{{ __('ID') }}</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Total Payment Price') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orders as $row)
                                <tr>
                                    <td><a href="{{ route('orders.show', ['order' => $row->id]) }}">{{ $row->id }}</a></td>
                                    <td><b>{{ $row->customer_name }}</b></td>
                                    <td><b>{{ number_format($row->total_payment_price) }}</b></td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-group clearfix margin-bottom-10">
                                                    <a href="#" class="order-status" data-pk="{{ $row->id }}" data-value="{{ $row->status }}">
                                                        {{ __(\App\Models\Order::$ORDERSTATUS[$row->status]) }}
                                                    </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ formatDateTimeShow($row->created_at) }}</td>
                                    <td>
                                        @can('orders.show')
                                            <a href="{{ route('orders.show', ['order' => $row->id]) }}" class="btn btn-primary btn-sm">
                                                {{ __('View') }}
                                            </a>
                                        @endcan
                                        @can('orders.update')
                                            <a href="{{ route('orders.edit', ['order' => $row->id]) }}" class="btn btn-warning btn-sm">
                                                {{ __('Edit') }}
                                            </a>
                                        @endcan
                                        @can('orders.destroy')
                                            <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('orders.destroy', ['order' => $row->id]) }}', '{{ route('orders.index') }}')">
                                                {{ __('Delete') }}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>

                                    <td>
                                        <i class="fas fa-mobile fa-fw"></i> {{ $row->customer_mobile }}<br>
                                        <span title="{{ $row->customer_address }}"><i class="fas fa-map-marker fa-fw"></i> {{ Str::limit($row->customer_address, 40) }}</span><br>
                                        <span title="{{ $row->customer_note }}"><i class="fas fa-sticky-note fa-fw"></i> {!! Str::limit($row->customer_note, 40) ?: '<small><i>Không có</i></small>' !!}</span><br>
                                        <span title="{{ $row->note }}"><i class="fas fa-clipboard fa-fw"></i> {!! Str::limit($row->note, 40) ?: '<small><i>Không có</i></small>' !!}</span>
                                    </td>

                                    <td>
                                        - Tổng: <b>{{ number_format($row->total_price) }}</b><br />

                                        @if (!empty($row->bundle_saving))
                                            - Giảm từ Bundle: <b>- {{ number_format($row->bundle_saving) }}</b><br />
                                        @endif

                                        {{--- Mua th&ecirc;m: <b>{{ !empty($row->extra_name) ? ($row->extra_name . '(' . number_format($row->extra_price) . ')') : 'Không' }}</b><br />--}}
                                        - {{ __('Coupon Code') }}: <b>{{ $row->coupon_code ?: 'Không' }}</b>
                                    </td>

                                    <td>
                                        @if (!empty($row->payment_method))
                                            - {{ __($row->payment_method) }}<br />
                                        @else
                                            - Thanh toán khi nhận hàng<br />
                                        @endif

                                            - Mã đơn hàng: <b>{{ $row->order_id }}</b><br />

                                        @if (!empty($row->provider_order_id))
                                            - Mã giao dịch: <b>{{ $row->provider_order_id }}</b><br />
                                        @endif

                                        @if (!empty($row->provider_message))
                                            - Thông báo: <b>{{ $row->provider_message }}</b><br />
                                        @endif
                                    </td>

                                    <td>
                                        @foreach($row->orderProducts as $orderProduct)
                                            @if (!empty($orderProduct->product))
                                                <span title="{{ $orderProduct->product->name }}">
                                                    - {{ Str::limit($orderProduct->config_name ?? $orderProduct->product->name, 30) }}
                                                </span>
                                                <br />
                                            @endif
                                        @endforeach
                                    </td>

                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($orders->hasPages())
                    <div class="card-footer clearfix padding-bottom-0" >
                        <div class="pagination-sm m-0 float-right">
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('theme/bootstrap4-editable/css/bootstrap-editable.css') }}">
    <style>
        .editable-click {
            border-bottom: none !important;
        }
    </style>
@endpush

@push('scripts')
    @include('partials.cards.delete')
@endpush

@push('scripts')
    <script src="{{ asset('theme/bootstrap4-editable/js/bootstrap-editable.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.order-status').editable({
                type: 'select',
                url: '{{ route('orders.editable') }}',
                title: '{{ __('Select Status') }}',
                name: 'status',
                source: [
                    {value: 1, text: '{{ __('Deleted') }}'},
                    {value: 2, text: '{{ __('New') }}'},
                    {value: 3, text: '{{ __('Processing') }}'},
                    {value: 4, text: '{{ __('Cancel') }}'},
                    {value: 5, text: '{{ __('Success') }}'},
                    {value: 6, text: '{{ __('Unpaid') }}'},
                    {value: 7, text: '{{ __('Paid') }}'},
                    {value: 8, text: '{{ __('PaymentFailed') }}'},
                ],
                display: function (value, sourceData) {
                    let selected = $.fn.editableutils.itemsByValue(value, sourceData);

                    if (selected.length) {
                        selected = selected[0];
                        let orderClass;

                        switch (selected.value) {
                            case 1:
                                orderClass = 'dark';
                                break;
                            case 2:
                                orderClass = 'info';
                                break;
                            case 3:
                                orderClass = 'warning';
                                break;
                            case 4:
                                orderClass = 'danger';
                                break;
                            case 5:
                                orderClass = 'success';
                                break;
                            case 6:
                                orderClass = 'warning';
                                break;
                            case 7:
                                orderClass = 'success';
                                break;
                            case 8:
                                orderClass = 'danger';
                                break;
                        }

                        $(this).html('<span class="badge badge-' + orderClass + '">' + selected.text + '</span>');
                    } else {
                        $(this).empty();
                    }
                },
            });

            $('.quick-update').change(function () {

                var type = $(this).data('type');
                var id = $(this).data('id');

                if (type == 'status') {
                    var value = $(this).val();
                } else {
                    var value = $(this).is(':checked') ? 1 : 0;
                }
                $.ajax({
                    url: "{{route('orders.quick_update')}}",
                    type: "POST",
                    data: ({
                        type: type,
                        value: value,
                        id: id
                    }),
                    success: function (data) {
                        if (data.status == 1) {
                            Toast.fire({
                                type: 'success',
                                title: '{{__('Update data successfully.')}}'
                            });
                        } else {
                            Toast.fire({
                                type: 'error',
                                title: '{{__('Update error data.')}}'
                            });
                        }
                        removeOverlay();
                    }
                });
            });
        });
    </script>
@endpush
