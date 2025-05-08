<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Info') }}</th>
            <th>{{ __('Module') }}</th>
            <th class="text-nowrap">{{ __('Sort') }}</th>
            <th class="text-nowrap">{{ __('Status') }}</th>
            <th>{{ __('Created At') }}</th>
            <th width=10>{{ __('Action') }}</th>
        </tr>
        </thead>

        <tbody>
        @foreach($arrAttribute as $attr)
            <tr>
                <td>{{ $attr->id }}</td>
                <td style="white-space: normal;">
                    <b>{{ $attr->title }}</b>
                </td>
                <td>
                    <b>Product</b>
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
                                        <a href="{{ route('attribute.edit', ['attribute' => $attr->id]) }}"
                                           class="btn btn-warning btn-sm">
                                            {{ __('Edit') }}
                                        </a>
                                    @endcan

                                    @can('attribute.destroy')
                                        <a href="javascript:" class="btn btn-danger btn-sm"
                                           onclick="deleteResource('{{ route('attribute.destroy', ['attribute' => $attr->id]) }}', '{{ route('attribute.index') }}')">
                                            {{ __('Delete') }}
                                        </a>
                                    @endcan
                                @else
                                    <a href="javascript:" class="btn btn-warning btn-sm restore_btn_dtb"
                                       data-url="{{route('attribute.delete.restore',['id'=>$attr->id])}}">
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

@if ($arrAttribute->hasPages())
    <div class="card-footer clearfix padding-bottom-0">
        <div class="pagination-sm m-0 float-right">
            {{ $arrAttribute->links() }}
        </div>
    </div>
@endif

@push('scripts')
    <script>
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
                    url    : "{{route('attribute.quick_update')}}",
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
        })
    </script>
@endpush
