<div class="main-slider">
    <div class="slider-large owl-carousel">
        @foreach($sliders as $slider)
            @if($slider->id == config('front_end.home_slider.main'))
                @php
                    $images = $slider->productMedias->toArray();
                    usort($images, function ($a, $b){
                        return $a['sort'] - $b['sort'];
                    });
                @endphp
            @endif
        @endforeach
        @if(isset($images))
            @foreach ($images as $key => $image)
                <div class="item" data-hash="one{{$key}}">
                    <a href="{{ $image['link'] }}">
                        <img class="owl-lazy" style="border-radius:15px" src="{{ $image['url'] }}"
                             alt="{{ $image['title'] }}" data-src="{{ $image['url'] }}">
                    </a>
                </div>
            @endforeach
        @endif
    </div>
    <div class="slider-small owl-carousel" style="display: none">
        @if(isset($images))
            @foreach ($images as $key => $image)
                <a href="#one{{$key}}"> <span class="transforn"></span></a>
            @endforeach
        @endif
    </div>
</div>
<style type="text/css">
    .slider-small .owl-item:nth-of-type(odd) > a{
        background:-webkit-radial-gradient(center center, circle farthest-side, #5f5a5a 14%, #000 100%);
    }

    .slider-small .owl-item:nth-of-type(even) > a{
        background:-webkit-radial-gradient(center center, circle farthest-side, #f2e386 14%, #ccb05e 100%);
        color:black;
    }

    /* .slider-small .owl-item:nth-child(5n+3) > a{
        background: -webkit-radial-gradient(center center, circle farthest-side, #5f5a5a 14%, #000 100%);
    }
    .slider-small .owl-item:nth-child(5n+4) > a{
        background: -webkit-radial-gradient(center center, circle farthest-side, #f2e386 14%, #ccb05e 100%);
    }
    .slider-small .owl-item:nth-child(5n+5) > a{
        background: -webkit-radial-gradient(center center, circle farthest-side, #5f5a5a 14%, #000 100%);
    } */
</style>