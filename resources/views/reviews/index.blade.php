@extends('layouts.app')

@section('page-title', __('List of reviews'))

@section('content')
    <div class="row">
        <div class="col-md">

            @include('reviews.search')

            <div class="card">

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Review Body') }}</th>
                            <th>{{__('Product')}}</th>
                            <th>{{ __('Creator') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Rating') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($reviews as $row)
                            @if(!empty($row->product))
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td title="{{ $row->body }}">{!! Str::limit($row->body, 100) !!}</td>
                                    <td>{{ (!empty($row->product))?Str::limit($row->product->name, 30):'' }}</td>

                                    <td>{{ $row->full_name }}</td>
                                    <td>
                                        <div class="form-group clearfix margin-bottom-10">
                                            <div class="icheck-primary d-inline">
                                                <input
                                                        class="quick-update"
                                                        data-type="approved"
                                                        type="checkbox"
                                                        data-id="{{ $row->id }}"
                                                        id="approved_{{ $row->id }}"
                                                        @if ($row->approved ?? false) checked @endif>
                                                <label for="approved_{{ $row->id }}"></label>
                                            </div>
                                            Đã duyệt
                                        </div>
                                    </td>
                                    <td>{{ $row->rating }} sao</td>
                                    <td>{{ formatDateTimeShow($row->created_at) }}</td>
                                    <td>
                                        <div class="d-flex">
{{--                                            <div id="detail-action{{ $row->id }}" class="pr-1">--}}
{{--                                                <a--}}
{{--                                                        data-id="{{ $row->id }}"--}}
{{--                                                        href="javascript:"--}}
{{--                                                        class="btn btn-danger btn-sm"--}}
{{--                                                        onclick="detailShowResource(event)"--}}
{{--                                                >--}}
{{--                                                    {{ __('Detail') }}--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
                                            @can('reviews.update')
                                                <a
                                                        href="{{ route('reviews.edit', ['review' => $row->id]) }}"
                                                        class="mr-1 btn btn-warning btn-sm"
                                                >
                                                    {{ __('Edit') }}
                                                </a>
                                            @endcan
                                            @can('reviews.destroy')
                                                <a
                                                        href="javascript:"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="deleteResource('{{ route('reviews.destroy', ['review' => $row->id]) }}', '{{ route('reviews.index') }}')"
                                                >
                                                    {{ __('Delete') }}
                                                </a>
                                            @endcan
                                        </div>

                                    </td>
                                </tr>
                                @if($row->getDiscussion->count() > 0)
                                    {{--                                    @php--}}
                                    {{--                                        $discussions = $row->getDiscussion;--}}
                                    {{--                                    @endphp--}}
                                    <tr>
                                        <td colspan="10" id="detail{{ $row->id }}">

                                        </td>
                                    </tr>
                                @endif
                            @endif

                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($reviews->hasPages())
                    <div class="card-footer clearfix padding-bottom-0">
                        <div class="pagination-sm m-0 float-right">
                            {{ $reviews->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('partials.cards.delete')
@endpush

@push('scripts')
    <script>
        function detailShowResource(e) {
            var reviewID = e.target.dataset.id

            $.ajax({
                url    : "{{route('discussion.getData')}}",
                type   : 'GET',
                data   : ({
                    id: reviewID,
                }),
                success: function (data) {
                    $('#detail' + reviewID).html(data.view)
                    $('#detail-action' + reviewID)
                        .html(' <a href="javascript:" class="btn btn-danger btn-sm" data-id="' + reviewID + '" onclick="detailHideResource(event)">Ẩn</a>')

                    return
                },
            })
        }

        function detailHideResource(e) {
            var reviewID = e.target.dataset.id
            $('#table-app-' + reviewID).remove()
            $('#detail-action' + reviewID)
                .html(' <a href="javascript:" class="btn btn-danger btn-sm" data-id="' + reviewID + '" onclick="detailShowResource(event)">{{ __('Detail') }}</a>')
        }

        $(document).ready(function () {
            $('.quick-update').change(function () {
                var type = $(this).data('type')
                var id = $(this).data('id')

                if (type == 'status') {
                    var value = $(this).val()
                } else {
                    var value = $(this).is(':checked') ? 1 : 0
                }
                $.ajax({
                    url    : "{{route('reviews.quick_update')}}",
                    type   : 'POST',
                    data   : ({
                        type : type,
                        value: value,
                        id   : id,
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
            $(document).on('change', '.quick-update-discussion', function () {
                var type = $(this).data('type')
                var id = $(this).data('id')
                console.log(type)

                if (type == 'status') {
                    var value = $(this).val()
                } else {
                    var value = $(this).is(':checked') ? 1 : 0
                }
                $.ajax({
                    url    : "{{route('discussion.quick_update')}}",
                    type   : 'POST',
                    data   : ({
                        type : type,
                        value: value,
                        id   : id,
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
