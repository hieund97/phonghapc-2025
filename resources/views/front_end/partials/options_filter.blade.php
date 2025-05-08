@if(isset($category) && !empty($category->attribute))
    @php
        $listSelectedAttributeId = [];
        $listSelectAttributeValues= [];
        if(isset($isFilterCategory) && $isFilterCategory) {
            foreach ($aryProduct as $product) {
                foreach ($product->attribute as $attrValue) {
                    if (empty($attrValue->attrCate)) {
                        continue;
                    }
                    $listSelectedAttributeId[] = $attrValue->attrCate->id;
                    $listSelectAttributeValues[] = $attrValue->id;
                }
            }
        }else {
            foreach ($category->attribute as $attrValue) {
                if (empty($attrValue->attrCate)) {
                    continue;
                }
                $listSelectedAttributeId[] = $attrValue->attrCate->id;
                $listSelectAttributeValues[] = $attrValue->id;
            }
        }

        $listSelectedAttributeId = array_unique($listSelectedAttributeId);
        $listSelectAttributeValues = array_unique($listSelectAttributeValues);

    @endphp
    @foreach($listAllAttribute as $attribute)
        @php
            if(!in_array($attribute->id, $listSelectedAttributeId)) {
                continue;
            }
        @endphp
        <div class="filter-item filter-attribute">
            <p class="title">{{ $attribute->title }}</p>
            <div class="filter-list">
                @foreach($attribute->attrValue as $value)
                    @php
                        if(!in_array($value->id, $listSelectAttributeValues)) {
                            continue;
                        }
                    @endphp
                    <label style="cursor:pointer" class="label-attribute">
                        <input type="checkbox"
                               {{ isset($selected) && is_array($selected) && in_array($value->id, $selected) ? 'checked' : '' }} class="attr-checkbox-filter attr-checkbox"
                               data-category="{{ $category->id }}"
                               data-build="{{ $isBuild }}"
                               value="{{ $value->id }}">
                        <span>{{ $value->title }}</span>
                    </label>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
@else
    @php
        $listSelectedAttributeId = [];
        $listSelectAttributeValues= [];
        if(!empty($aryProduct)) {
            foreach ($aryProduct as $product) {
                foreach ($product->attribute as $attrValue) {
                    if (empty($attrValue->attrCate)) {
                        continue;
                    }
                    $listSelectedAttributeId[] = $attrValue->attrCate->id;
                    $listSelectAttributeValues[] = $attrValue->id;
                }
            }
        }
    @endphp
    @foreach($listAllAttribute as $attribute)
        @php
            if(!in_array($attribute->id, $listSelectedAttributeId) && !empty($aryProduct)) {
                continue;
            }
        @endphp
        <div class="filter-item filter-attribute">
            <p class="title">{{ $attribute->title }}</p>
            <div class="filter-list">
                @foreach($attribute->attrValue as $value)
                    @php
                        if(!in_array($value->id, $listSelectAttributeValues) && !empty($aryProduct)) {
                            continue;
                        }
                    @endphp
                    <label style="cursor:pointer" class="label-attribute">
                        <input type="checkbox"
                               {{ isset($selected) && is_array($selected) && in_array($value->id, $selected) ? 'checked' : '' }} ? 'checked' : '' }}
                               class="attr-checkbox-filter attr-checkbox"
                               value="{{ $value->id }}">
                        <span>{{ $value->title }}</span>
                    </label>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
@endif