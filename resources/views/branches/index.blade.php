@extends('layouts.app')

@section('page-title', __('List of branches'))

@section('content')
    @include('branches.order', ['toggleBtn' => '#order-btn'])

    <div class="row">
        <div class="col-md">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('List of branches') }}</h3>
                    <div class="card-tools">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="javascript:" class="btn btn-warning btn-sm" id="order-btn">
                                    {{ __('Sort') }}
                                </a>
                            </div>

                            <div class="col-md-2">
                                <a href="{{ route('branches.create') }}" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-6" style="padding-top:4px;padding-left:0px">
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
                                <th>{{ __('Thumbnail')}}</th>
                                <th>{{ __('Address') }}</th>
                                <th>{{ __('Hotline') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($branches as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td><img src="{{$row->thumbnail}}" style="height: 5rem;"></td>
                                    <td>{{ $row->address }}</td>
                                    <td>{{ $row->hotline }}</td>
                                    <td>{{ formatDateTimeShow($row->created_at) }}</td>
                                    <td>
                                        @can('branches.update')
                                            <a href="{{ route('branches.edit', ['branch' => $row->id]) }}" class="btn btn-warning btn-sm">
                                                {{ __('Edit') }}
                                            </a>
                                        @endcan
                                        @can('branches.destroy')
                                            <a href="javascript:"
                                                class="btn btn-danger btn-sm"
                                                onclick="deleteResource('{{ route('branches.destroy', ['branch' => $row->id]) }}', '{{ route('branches.index') }}')">
                                                {{ __('Delete') }}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($branches->hasPages())
                    <div class="card-footer clearfix padding-bottom-0">
                        <div class="pagination-sm m-0 float-right">
                            {{ $branches->appends(['q' => request('q')])->links() }}
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
