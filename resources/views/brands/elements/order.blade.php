<div class="row" id="order-card" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Product Category') }}</th>
                            {{--<th>{{ __('Sort') }} (Id)</th>--}}
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach(\App\Models\BrandOrder::with('productCategory')->get() as $order)
                            <tr>
                                <td>{{ $order->productCategory->title }} (ID: {{ $order->product_category_id }})</td>
                                {{--<td>{{ implode(', ', array_reverse($order->order)) }}</td>--}}
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="openOrderForm({{ $order->id }}, {{ $order->product_category_id }})">
                                        {{ __('Edit') }}
                                    </button>

                                    <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('brands.destroyOrder', ['order' => $order->id]) }}', '{{ route('brands.index') }}')">
                                        {{ __('Delete') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer text-right">
                <button class="btn btn-success btn-sm" onclick="openOrderForm()">
                    {{ __('Add') }}
                </button>

                <button class="btn btn-primary btn-sm" onclick="toggleOrderCard()">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('footer')
    <div class="modal fade" id="orderFormModal" tabindex="-1" role="dialog" aria-labelledby="orderFormModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="order-form" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderFormModalTitle">
                        {{ __('Add/Edit Brand Order') }}
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="product_category_id">{{ __('Product Category') }}</label>
                                <select name="product_category_id" id="product_category_id" class="form-control select2bs4">
                                    <option value=""></option>
                                    @include('partials.forms.product_category_options')
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover table-sm">
                                <tbody id="order-data"></tbody>
                            </table>

                            <div id="order-result"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>

    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });

        $('#orderFormModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false,
        });

        $('#orderFormModal').on('hidden.bs.modal', function () {
            $('#product_category_id').val('').change();
            $('#order-result').html('');
        });

        $('#product_category_id').change(function () {
            $('#order-data').html('');
            loadBrands($(this).val());
        });

        $('#order-form').submit(function (e) {
            e.preventDefault();

            $.post('{{ route('brands.order') }}', $(this).serialize()).then(function (response) {
                console.log(response);
                window.location.reload();
            }).catch(function (error) {
                console.log(error);
                alert('Sắp xếp lại thứ tự trước khi lưu');
            });

            return false;
        });

        function toggleOrderCard() {
            $('#order-card').toggle();
        }

        function openOrderForm(id, category) {
            if (id) {
                $('#order-form').append('<input type="hidden" name="id" value="' + id + '">');
            }

            if (category) {
                $('#product_category_id').val(category).change();
            }

            $('#orderFormModal').modal('show');
        }

        function loadBrands(id) {
            $.get('{{ route('brands.get') }}?id=' + id, function (response) {
                $.when($.each(response, function (index, brand) {
                    $('#order-data').append('<tr data-id="' + brand['id'] + '"><td>' + brand['title'] + '</td></tr>');
                })).then(function () {
                    $('#order-data').sortable({
                        onSort: function () {
                            let order = $('#order-data').sortable('toArray').reverse();

                            $('#order-result').html('<input type="hidden" name="order" value=\'' + JSON.stringify(order) + '\'>');
                        }
                    });
                });
            });
        }
    </script>
@endpush
