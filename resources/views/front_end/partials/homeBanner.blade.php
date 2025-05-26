<div class="banner-home">
    <div class="container pd-10">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="banner-home-left">
                    <div class="header-new-bot">
                        <div class="list-content">
                            <div class="item-n menu-main item-n-first">
                                <ul class="menu-main-sub">
                                    @foreach ($mainHeaders as $cate)
                                        @if ($cate->parent == null)
                                            <li>
                                                <a href="{{ route('fe.product.category', ['slug' => $cate->slug, 'id' => $cate->id]) }}"
                                                   class="itop"
                                                   style="background: url('{{ get_image_url($cate->icon, '') }}') no-repeat;">{{ $cate->title }}</a>
                                                <div class="box-sub-cat">
                                                    @foreach ($cate->childrenEnable as $child)
                                                        <div class="box-cat">
                                                            <a href="{{ route('fe.product.category', ['slug' => $child->slug, 'id' => $child->id]) }}"
                                                               class="cat2">{{ $child->title }}</a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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
