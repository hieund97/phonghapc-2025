@php
    $options = Cache::rememberForever('product_category_options', function() {
        $nodes = App\Models\ProductCategory::get()->toTree();

        $traverse = function ($categories, $prefix = '') use (&$traverse) {
            $result = [];

            foreach ($categories as $category) {
                $result[] = [
                    'id' => $category->id,
                    'title' => $prefix.' '.$category->title,
                    '_lft' => $category->_lft,
                    '_rgt' => $category->_rgt,
                    'has_child' => $category->children->isNotEmpty(),
                    'type' => $category->type,
                    'is_root' => empty($category->parent),
                ];

                $result = array_merge($result, $traverse($category->children, $prefix.'-'));
            }

            return $result;
        };

        return $traverse($nodes);
    })
@endphp

@foreach($options as $option)
    @if (!empty($current->_lft) && !empty($current->_rgt))
        @if($option['_lft'] >= $current->_lft && $option['_rgt'] <= $current->_rgt)
            @continue
        @endif
    @endif

    <option
            data-type="{{ $option['type'] }}"
            data-is-root="{{ $option['is_root'] }}"
            value="{{ $option['id'] }}"
            class="option-category"
            @if(!empty($current->parent_id) && $option['id'] == $current->parent_id)
            selected
            @elseif (!empty($selected) && is_array($selected) && in_array($option['id'], $selected))
            selected
            @endif
            {{--        @if (!empty($disableParents) && $option['has_child']) disabled @endif--}}
    >
        {{ $option['title'] }}
    </option>
@endforeach
