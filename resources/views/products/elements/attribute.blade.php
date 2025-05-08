<div class="row">
    @foreach($arrAttribute as $attribute)
        @foreach($selectAttribute as $attributeId => $selectAttributeValue)
            @php
                if($attributeId != $attribute->id) {
                    continue;
                }
            @endphp
            <div class="attribute-list col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-sm-2 control-lanel">{{ $attribute->title }}</label>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="checkbox" style="padding:0;">
                            @foreach($attribute->attrValue as $attrValue)
                                @php
                                    if($attributeId == $attribute->id && !in_array($attrValue->id, $selectAttributeValue)) {
                                        continue;
                                    }
                                @endphp
                                <label class="tpInputLabel" style="width:180px;">
                                    <input name="attr[{{ $attribute->id }}][]"
                                           type="checkbox" class="tpInputCheckbox"
                                           value="{{ $attrValue->id }}"
                                           @if(isset($product))
                                               @foreach($product->attribute as $value) @if($value->id == $attrValue->id && $value->attrCate->id == $attribute->id) checked @endif @endforeach
                                            @endif
                                    >
                                    <span class="font-weight-normal">{{ $attrValue->title }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach

</div>