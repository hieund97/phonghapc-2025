@extends('layouts.app')

@section('page-title', !empty($contact) ? __('Edit contact receiver: :title', ['title' => $contact->fullname]) : __('Create contact receiver'))
{{--@section('preview-page')--}}
{{--    @if(!empty($contact))--}}
{{--        <li class="nav-item d-none d-sm-inline-block">--}}
{{--            <a--}}
{{--                    target="_blank"--}}
{{--                    href="{{ route('fe.post',["slug"=>$receiver->slug,'id'=>$receiver->id]) }}"--}}
{{--                    data-toggle="tooltip"--}}
{{--                    class="nav-link"--}}
{{--                    href="xxx"--}}
{{--            >Xem bài viết--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item d-none d-sm-inline-block">--}}
{{--            <a--}}
{{--                    data-toggle="tooltip"--}}
{{--                    title="Copy to Clipboard"--}}
{{--                    class="copy_text nav-link"--}}
{{--                    href="{{ route('fe.post',["slug"=>$receiver->slug,'id'=>$receiver->id]) }}"--}}
{{--            >Lấy link Url--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    @endif--}}
{{--@endsection--}}
@section('content')
    <div class="row">
        <div class="col">
            <form
                    class="row"
                    action="{{ empty($contact) ? route('contacts.store') : route('contacts.update', ['contact' => $contact->id]) }}"
                    method="post"
            >
                @csrf
                @if (!empty($contact)) @method('PUT') @endif
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            {{--Fullname--}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fullname">{{ __('Fullname') }}</label>
                                        <span class="text-danger">(*)</span>
                                        <input
                                                id="fullname"
                                                type="text"
                                                name="fullname"
                                                class="form-control @error('fullname') is-invalid @enderror"
                                                value="{{ old('fullname') ?: (!empty($contact) ? $contact->fullname : '') }}"
                                                required
                                        />
                                        @error('fullname')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{--End Fullname--}}

                            {{--Contact Receiver --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="contact_receiver_id">{{ __('Contact receiver') }}</label>
                                        <span class="text-danger">(*)</span>
                                        <select
                                                name="contact_receiver_id"
                                                id="contact_receiver_id"
                                                class="form-control select2bs4 @error('contact_receiver_id') is-invalid @enderror"
                                                required
                                        >
                                            @foreach($aryContactReceiver as $key => $contactReceiver)
                                                <option
                                                        value="{{ $contactReceiver->id }}"
                                                        @if( old('contact_receiver_id') == $contactReceiver->id || (!empty($contact) && $contact->contact_receiver_id == $contactReceiver->id) ) selected @endif>
                                                    {{ $contactReceiver->title }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('contact_receiver_id')
                                        <span class="error invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{--End Contact Receiver--}}

                            {{--Address--}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">{{ __('Address') }}</label>
                                        <span class="text-danger">(*)</span>
                                        <input
                                                id="address"
                                                type="text"
                                                name="address"
                                                class="form-control @error('address') is-invalid @enderror"
                                                value="{{ old('address') ?: (!empty($contact) ? $contact->address : '') }}"
                                                required
                                        />
                                        @error('address')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{--End Address--}}

                            {{--Important Level--}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="is_important">{{ __('Important level') }}</label>
                                        <span class="text-danger">(*)</span>
                                        <select
                                                name="is_important"
                                                id="is_important"
                                                class="form-control select2bs4 @error('is_important') is-invalid @enderror"
                                                required
                                        >
                                            @foreach(\App\Models\Contact::IMPORTANT as $key => $label)
                                                <option
                                                        value="{{ $key }}"
                                                        @if(old('is_important') == $key || (!empty($contact) && $contact->is_important == $key)) selected @endif>
                                                    {{ __("contact.important.$label") }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('is_important')
                                        <span class="error invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{--End Important Level--}}

                            {{--Note--}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="note">{{ __('Note') }}</label>
                                        <textarea
                                                id="note" name="note"
                                                class="form-control @error('note') is-invalid @enderror" rows="5"
                                                placeholder="Enter ..."
                                        >{{ old('note') ?: (!empty($contact) ? $contact->note : '') }}</textarea>
                                        @error('note')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{--End Note--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    {{--Action--}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Actions') }}</h3>
                        </div>

                        <div class="card-body">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save fa-fw"></i>
                                {{ __('Save') }}
                            </button>
                            <a href="{{ route('contacts.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                {{ __('Create') }}
                            </a>
                            <a href="{{ route('contacts.index') }}" class="btn btn-danger">
                                <i class="fas fa-ban fa-fw"></i>
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </div>
                    {{--End Action--}}

                    {{--Contact info--}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Contact info') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            {{--Email--}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Email') }}</label>
                                        <span class="text-danger">(*)</span>
                                        <input
                                                id="email"
                                                type="email"
                                                name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') ?: (!empty($contact) ? $contact->email : '') }}"
                                                required
                                        />
                                        @error('email')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{--End Email--}}

                            {{--Phone number--}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="phone_number">{{ __('Phone number') }}</label>
                                        <input
                                                id="phone_number"
                                                type="text"
                                                name="phone_number"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                value="{{ old('phone_number') ?: (!empty($contact) ? $contact->phone_number : '') }}"
                                                required
                                        />
                                        @error('phone_number')
                                        <span class="error invalid-feedback" style="display: block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{--End Phone number--}}
                        </div>
                    </div>
                    {{--End Contact info--}}

                    {{--Status--}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Status') }} (
                                <span class="text-danger">*</span>
                                )
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select
                                                name="status"
                                                id="status"
                                                class="form-control select2bs4 @error('status') is-invalid @enderror"
                                                required
                                        >
                                            @foreach(\App\Models\Contact::STATUS as $status => $label)
                                                <option
                                                        value="{{ $status }}"
                                                        @if(old('status') == $status || (!empty($contact) && $contact->status == $status)) selected @endif>
                                                    {{ __("contact.status.$label") }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('status')
                                        <span class="error invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--End Status--}}
                </div>
            </form>
        </div>
    </div>
@endsection

@include('partials.forms.slug', [
    'fromElement' => '#title',
    'toElement' => '#slug',
])

@include('partials.js.rv_media',['buttonMoreImages'=>[]])

@push('styles')
    <link rel="stylesheet" href="{{ asset('tokenfield/css/bootstrap-tokenfield.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('tokenfield/bootstrap-tokenfield.min.js') }}"></script>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>

@endpush
