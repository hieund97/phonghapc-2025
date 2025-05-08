@extends('layouts.app')

@section('page-title', __('List of sliders'))

@section('content')

    <div class="row">
        <div class="col-md">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('List of sliders') }}</h3>

                    <div class="card-tools">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="{{ route('sliders.create') }}" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-8" style="padding-top:4px;padding-left:0px">
                                @include('partials.cards.search')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($sliders as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td style="white-space: normal;">{{ $row->title }}</td>
                                <td>
                                    <div class="col-md-12">
                                        <div class="form-group clearfix margin-bottom-10">
                                            <div class="icheck-primary d-inline">
                                                <input class="quick-update" data-type="status" type="checkbox"
                                                       data-id="{{ $row->id }}" id="status_{{ $row->id }}"
                                                       @if ($row->status ?? false) checked @endif>
                                                <label for="status_{{ $row->id }}">{{ __('on') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ formatDateTimeShow($row->created_at) }}</td>
                                <td>
                                    @can('sliders.update')
                                        <a href="{{ route('sliders.edit', ['slider' => $row->id]) }}"
                                           class="btn btn-warning btn-sm">
                                            {{ __('Edit') }}
                                        </a>
                                    @endcan
                                    @can('sliders.destroy')
                                        <a href="javascript:"
                                           class="btn btn-danger btn-sm {{ $row->id == 1 || $row->id == 2 || $row->id == 3 || $row->id == 4 ? 'hidden' : '' }}"
                                           onclick="deleteResource('{{ route('sliders.destroy', ['slider' => $row->id]) }}', '{{ route('sliders.index') }}')">
                                            {{ __('Delete') }}
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($sliders->hasPages())
                    <div class="card-footer clearfix padding-bottom-0">
                        <div class="pagination-sm m-0 float-right">
                            {{ $sliders->appends(['q' => request('q')])->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('partials.cards.delete')

    <script>
        $(document).ready(function () {
            $('.quick-update').change(function () {

                var type = $(this).data('type');
                var id = $(this).data('id');
                if (type == 'sort') {
                    var value = $(this).val();
                } else {
                    var value = $(this).is(':checked') ? 1 : 0;
                }
                $.ajax({
                    url    : "{{route('sliders.quick_update')}}",
                    type   : "POST",
                    data   : ({
                        type : type,
                        value: value,
                        id   : id
                    }),
                    success: function (data) {
                        if (data.status == 1) {
                            Toast.fire({
                                type : 'success',
                                title: '{{__('Update data successfully.')}}'
                            });
                        } else {
                            Toast.fire({
                                type : 'error',
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
