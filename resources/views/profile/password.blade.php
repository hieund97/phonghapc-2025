@extends('layouts.app')

@section('page-title', __('Change Password'))

@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="{{ route('profile.password') }}" method="post" class="card">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="old_password">{{ __('Old Password') }}</label>
                        <input type="password" id="old_password" name="old_password" class="form-control @error('old_password') is-invalid @enderror">
                        @error('old_password')
                        <span class="error invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                        <span class="error invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">{{ __('Password Confirmation') }}</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                        @error('password_confirmation')
                        <span class="error invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm float-right">
                        {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
