@php
    $arrAttributeValue = \App\Models\Attribute::select('id', 'title')->get()->toArray();
@endphp

@foreach($arrAttributeValue as $option)
    <option value="{{ $option['id'] }}" @if(!empty($selected) && $option['id'] == $selected) selected @endif>
        {{ $option['title'] }}
    </option>
@endforeach
