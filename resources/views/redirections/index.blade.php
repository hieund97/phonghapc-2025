@extends('layouts.app')

@section('page-title', __('List of redirections'))

@section('content')
    <div class="row">
        <div class="col-md">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('List of redirections') }}</h3>

                    <div class="card-tools d-flex align-content-between justify-content-center">
                    <!--<a href="{{ route('redirections.create') }}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i>
                            {{ __('Create') }}
                        </a>-->
                        <a href="javascript:void(0)" class="btn btn-info btn-sm mr-2 d-none" onclick="onSubmitExportExcel();">
                            {{ __('Export Excel') }}
                        </a>
                        <form action="{{ route('redirection.export') }}" method="post" id="formExportRedirection">
                            @csrf
                            <input type="hidden" name="q" value="{{!empty(request()->get('q'))?request()->get('q'):''}}">
                        </form>
                        <div>
                            @include('partials.cards.search')
                        </div>

                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Link From')}}</th>
                                <th>{{ __('Link To') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($redirections as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->link_from }}</td>
                                    <td>{{ $row->link_to }}</td>
                                    <td>{{ $row->type }}</td>
                                    <td>{{ formatDateTimeShow($row->created_at) }}</td>
                                    <td>
                                        @can('redirections.update')
                                            <a href="{{ route('redirections.edit', ['redirection' => $row->id]) }}" class="btn btn-warning btn-sm">
                                                {{ __('Edit') }}
                                            </a>
                                        @endcan
                                        @can('redirections.destroy')
                                            <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('redirections.destroy', ['redirection' => $row->id]) }}', '{{ route('redirections.index') }}')">
                                                {{ __('Delete') }}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($redirections->hasPages())
                    <div class="card-footer clearfix padding-bottom-0">
                        <div class="pagination-sm m-0 float-right">
                            {{ $redirections->appends(['q' => request('q')])->links() }}
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
        function onSubmitExportExcel(){
            $('#formExportRedirection').submit();

        }
    </script>
@endpush
