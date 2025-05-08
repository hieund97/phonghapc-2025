@extends('layouts.app')

@section('page-title', __('List of admin'))

@section('content')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('List of admin') }}</h3>

                    <div class="card-tools">
                        @include('partials.cards.search')
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Roles') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    @can('users.update')
                                        <a href="{{ route('admins.edit', ['admin' => $user->id]) }}" class="btn btn-warning btn-sm">
                                            {{ __('Edit') }}
                                        </a>
                                    @endcan

                                    @can('users.destroy')
                                        <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('users.destroy', ['user' => $user->id]) }}', '{{ route('users.index') }}')">
                                            {{ __('Delete') }}
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="card-footer clearfix padding-bottom-0">
                        <div class="pagination-sm m-0 float-right">
                            {{ $users->appends(['q' => request('q')])->links() }}
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
