<div class="card">

    <div class="card-body table-responsive p-0">
        <table id="table-app-{{$reviewId}}" class=" table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Review Body') }}</th>
                    <th>{{ __('Creator') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Created At') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($discussions))
                    @foreach($discussions as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td
                                title="{{ $row->body }}"
                                style="white-space: initial"
                            >{{ Str::limit($row->body, 350) }}</td>
                            <td>{{ $row->full_name }}</td>
                            <td>
                                <div class="form-group clearfix margin-bottom-10">
                                    <div class="icheck-primary d-inline">
                                        <input
                                            class="quick-update-discussion"
                                            data-type="approved"
                                            type="checkbox"
                                            data-id="{{ $row->id }}"
                                            id="approved_{{ $row->id }}"
                                            @if ($row->approved ?? false) checked @endif>
                                        <label for="approved_{{ $row->id }}"></label>
                                    </div>
                                </div>
                            </td>
                            <td>{{ formatDateTimeShow($row->created_at) }}</td>
                            <td>@can('reviews.destroy')
                                    <a
                                        href="javascript:"
                                        class="btn btn-danger btn-sm"
                                        onclick="deleteResource('{{ route('discussion.destroy', ['discussion' => $row->id]) }}', '{{ route('reviews.index') }}')"
                                    >{{ __('Delete') }}</a>@endcan</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    {{--        @if ($discussions->hasPages())--}}
    {{--            <div class="card-footer clearfix padding-bottom-0">--}}
    {{--                <div class="pagination-sm m-0 float-right">--}}
    {{--                    {{ $discussions->appends(request()->query())->links() }}--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        @endif--}}
</div>
@push('styles')
    <script>

    </script>
@endpush
