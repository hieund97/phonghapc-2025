<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Product Crawl') }}</th>
            <th class="text-nowrap">{{ __('Status') }}</th>
            <th>{{ __('Follow') }}</th>
            <th>{{ __('Last Update') }}</th>
            {{--            <th>{{ __('Created At') }}</th>--}}
            <th style="text-align:right" width=10>{{ __('Action') }}</th>
        </tr>
        </thead>

        <tbody>
        @foreach($aryCrawlData as $value)
            @php
                $myProduct          = $value->product->first();
                $myPrice            =  $myProduct->sale_price == 0 || $myProduct->sale_price == null ? $myProduct->price : $myProduct->sale_price;
                $aryCrawledProduct  = json_decode($value->info_product_url, true);
            @endphp
            <tr>
                <td>{{ $value->id }}</td>
                <td style="white-space: normal; max-width:40em;">
                    <div class="row">
                        <div class="col-md-3">
                            <img style="max-width:100%;" src="{{ get_image_url($myProduct->feature_img, 'thumb') }}">
                        </div>
                        <div class="col-md-9" style="font-size:14px;">
                            <b>Tên sản phẩm:</b> : <a target="_blank"
                                                      href="{{ route('fe.product',["slug"=>$myProduct->slug]) }}">{{ $myProduct->name }}</a>
                            <br>
                            <b>{{ __('Category') }}:</b> {{ $myProduct->productCategory->title ?? '' }}
                            <br>
                            <b>Giá sản phẩm:</b> :<span style="color:red">@money($myPrice)</span>
                        </div>
                    </div>
                </td>
                <td style="white-space: normal; max-width:45em">
                    <div class="row">
                        <div class="col-md-3">
                            <img style="max-width:100%;" src="{{ $aryCrawledProduct['image'] }}">
                        </div>
                        <div class="col-md-9" style="font-size:14px;">
                            <b>Tên sản phẩm:</b> : {{ $aryCrawledProduct['name'] }}
                            <br>
                            <b>Giá sản phẩm:</b> :<span style="color:red">@money($aryCrawledProduct['price'])</span>
                            <br>
                            <b>URL: </b> <a href="{{ $value->url }}" target="_blank">{{ $value->url }}</a>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge badge-pill badge-{{ $value->status == 1 ? 'info' : 'warning' }}">
                        {{ $value->status == 1 ? 'Trùng giá' : 'Không trùng giá' }}
                    </span>
                </td>
                @php
                    $editId = $value->id;
                @endphp
                <td style="text-align:center">
                    <div class="form-group clearfix margin-bottom-10">
                        <div class="icheck-primary d-inline">
                            <input class="quick-update" data-type="follow" type="checkbox"
                                   data-id="{{ $editId }}" id="follow_{{ $editId }}"
                                   @if ($value->follow ?? false) checked @endif>
                            <label for="follow_{{ $editId }}"></label>
                        </div>
                    </div>
                </td>
                <td>
                    {{ formatDateTimeShow($value->updated_at) }}
                </td>
                {{--                <td>{{ $value->created_at->format('d/m/Y') }}</td>--}}
                <td>
                    <div class="row" style="justify-content:right">
                        <div class="form-group clearfix margin-bottom-10" style="text-align:right;">
                            @if(empty($typeDelete))

                                @can('crawl_report.update')
                                    <a href="{{ route('crawl-report.edit', ['crawl_report' => $value->id]) }}"
                                       class="btn btn-warning btn-sm">
                                        {{ __('Edit') }}
                                    </a>
                                @endcan

                                @can('crawl_report.destroy')
                                    <a href="javascript:" class="btn btn-danger btn-sm"
                                       onclick="deleteResource('{{ route('crawl-report.destroy', ['crawl_report' => $value->id]) }}', '{{ route('crawl-report.index') }}')">
                                        {{ __('Delete') }}
                                    </a>
                                @endcan
                                <br>

                                @if($value->status == 2)
                                    <button type="button"
                                            class="btn btn-info btn-sm quick_update_price"
                                            data-id="{{ $value->id }}"
                                            data-product="{{ $myProduct->id }}"
                                            data-price="{{ $aryCrawledProduct['price'] }}"
                                    >
                                        {{ __('Quick update price') }}
                                    </button>
                                @endif

                            @else
                                <a href="javascript:" class="btn btn-warning btn-sm restore_btn_dtb"
                                   data-url="{{route('attribute.delete.restore',['id'=>$value->id])}}">
                                    {{ __('Restore') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@if ($aryCrawlData->hasPages())
    <div class="card-footer clearfix padding-bottom-0">
        <div class="pagination-sm m-0 float-right">
            {{ $aryCrawlData->links() }}
        </div>
    </div>
@endif

@push('scripts')
    <script>
        $('.quick_update_price').on('click', function () {
            let product_id = $(this).data('product');
            let price = $(this).data('price');
            let crawl_id = $(this).data('id');
            Swal.fire({
                title             : 'Bạn có chắc chắn muốn điều chỉnh giá?',
                icon              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#dd3333',
                confirmButtonText : "Cập nhật",
                cancelButtonText  : 'Huỷ',
            }).then((result) => {
                if (result.value) {
                    updatePriceByCrawlPrice(product_id, price, crawl_id);

                    setTimeout(function () {
                        location.reload()
                    }, 1500);
                }
            });
        });

        $('.quick-update').change(function () {

            var type = $(this).data('type')
            var crawl_id = $(this).data('id')

            if (type == 'status') {
                var value = $(this).val()
            } else {
                var value = $(this).is(':checked') ? 1 : 0
            }
            $.ajax({
                url    : "{{route('crawl-data.quick_update_follow')}}",
                type   : 'POST',
                data   : ({
                    type    : type,
                    value   : value,
                    crawl_id: crawl_id,
                }),
                success: function (data) {
                    if (data.status == 1) {
                        Toast.fire({
                            type : 'success',
                            title: '{{__('Update data successfully.')}}',
                        })
                    } else {
                        Toast.fire({
                            type : 'error',
                            title: '{{__('Update error data.')}}',
                        })
                    }
                    removeOverlay()
                },
            })
        })
    </script>
@endpush
