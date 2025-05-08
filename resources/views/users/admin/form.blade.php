@extends('layouts.app')

@section('page-title', !empty($user) ? __('Edit admin: :name', ['name' => $user->name]) : __('Create Admin'))

@section('content')
    <div class="row">
        <div class="col">
            <form autocomplete="off" class="card" action="{{ empty($user) ? route('admins.store', ['route_name' => request('route_name')]) : route('admins.update', ['admin' => $user->id, 'route_name' => request('route_name')]) }}" method="post">
                @csrf
                @if (!empty($user)) @method('PUT') @endif

                <div class="card-header">
                    <h3 class="card-title">
                        {{ !empty($user) ? __('Edit admin: :name', ['name' => $user->name]) : __('Create Admin') }}
                    </h3>

                    <div class="card-tools">
                        <a href="{{ route(request('route_name', 'admins') . '.index') }}" class="btn btn-primary btn-sm">
                            {{ __('List of admin') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">{{ __('Display Name') }}</label>
                                <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') ?: (!empty($user) ? $user->name : '') }}"
                                        required
                                        autocomplete="off"
                                />

                                @error('name')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') ?: (!empty($user) ? $user->email : '') }}"
                                        required
                                        autocomplete="off"
                                />

                                @error('email')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="{{ __('********') }}"
                                        autocomplete="off"
                                />

                                @error('password')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @if (auth()->user()->can('users.assignRoles'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="roles">{{ __('Roles') }}</label>

                                    <select autocomplete="off" id="roles" name="roles[]" class="form-control select2bs4 @error('roles') is-invalid @enderror" multiple="multiple">
                                        @foreach($roles as $role)
                                            <option
                                                    value="{{ $role->name }}"
                                                    @if (!empty($user) && in_array($role->name, $user->roles->pluck('name')->toArray(), true))
                                                        selected
                                                    @elseif (in_array($role->name, old('roles') ?: [], true))
                                                        selected
                                                    @endif
                                            >
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('roles')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->can('users.assignPermissions'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="permissions">{{ __('Permissions') }}</label>

                                    <select autocomplete="off" id="permissions" name="permissions[]" class="form-control duallistbox @error('permissions') is-invalid @enderror" multiple="multiple">
                                        @foreach($permissions as $permission)
                                            <option
                                                    value="{{ $permission->name }}"
                                                    @if (!empty($user) && in_array($permission->name, $user->permissions->pluck('name')->toArray(), true))
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
                        </div>
                    @endif
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @include('partials.js.duallistbox')
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });
    </script>
@endpush
