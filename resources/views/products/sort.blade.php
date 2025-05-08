@extends('layouts.app')

@section('content')
    <form id="sort-form" method="post" action="{{ route('products.sort') }}" class="card">
        @csrf

        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                    {{ __('List') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="page_to_order">
                            {{ __('Page to order') }} (<span class="text-danger">*</span>)
                        </label>

                        <select name="type" id="page_to_order" class="form-control select2bs4 @error('type') is-invalid @enderror" required>
                            @foreach(['category', 'home'] as $page)
                                <option value="{{ $page }}" @if(old('page_to_order') == $page) selected @endif>
                                    {{ __(ucfirst($page)) }}
                                </option>
                            @endforeach
                        </select>

                        @error('type')
                        <span class="error invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_category_id">
                            {{ __('Category') }} (<span class="text-danger">*</span>)
                        </label>

                        <select name="product_category_id" id="product_category_id" class="form-control select2bs4 @error('product_category_id') is-invalid @enderror" required>
                            <option data-is-root="1" value="">{{ __('Select Category') }}</option>

                            @include('partials.forms.product_category_options', ['selected' => old('product_category_id')])
                        </select>

                        @error('product_category_id')
                            <span class="error invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row d-none">
                <div class="col-md-12">
                    @include('partials.modals.choose-products', [
                        'label' => __('Products'),
                        'name' => 'products',
                        'dataUrlFunction' => 'getDataUrl',
                        'required' => true,
                        'openModal' => 'openProductModal',
                        'afterSave' => 'chooseProductCallback',
                        'afterClose' => 'closeModalCallback',
                        'randomId' => 'hahaha',
                    ])
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Thứ tự sản phẩm (<span class="text-danger">*</span>)</label>

                        @error('orders')
                            <span class="error invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <button id="edit-products" onclick="editProducts(); return false;" style="display: none;" class="btn btn-warning btn-sm float-right">
                            {{ __('Edit Product') }}
                        </button>

                        <button id="remove-sort" onclick="removeSort(this); return false;" style="display: none;" class="btn btn-danger btn-sm float-right mr-2">
                            {{ __('Delete') }}
                        </button>
                    </div>

                    <table id="table-sort" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Id') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Category') }}</th>
                            </tr>
                        </thead>

                        <tbody id="table-data"></tbody>

                        <tfoot class="text-muted" style="font-style: italic;">
                            <tr>
                                <td colspan="3" id="table-alert" class="text-center">
                                    Vui lòng chọn danh mục.
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm float-right">
                {{ __('Save') }}
            </button>
        </div>
    </form>
@endsection

@push('styles')
    <style>
        td {
            cursor: ns-resize;
        }

        .sorting-table {
            cursor: ns-resize;
            background: #ececec;
        }

        .sorting-row {
            background: #ffffff;
            box-shadow: 0 0 16px rgba(0, 0, 0, 0.2);
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('RowSorter.js') }}"></script>

    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });

        function chooseProductCallback(randomId) {
            console.log(randomId);

            let ids = [];

            $('input[name="products[]"]').each(function () {
                ids.push($(this).val());
            });

            $('#remove-sort').hide();

            console.log(ids);

            $.get('{{ url('/cp_admin/products/sort_by_category/') }}/' + $('#product_category_id').val() + '?ids=' + ids.join(','))
                .then(function (response) {
                    createSortTable(response);
                    $('#edit-products').show();
                })
                .catch(function (e) {
                    console.log(e);

                    $('#product_category_id').val('').trigger('change');
                    $('#table-alert').text('Vui lòng chọn sản phẩm.');
                });
        }

        function closeModalCallback(randomId) {
            console.log('close modal', randomId);

            if ($('#edit-products').is(":visible")) {
                return false;
            }

            $('#product_category_id').val('').trigger('change');
            $('#table-alert').text('Vui lòng chọn sản phẩm.');
        }

        function editProducts() {
            openProductModal('product_category_id=' + $('#product_category_id').val());
        }

        function removeSort(el) {
            $.ajax({
                url: '{{ url('/cp_admin/products/remove_sort') }}/' + $(el).data('id'),
                type: 'DELETE',
                success: function(result) {
                    console.log(result);

                    window.location.href = '{{ route('products.index') }}';
                }
            });

            return false;
        }

        function createSortTable(response) {
            console.log(response);

            $('#table-data').html('');

            if (response.length > 0) {
                $.each(response, function (i, product) {
                    let html = '<tr>';

                    html += '<input type="hidden" name="orders[]" value="' + product['id'] + '">';
                    html += '<td>' + product['id'] + '</td>';
                    html += '<td class="product-name">' + product['name'] + '</td>';
                    html += '<td>' + product['product_category']['title'] + '</td>';
                    html += '</tr>';

                    $('#table-data').append(html);
                });

                $('#table-alert').html('');

                $('#table-sort').rowSorter({
                    onDragStart: function (tbody, row) {
                        $('#table-alert').html('Đang di chuyển sản phẩm: <b>' + $(row).find('.product-name').text() + '</b>');
                    },
                    onDragEnd: function (tbody, row) {
                        $('#table-alert').html('Hủy di chuyển sản phẩm: <b>' + $(row).find('.product-name').text() + '</b>');
                    },
                    onDrop: function (tbody, row, new_index, old_index) {
                        console.log(row);

                        $('#table-alert').html('Đã di chuyển sản phẩm <b>' + $(row).find('.product-name').text() + '</b> từ dòng <b>' + (old_index + 1) + '</b> sang <b>' + (new_index + 1) + '</b>');
                    },
                });
            } else {
                $('#product_category_id').val('').trigger('change');
                $('#table-alert').text('Vui lòng chọn sản phẩm.');
            }
        }

        $('#product_category_id').change(function () {
            let value = $(this).val();

            $('#table-data').html('');
            $('#values-hahaha').html('');
            $('#edit-products').hide();
            $('#remove-sort').hide();

            if (!value || value === '') {
                $('#table-alert').text('Vui lòng chọn danh mục.');
                return false;
            }

            console.log('Change product category to: ', value);

            $('#table-alert').text('Đang tải danh sách sản phẩm...');

            $.get('{{ url('/cp_admin/products/sort/') }}/' + $(this).val() + '?type=' + $('#page_to_order').val()).then(function (response) {
                console.log(response);

                if (response['products']) {
                    $.each(response['products'], function (index, data) {
                        $('#values-hahaha').append('<li><input type="hidden" value="' + data['id'] + '"></li>');
                    });

                    createSortTable(response['products']);
                    $('#edit-products').show();
                    $('#remove-sort').data('id', response['order'].id).show();
                } else {
                    openProductModal('product_categories=' + value);
                }
            }).catch(function (e) {
                console.log(e);

                $('#product_category_id').val('').trigger('change');
                $('#table-alert').text('Vui lòng chọn lại danh mục.');
            });
        });

        function hide_not_root()
        {
            let el = $('#product_category_id').find('option[data-is-root!="1"]');

            if ($('#page_to_order').val() == 'home') {
                el.wrap('span');
            } else {
                el.unwrap('span');
            }
        }

        $('#page_to_order').change(function() {
            hide_not_root();
            $('#product_category_id').val('').trigger('change');
        });

        hide_not_root();

        function getDataUrl()
        {
            let url = {
                category: '{!! url('/api/products?per_page=20&this_param_for_admin_to_get_sort=1') !!}',
                home: '{!! url('/cp_admin/products/top_items/') !!}/' + $('#product_category_id').val(),
            }

            return url[$('#page_to_order').val()];
        }
    </script>
@endpush
