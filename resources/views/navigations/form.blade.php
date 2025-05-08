@extends('layouts.app')

@section('page-title', !empty($navigations) ? __('Edit Navigation :title', ['title' => $navigations->title]) : __('Create
Navigation'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <form class="row"
            action="{{ empty($navigations) ? route('navigations.store') : route('navigations.update', ['navigation' => $navigations->id]) }}"
            method="POST">
            @csrf
            @if (!empty($navigations)) @method('PUT') @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label><span class="text-danger">(*)</span>
                                    <input id="name" type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') ?: (!empty($navigations) ? $navigations->name : '') }}"
                                        required />
                                    @error('name')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="link">{{ __('Link') }}</label><span class="text-danger">(*)</span>
                                    <input id="link" type="text" name="link"
                                        class="form-control @error('link') is-invalid @enderror"
                                        value="{{ old('link') ?: (!empty($navigations) ? $navigations->link : '') }}"
                                        required />
                                    @error('link')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="group">{{ __('Group') }}</label><span class="text-danger">(*)</span>
                                    <select name="group" id="group"
                                        class="form-control select2bs4 @error('group') is-invalid @enderror" required>
                                        @foreach(config('admin.navigations_group') as $status => $label)
                                        <option value="{{ $status }}" @if(old('group')==$status || (!empty($navigations) &&
                                            $navigations->group == $status)) selected @endif>
                                            {{ __($label) }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('group')
                                    <span class="error invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="order">{{ __('Sort') }}</label><span class="text-danger">(*)</span>
                                    <input id="order" type="text" name="order"
                                        class="form-control @error('order') is-invalid @enderror"
                                        value="{{ old('order') ?: (!empty($navigations) ? $navigations->order : '') }}"
                                        required />
                                    @error('order')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="display_in">{{ __('Display') }}</label><span class="text-danger">(*)</span>
                                    <div class="row">
                                    <select name="display_in" id="display_in" class="form-control" style="margin: 0px 9px">
                                        @foreach(config('admin.navigation_display') as $key => $label)
                                        <option value="{{ $key }}" @if(old('display_in')==$key ||
                                            (!empty($navigations) && $navigations->display_in == $key)) selected @endif>
                                            {{ __($label) }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('display_in')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-footer clearfix">
                        <div>
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
    {{-- <div class="col-md-4">
        @include('navigations.orders')
    </div> --}}
</div>
@endsection

@push('scripts')
<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4',
    });
</script>

@endpush
