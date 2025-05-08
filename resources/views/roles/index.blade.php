@extends('layouts.app')

@section('page-title', __('Roles Manager'))
@push('styles')
@endpush
@section('content')
    @cannot('roles.update')
        @php $currentRole = null @endphp
    @endcannot

    @php
        $showForm = true;

        if (!request()->user()->can('roles.store')) {
            $showForm = false;
        }

        if (!empty($currentRole)) {
            $showForm = request()->user()->can('roles.update');
        }
    @endphp

    <div class="row">
        @if ($showForm)
            <div class="col-md ">
                <form method="post" class="card h-100" action="{{ !empty($currentRole) ? route('roles.update', ['role' => $currentRole->id]) : route('roles.store') }}">
                    @csrf
                    @if (!empty($currentRole)) @method('PUT') @endif

                    <div class="card-header">
                        <h3 class="card-title">
                            {{ !empty($currentRole) ? __('Edit Role: :name', ['name' => $currentRole->name]) : __('Create Role') }}
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ __('Role Name') }}</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') ?: (!empty($currentRole) ? $currentRole->name : '') }}"
                                required
                            />

                            @error('name')
                            <span class="error invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="guard_name">{{ __('Guard Name') }}</label>
                            <select id="guard_name" name="guard_name" class="form-control @error('guard_name') is-invalid @enderror">
                                @foreach(array_keys(config('auth.guards')) as $guard)
                                    <option value="{{ $guard }}" @if(old('guard_name')) {{ old('guard_name') == $guard ? 'selected' : '' }} @else {{ (!empty($currentRole) && $currentRole->guard_name == $guard) ? 'selected' : '' }} @endif>
                                        {{ $guard }}
                                    </option>
                                @endforeach
                            </select>

                            @error('guard_name')
                            <span class="error invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="permissions">{{ __('Permissions') }}</label>

                            <input type="hidden" name="permissions[]" value="dashboard.index">
                            <select id="permissions" name="permissions[]" class="form-control duallistbox @error('permissions') is-invalid @enderror" multiple="multiple">
                                @foreach($permissions as $permission)
                                    <option
                                        value="{{ $permission->name }}"
                                        @if($permission->name == 'dashboard.index')
                                        selected disabled
                                        @elseif (!empty($currentRole) && in_array($permission->name, $currentRole->permissions->pluck('name')->toArray(), true))
                                        selected
                                        @elseif (in_array($permission->name, old('permissions') ?: [], true))
                                        selected
                                        @endif
                                    >
                                        {{ __($permission->name) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('permissions')
                            <span class="error invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="float-right">
                            @if (!empty($currentRole))
                                <a href="{{ route('roles.index') }}" class="btn btn-danger btn-sm">
                                    {{ __('Cancel') }}
                                </a>
                            @endif

                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('List of roles') }}</h3>

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
                                <th>{{ __('Guard Name') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($roles as $role)
                                <tr @if(!empty($currentRole) && $currentRole->id == $role->id) {!! 'style="background: rgba(0,0,0,.05);"' !!} @endif>
                                    <td>{{ $role->id }}</td>
                                    <td><b>{{ $role->name }}</b></td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>
                                        @if ($role->name != 'Super Admin')
                                            @can('roles.update')
                                                <a href="{{ route('roles.index', ['id' => $role->id]) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                                            @endcan

                                            @can('roles.destroy')
                                                <a href="javascript:" onclick="deleteResource('{{ route('roles.destroy', ['role' => $role->id]) }}', '{{ route('roles.index') }}')" class="btn btn-danger btn-sm">{{ __('Delete') }}</a>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($roles->hasPages())
                    <div class="card-footer clearfix padding-bottom-0">
                        <div class="pagination-sm m-0 float-right">
                            {{ $roles->appends(['q' => request('q')])->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    @include('partials.js.duallistbox')
    @include('partials.cards.delete')

@endpush
