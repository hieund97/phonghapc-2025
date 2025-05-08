<div class="banner-home">
    <div class="container pd-10">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="banner-home-left"></div>
                <div class="banner-home-right">
                    <div class="slider-homepage">
                        @include('front_end.partials.slider')
                    </div>
                    <div class="banner-right-homepage">
                        @if(isset($imagesRight))
                            @foreach($imagesRight as $image)
                                <div class="item-n">
                                    <a href="{{ $image['link'] }}">
                                        <img
                                                src="{{ get_image_url($image['url']) }}"
                                                data-src="{{ get_image_url($image['url']) }}"
                                                alt="Banner">
                                    </a>
                                </div>
                            @endforeach
                        @endif

                    </div>

                    <div class="banner-home-bot">
                        @if(isset($imagesBottom))
                            @foreach($imagesBottom as $image)
                                <div class="item-n">
                                    <a href="{{ $image['link'] }}">
                                        <img
                                                src="{{ get_image_url($image['url']) }}"
                                                data-src="{{ get_image_url($image['url']) }}"
                                                alt="Banner">
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>