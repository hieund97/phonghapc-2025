<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Info') }}</th>
            <th>{{ __('Attribute_category') }}</th>
            <th class="text-nowrap">{{ __('Sort') }}</th>
            <th class="text-nowrap">{{ __('Status') }}</th>
            <th>{{ __('Created At') }}</th>
            <th width=10>{{ __('Action') }}</th>
        </tr>
        </thead>

        <tbody>
        @foreach($arrAttributeValue as $attr)
            @php
                if(empty($attr->attrCate)) {
                    continue;
                }
            @endphp
            <tr>
                <td>{{ $attr->id }}</td>
                <td style="white-space: normal;">
                    <b>{{ $attr->title }}</b>
                </td>
                <td>
                    {{ $attr->attrCate->title }}
                </td>
                <td>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input
                                        style="max-width: 70px;"
                                        type="text"
                                        class="form-control quick-update"
                                        value="{{ $attr->order }}"
                                        data-type="order"
                                        data-id="{{ $attr->id }}"
                                        id="sort_{{ $attr->id }}"
                                />
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-nowrap">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group clearfix margin-bottom-10">
                                <div class="icheck-primary d-inline">
                                    <select
                                            data-type="status"
                                            data-id="{{ $attr->id }}"
                                            id="status_{{ $attr->id }}"
                                            class="form-control quick-update"
                                    >
                                        @foreach(\App\Models\Attribute::STATUS as $status => $label)
                                            <option value="{{ $status }}"
                                                    @if($attr->status == $status) selected @endif>
                                                {{ __("attribute.status.$label") }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-nowrap">{{ formatDateTimeShow($attr->created_at) }}</td>
                <td>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group clearfix margin-bottom-10">
                                @if(empty($typeDelete))
                                    @can('attribute.update')
                                        <a href="{{ route('attribute_value.edit', ['attribute_value' => $attr->id]) }}"
                                           class="btn btn-warning btn-sm">
                                            {{ __('Edit') }}
                                        </a>
                                    @endcan

                                    @can('attribute.destroy')
                                        <a href="javascript:" class="btn btn-danger btn-sm"
                                           onclick="deleteResource('{{ route('attribute_value.destroy', ['attribute_value' => $attr->id]) }}', '{{ route('attribute_value.index') }}')">
                                            {{ __('Delete') }}
                                        </a>
                                    @endcan
                                @else
                                    <a href="javascript:" class="btn btn-warning btn-sm restore_btn_dtb"
                                       data-url="{{route('attribute_value.delete.restore',['id'=>$attr->id])}}">
                                        {{ __('Restore') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@if ($arrAttributeValue->hasPages())
    <div class="card-footer clearfix padding-bottom-0">
        <div class="pagination-sm m-0 float-right">
            {{ $arrAttributeValue->links() }}
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
                var attribute_id = $(this).data('id')

                if (type == 'status' || type == 'order') {
                    var value = $(this).val()
                } else {
                    var value = $(this).is(':checked') ? 1 : 0
                }
                $.ajax({
                    url    : "{{route('attribute_value.quick_update')}}",
                    type   : 'POST',
                    data   : ({
                        type        : type,
                        value       : value,
                        attribute_id: attribute_id,
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
