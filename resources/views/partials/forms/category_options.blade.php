@php
    $options = Cache::rememberForever('category_options', function() {
        $nodes = \App\Models\Category::get()->toTree();

        $traverse = function ($categories, $prefix = '') use (&$traverse) {
            $result = [];

            foreach ($categories as $category) {
                $result[] = [
                    'id' => $category->id,
                    'title' => $prefix.' '.$category->title
                ];

                $result = array_merge($result, $traverse($category->children, $prefix.'-'));
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
