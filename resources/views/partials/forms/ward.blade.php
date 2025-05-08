

<option value="">{{ __('Select') }}</option>
@if(!empty($districtId))
    @php
    $wards = \App\Models\Ward::where('district_id','=',$districtId)->get();
    @endphp
    @foreach ($wards as $item)
    <option value="{{ $item->id }}" @if(!empty($wardId) && $item->id == $wardId) selected @endif>{{ $item->name }}</option>
    @endforeach
@endif