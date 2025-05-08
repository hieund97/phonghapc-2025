<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th width="10%">{{ __('ID') }}</th>
            <th width="10%">{{ __('Thumbnail') }}</th>
            <th width="30%">{{ __('Info') }}</th>
            <th width="10%">{{ __('View count') }}</th>
            <th width="15%">{{ __('Price') }}</th>
            <th width="15%">{{ __('Sale') }}</th>
            <th width=10%>{{ __('Action') }}</th>
        </tr>
        </thead>

        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    <img style="max-width: 150px; word-break: normal;"
                         src="{{ get_image_url($product->feature_img, 'thumb') }}" alt="{{ $product->name }}"
                         class="image-column">
                </td>
                <td style="white-space: normal;">
                    <b>{{ $product->name }}</b>
                    <a href="javascript:"
                       onclick="showHistories('{{ route('products.logs', ['product' => $product->id]) }}')"
                       class="ml-1">
                        <i class="fas fa-fw fa-history"></i>
                    </a>
                    <br>

                    @if (!empty($product->source))
                        Loại sản phẩm:
                        <b>{{ __('products.sources.' . array_search($product->source, \App\Models\Product::SOURCES)) }}</b>
                        <br/>
                    @endif

                    {{ __('Rate') }}:
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ ($i <= $product->rate_star) ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                    ({{ $product->rate_count }})<br>

                    {{ __('Category') }}: <b>{{ $product->productCategory->title ?? '' }}</b><br>

                    {{ __('Author') }}: {{ $product->author }}
                    <br>
                    Ngày tạo:
                    <b>{{$product->created_at}}</b>
                    <br/>
                    Ngày publish:
                    <b>{{$product->published_at}}</b>
                    <br/>
                    @if(!empty($used))
                        Ngày bán:
                        <b> {{$product->date_of_sale}}</b>
                        <br/>
                    @endif
                    <a target="_blank" href="{{ Route('fe.product',["slug"=>$product->slug]) }}">
                        Link xem chi tiết </a>
                </td>
                <td>
                    <b>{{ $product->view_count }}</b>
                </td>
                <td>
                    <b>{{ number_format($product->price) }} ₫</b><br>

                    @if (!empty($product->inbox_price))
                        {{ __('Inbox price') }}: <b>{{ $product->inbox_price }} ₫</b><br>
                    @endif

                    @if (!empty($product->hide_price_label))
                        {{ __('Display as') }}: <b>{{ $product->hide_price_label }}</b>
                    @endif


                </td>

                <td>
                    @if (!empty($product->sale_price))
                        {{ __('Price') }}: <b>{{ number_format($product->sale_price) }} ₫</b><br>

                        @if (!empty($product->sale_from))
                            {{ __('From') }}: <b>{{ $product->sale_from }}</b><br>
                        @endif

                        @if (!empty($product->sale_to))
                            {{ __('To') }}: <b>{{ $product->sale_to }}</b>
                        @endif
                    @endif
                </td>

                <td>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group clearfix margin-bottom-10">
                                @if(empty($typeDelete))
                                    @can('products.update')
                                        <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                           class="btn btn-warning btn-sm">
                                            {{ __('Edit') }}
                                        </a>
                                    @endcan

                                    @can('products.destroy')
                                        <a href="javascript:" class="btn btn-danger btn-sm"
                                           onclick="deleteResource('{{ route('products.destroy', ['product' => $product->id]) }}', '{{ route('products.index') }}')">
                                            {{ __('Delete') }}
                                        </a>
                                    @endcan
                                @else
                                    <a href="javascript:" class="btn btn-warning btn-sm restore_btn_dtb"
                                       data-url="{{route('products.delete.restore',['id'=>$product->id])}}">
                                        {{ __('Restore') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        @php
                            $editId = $product->id;
                        @endphp
                        @if(empty($typeDelete))

                            <div class="col-md-12">
                                <div class="form-group clearfix margin-bottom-10">
                                    <div class="icheck-primary d-inline">
                                        <input class="quick-update" data-type="show_on_top" type="checkbox"
                                               data-id="{{ $editId }}" id="show_on_top_{{ $editId }}"
                                               @if ($product->show_on_top ?? false) checked @endif>
                                        <label for="show_on_top_{{ $editId }}">{{ __('Show on top?') }}</label>
                                    </div>
                                </div>
                            </div>
                            {{--                            <div class="col-md-12">--}}
                            {{--                                <div class="form-group clearfix margin-bottom-10">--}}
                            {{--                                    <div class="icheck-primary d-inline">--}}
                            {{--                                        <input class="quick-update" data-type="pin_to_top" type="checkbox"--}}
                            {{--                                               data-id="{{ $editId }}" id="pin_to_top_{{ $editId }}"--}}
                            {{--                                               @if ($product->pin_to_top ?? false) checked @endif>--}}
                            {{--                                        <label for="pin_to_top_{{ $editId }}">{{ __('Pin to top?') }}</label>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="col-md-12">
                                <div class="form-group clearfix margin-bottom-10">
                                    <div class="icheck-primary d-inline">
                                        <select
                                                data-type="status"
                                                data-id="{{ $editId }}"
                                                id="status_{{ $editId }}"
                                                class="form-control quick-update"
                                        >
                                            @foreach(config('admin.product_status') as $status => $label)
                                                <option value="{{ $status }}"
                                                        @if($product->status == $status) selected @endif>
                                                    {{ __("products.status.$label") }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@if ($products->hasPages())
    <div class="card-footer clearfix padding-bottom-0">
        <div class="pagination-sm m-0 float-right">
            {{ $products->links() }}
        </div>
    </div>
@endif

@push('footer')
    <div class="modal fade" id="historiesModal" tabindex="-1" role="dialog" aria-labelledby="historiesModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historiesModalTitle">{{ __('Product Histories') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Action') }}</th>
                            <th>{{ __('Changed') }}</th>
                            <th>{{ __('Time') }}</th>
                        </tr>
                        </thead>

                        <tbody id="historiesTable">
                        <tr>
                            <td></td>
                            <td class="text-right">Loading...</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        function showHistories(url) {
            $('#historiesModal').modal('show')

            $.get(url, function (response) {
                let html = ''

                console.log(response)

                $.each(response, function (index, log) {
                    html += '<tr>'
                    html += '<td>' + log['user'] + '</td>'
                    html += '<td>' + log['action'] + '</td>'
                    html += '<td><a href="javascript:" onclick="$(\'.extend-' + index + '\').toggle()"><i class="fas fa-fw fa-plus-circle"></i> {{ __('Detail') }}</a></td>'
                    html += '<td>' + log['time'] + '</td>'
                    html += '</tr>'

                    $.each(log['changed'], function (field, change) {
                        let changeFrom = String(change['from'])
                        let changeTo = String(change['to'])

                        html += '<tr class="extend-' + index + '" style="display: none;">'
                        html += '<td>' + field + '</td>'
                        html += '<td title="' + (changeFrom.length < 255 ? changeFrom : '') + '">' + changeFrom.substring(0, 60) + (changeFrom > 60 ? '...' : '') + '</td>'
                        html += '<td>---></td>'
                        html += '<td title="' + (changeTo.length < 255 ? changeTo : '') + '">' + changeTo.substring(0, 60) + (changeTo.length > 60 ? '...' : '') + '</td>'
                        html += '</tr>'
                    })
                })

                $('#historiesTable').html(html)
            })
        }

        $(document).ready(function () {
            $('.quick-update').change(function () {

                var type = $(this).data('type')
                var product_id = $(this).data('id')

                if (type == 'status') {
                    var value = $(this).val()
                } else {
                    var value = $(this).is(':checked') ? 1 : 0
                }
                $.ajax({
                    url    : "{{route('products.quick_update')}}",
                    type   : 'POST',
                    data   : ({
                        type      : type,
                        value     : value,
                        product_id: product_id,
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
            $(document).on('click', '.restore_btn_dtb', function (e) {
                e.preventDefault();
                let url = $(this).attr('data-url');
                $.post(url, function (data) {
                    if (data.status == 1) {
                        Toast.fire({
                            type : 'success',
                            title: '{{__('Restore data successfully.')}}',
                        })
                        window.location.reload();
                    } else {
                        Toast.fire({
                            type : 'error',
                            title: '{{__('Restore error data.')}}',
                        })
                    }
                })
            })
        })
    </script>
@endpush
