@php
    $options = Cache::rememberForever('attribute_value_options', function() {
        $nodes = \App\Models\AttributeValue::get()->toTree();

        $traverse = function ($arrAttribute, $prefix = '') use (&$traverse) {
            $result = [];

            foreach ($arrAttribute as $attribute) {
                $result[] = [
                    'id'    => $attribute->id,
                    'title' => $prefix.' '.$attribute->title
                ];

                //$result = array_merge($result, $traverse($attribute->children, $prefix.'-'));
            }

            return $result;
        };

        return $traverse($nodes);
    })
@endphp

@foreach($options as $option)
    <option value="{{ $option['id'] }}" @if(!empty($selected) && $option['id'] == $selected) selected @endif>
        {{ $option['title'] }}
    </option>
@endforeach
