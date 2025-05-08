@extends('layouts.app')

@section('page-title', !empty($redirection) ? __('Edit redirection: :link_from', ['link_from' => $redirection->link_from]) : __('Create redirection'))

@section('content')
    <div class="row">
        <div class="col">
            <form class="card" action="{{ empty($redirection) ? route('redirections.store') : route('redirections.update', ['redirection' => $redirection->id]) }}" method="post">
                @csrf
                @if (!empty($redirection)) @method('PUT') @endif

                <div class="card-header">
                    <h3 class="card-title">
                        {{ !empty($redirection) ? __('Edit redirection: :link_from', ['link_from' => $redirection->link_from]) : __('Create redirection') }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('redirections.index') }}" class="btn btn-primary btn-sm">
                            {{ __('List of redirections') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">{{ __('Link From') }}</label><span class="text-danger">(*)</span>
                                <input
                                    id="link_from"
                                    type="text"
                                    name="link_from"
                                    class="form-control @error('link_from') is-invalid @enderror"
                                    value="{{ old('link_from') ?: (!empty($redirection) ? $redirection->link_from : '') }}"
                                    required
                                />
                                    @error('link_from')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="info">{{ __('Link To') }}</label>
                                <input
                                    id="link_to"
                                    type="text"
                                    name="link_to"
                                    class="form-control @error('link_to') is-invalid @enderror"
                                    value="{{ old('link_to') ?: (!empty($redirection) ? $redirection->link_to : '') }}"
                                    required
                                />
                                @error('link_to')
                                <span class="error invalid-feedback" style="display: block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>   
                            <div class="form-group">
                                <label for="name">{{ __('Type') }}</label><span class="text-danger">(*)</span>
                                <select id="type" name="type" class="form-control @error('type') is-invalid @enderror">
                                @foreach($redirectionType as $row)
                                    <option
                                        value="{{ $row }}"
                                        @if (old('type') == $row || (!empty($redirection) && $redirection->type == $row)))
                                        selected
                                        @endif
                                    >
                                        {{ $row }}
                                    </option>
                                @endforeach
                                </select>  
                                    @error('type')
                                    <span class="error invalid-feedback" style="display: block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div> 
                        </div>
                    </div>                  
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

