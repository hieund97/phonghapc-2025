<!-- Ủng hộ khách hàng -->
<section class="container container-customer">
    @php
        $images = [];
        if (isset($sliderCustomer->first()->productMedias)){
            $images = $sliderCustomer->first()->productMedias->toArray();
        }
    @endphp
    @if($images)
        <div class="namhacompu-customer">
            <div class="namhacompu-customer-img-fix">
                <img class="img-fluid" src="{{ $images[0]['url'] }}" alt="Customer first" width="1" height="1"
                     style="width: auto;height: auto; max-width: 95%">
            </div>
            <div class="wrap-namhacompu-customer">
                <div class="namhacompu-customer-title">Sự ủng hộ của khách hàng khắp mọi miền đất nước</div>

                <div class="slider-customer">
                    <div class="main-slider">
                        <div class="owl-carousel owl-theme owl-loaded owl-drag">
                            @for($i = 1; $i < count($images); $i++)
                                <div class="item item-customer">
                                    <img class="img-fluid img-customer" src="{{ get_image_url($images[$i]['url'], 'default') }}"
                                         alt="banner customer">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>