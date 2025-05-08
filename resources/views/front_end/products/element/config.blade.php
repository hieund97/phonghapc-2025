@if(!empty($product->config) && checkHasConfig($product->config))
    @php
        $aryCart =  \Cart::getContent();
        $selectedConfig = null;
        foreach ($aryCart as $item) {
            if($item->id == $product->id) {
                $selectedConfig = $item->attributes->config;
            }
        }
    @endphp
    <div class="variant-item">
        <b class="d-blockd-block"> Cấu hình </b>

        <div class="items-variant items-variant-noSlider d-flex flex-wrap">
            <div class="item" style="height: unset">
                <label class="{{ empty($selectedConfig) ? 'current' : '' }} flex-wrap label-config">
                    <span>
                        <input type="radio" class="radio_config"
                               id="config_product_original"
                               name="config_product"
                               data-price="{{ !empty($product->sale_price) ? $product->sale_price : $product->price }}"
                               data-name="{{ $product->name }}"
                               data-type="original"
                               checked
                               value="original">
                        {{ $product->name }}
                    </span>
                    <span class="d-block variant-price w-100">
                        @if(!empty($product->sale_price))
                            @money($product->sale_price) <span style="text-decoration:line-through; font-weight:500; color:grey">@money($product->price)</span>
                        @else
                            @money($product->price)
                        @endif
                    </span>
                    <input type="hidden" id="config_img_original" value="{{ get_image_url($product->feature_img, '') }}">
                    <input type="hidden" id="config_description_original" value="{{ $product->description }}">
                </label>
            </div>

            @foreach($product->config as $index => $config)
                @php
                    $price = $config['price'];
                    $oldPrice = 0;
                    $typePrice = 1;
                    if($config['sale_price'] != 0 && $config['price'] != 0) {
                         $price = $config['sale_price'];
                         $oldPrice = $config['price'];
                         $typePrice = 2;
                    } elseif($config['sale_price'] == 0 && $config['price'] == 0) {
                        if(!empty($product->sale_price)) {
                            $price = $product->sale_price;
                            $oldPrice = $product->price;
                        }
                        else {
                            $price = $product->price;
                        }
                        $typePrice = 3;
                    }
                    elseif ($config['sale_price'] == 0  && $config['price'] != 0) {
                         $price = $config['price'];
                         $typePrice = 1;
                    }
                    else {
                         $price = $config['sale_price'];
                         $oldPrice = $config['price'];
                         $typePrice = 2;
                    }
                @endphp

                <div class="item" style="height: unset">
                    <label class=" {{ !empty($selectedConfig) && $index == $selectedConfig ? 'current' : '' }} flex-wrap label-config">
                        <span>
                            <input type="radio" class="radio_config" name="config_product"
                                   data-price="{{ $price }}"
                                   data-old="{{ $oldPrice }}"
                                   data-name="{{ $config['name'] }}"
                                   data-type="{{ $typePrice }}"
                                   {{ !empty($selectedConfig) && $index == $selectedConfig ? 'checked' : '' }}
                                   value="{{ $index }}">
                            {{ $config['name'] }}
                        </span>
                        <span class="d-block variant-price w-100">
                            @if($config['sale_price'] != 0 && $config['price'] != 0)
                                @money($config['sale_price']) <span style="text-decoration:line-through; font-weight:500; color:grey">@money($config['price'])</span>
                            @elseif ($config['sale_price'] == 0  && $config['price'] != 0)
                                @money($config['price'])
                            @elseif($config['sale_price'] == 0 && $config['price'] == 0)
                                @if(!empty($product->sale_price))
                                    @money($product->sale_price) <span style="text-decoration:line-through; font-weight:500; color:grey">@money($product->price)</span>
                                @else
                                    @money($product->price)
                                @endif
                            @else
                                @money($config['sale_price'])
                            @endif
                        </span>
                        <input type="hidden" id="config_img_{{$index}}" value="{{ $config['config_img'] }}">
                        <input type="hidden" id="config_description_{{$index}}" value="{{ $config['config_description'] }}">
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endif
@push('script')
    <script>
        const originHtmlPrice = $('.pd-price-group').html();
        $(function (){
            let needCheckOut = $('#needCheckOut').val();
            if (needCheckOut == 1) {
                $('.radio_config').prop('disabled', true);
                $('.label-config').css("opacity", "0.5");

                $('#needCheckOut').val(1);
            }


        });

        function formatMoney(money) {
            return new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(money);
        }

        $('input[type=radio][name=config_product]').change(function() {
            $('.label-config').removeClass('current');
            let index       =  $(this).val();
            let name        =  $(this).data('name');
            let price       =  $(this).data('price');
            let oldPrice    =  $(this).data('old');
            let typePrice   =  $(this).data('type');
            let config_img  = $('#config_img_'+index).val();
            let config_desc = $('#config_description_'+index).val();


            if(config_desc == null || config_desc == '' || typeof config_desc === 'undefined') {
                config_desc = $('#config_description_original').val();
            }

            if(config_img == null || config_img == '' || typeof config_img === 'undefined') {
                config_img = $('#config_img_original').val();
            }

            $(this).closest('.label-config').addClass('current');
            $('.bk-product-price').text(price)
            $('.bk-product-name').text(name)
            $('.bk-product-image').attr('src', config_img)
            $('.ajax-addtocart').data('config', index);

            $('.p-short-description').html(config_desc);
            $('#zoom img').attr('src', config_img);

            let html = `<span class="pd-price">
                            ${formatMoney(price)}
                        </span>`;

            if(typePrice == 2) {
                let delPrice = `<del class="pd-old-price">
                                    ${formatMoney(oldPrice)}
                                </del>
                                <span class="pd-price-off">Tiết kiệm ${formatMoney(parseInt(oldPrice) - parseInt(price))}</span>`;

                html = html + delPrice;
            }

            if (typePrice === 'original') {
                html = originHtmlPrice;
            }

            $('.pd-price-group').html(html);

        });
    </script>
@endpush
