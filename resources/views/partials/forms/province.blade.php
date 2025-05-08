@php
    $provinces = \App\Models\Province::get();

@endphp
<option value="">{{ __('Select') }}</option>
@foreach ($provinces as $item)
<option value="{{ $item->id }}" @if(!empty($provinceId) && $item->id == $provinceId) selected @endif>{{ $item->name }}</option>
@endforeach
