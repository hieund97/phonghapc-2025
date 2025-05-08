@php
    $options = Cache::rememberForever('product_tag_options', function() {
        $nodes = App\Models\ProductTag::all();
        return $nodes;
    })
@endphp

@foreach($options as $option)
   
    <option
        value="{{ $option['id'] }}"
        @if (!empty($selected) && in_array($option['id'], Arr::wrap($selected)))
        selected
        @endif
    >
        {{ $option['title'] }}
    </option>
@endforeach
