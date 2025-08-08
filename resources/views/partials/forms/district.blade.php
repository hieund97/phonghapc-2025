<option value="">{{ __('Select') }}</option>
@if(!empty($provinceId))
    @php
        $districts = \App\Models\District::where('province_id','=',$provinceId)->get();
    @endphp
    @foreach ($districts as $item)
    <option value="{{ $item->id }}" @if(!empty($districtId) && $item->id == $districtId) selected @endif>{{ $item->name }}</option>
    @endforeach
@endif
