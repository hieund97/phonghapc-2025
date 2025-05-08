@extends('layouts.app')

@section('page-title', __('System logs'))

@section('content')
<div class="row">
        <div class="col-md">  

            @include('setting.search')
            
            <div class="card">
                
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Info') }}</th>
                                <th>{{ __('Input') }}</th>
                                <!--<th>{{ __('Action') }}</th> -->
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($logs as $row)
                                <tr>
                                    <td>
                                        {{ $row->user->name }}<br>
                                        ({{ $row->created_at }}) <br>
                                        {{ logMethodDisplay($row->method) }}<br>
                                        <span class="badge badge-info">{{ $row->path }}</span> <br>
                                        <span class="badge badge-primary">{{ $row->ip }}</span> <br>
                                    </td>
                              
                                    <td class="text-log">{{ logInputDisplay($row->input) }}</td>
                                    
                                   <!-- <td>
                                        @can('settings.destroy')
                                            <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('settings.destroy', ['setting' => $row->id]) }}', '{{ route('settings.log') }}')">
                                                {{ __('Delete') }}
                                            </a>
                                        @endcan
                                    </td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($logs->hasPages())
                    <div class="card-footer clearfix padding-bottom-0" >
                        <div class="pagination-sm m-0 float-right">
                            {{ $logs->appends(request()->query())->links() }}
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
