<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Name') }}</th>
            <th class="text-nowrap">{{ __('Status') }}</th>
            <th>{{ __('Created At') }}</th>
            <th width=10>{{ __('Action') }}</th>
        </tr>
        </thead>

        <tbody>
        @foreach($aryGift as $gift)
            <tr>
                <td>{{ $gift->id }}</td>
                <td style="white-space: normal;">
                    <b>{{ $gift->name }}</b>
                </td>
                <td class="text-nowrap">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group clearfix margin-bottom-10">
                                <div class="icheck-primary d-inline">
                                    <select
                                            data-type="status"
                                            data-id="{{ $gift->id }}"
                                            id="status_{{ $gift->id }}"
                                            class="form-control quick-update"
                                    >
                                        @foreach(\App\Models\Gift::STATUS as $status => $label)
                                            <option value="{{ $status }}"
                                                    @if($gift->status == $status) selected @endif>
                                                {{ __("gift.status.$label") }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-nowrap">{{ formatDateTimeShow($gift->created_at) }}</td>
                <td>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group clearfix margin-bottom-10">
                                @can('attribute.update')
                                    <a href="{{ route('gift.edit', ['gift' => $gift->id]) }}"
                                       class="btn btn-warning btn-sm">
                                        {{ __('Edit') }}
                                    </a>
                                @endcan

                                @can('attribute.destroy')
                                    <a href="javascript:" class="btn btn-danger btn-sm"
                                       onclick="deleteResource('{{ route('gift.destroy', ['gift' => $gift->id]) }}', '{{ route('gift.index') }}')">
                                        {{ __('Delete') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@if ($aryGift->hasPages())
    <div class="card-footer clearfix padding-bottom-0">
        <div class="pagination-sm m-0 float-right">
            {{ $aryGift->links() }}
        </div>
    </div>
@endif


@push('scripts')
    <script>
        $(document).ready(function () {
            $('.quick-update').change(function () {

                var type = $(this).data('type')
                var gift_id = $(this).data('id')

                if (type == 'status' || type == 'order') {
                    var value = $(this).val()
                } else {
                    var value = $(this).is(':checked') ? 1 : 0
                }
                $.ajax({
                    url    : "{{route('gift.quick_update')}}",
                    type   : 'POST',
                    data   : ({
                        type        : type,
                        value       : value,
                        gift_id: gift_id,
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
