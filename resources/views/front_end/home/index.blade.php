@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif
@section('page-title', $mainSettings['info_site_name'])
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/popUp.css') }}">
@endpush

@section('content')
    @php
        $imagesRight = [];
        $imagesBottom = [];
    @endphp
    @foreach($sliders as $slider)
        @if($slider->id == config('front_end.home_slider.right'))
            @php
                $imagesRight = $slider->productMedias->toArray();
                usort($imagesRight, function ($a, $b){
                    return $a['sort'] - $b['sort'];
                });
            @endphp
        @endif
    @endforeach
    @foreach($sliders as $slider)
        @if($slider->id == config('front_end.home_slider.bottom'))
            @php
                $imagesBottom = $slider->productMedias->toArray();
                usort($imagesBottom, function ($a, $b){
                    return $a['sort'] - $b['sort'];
                });
            @endphp
        @endif
    @endforeach
    <style>
        #main-menu1 ul .menu-main-sub{
            opacity:1;
            transform:rotateX(0deg) !important;
            visibility:visible !important;
            transition:unset !important;
        }
    </style>
    @if( session()->has('login_successfull') )
        <div class="callout callout-success uk-margin-bottom"
             style="background:#53A653;padding:8px;color:#fff;margin-bottom:10px">Đăng nhập thành công
        </div>
    @endif

    <!-- Home Banner -->
    @include('front_end.partials.homeBanner')
    <!-- End Home Banner -->

    <!-- Button category mobile -->
    @include('front_end.partials.button_category_mobile')
    <!-- Button category mobile -->

    <!-- Sale Product -->
    @include('front_end.partials.saleProd')
    <!-- End Sale Product -->

    <!-- Main Product Homepage -->
    @include('front_end.partials.mainContent')
    <!-- End Main Product Homepage -->

    <!-- Slider customer -->
    @include('front_end.partials.customer-slide')
    <!-- End Slider customer -->
@endsection

@push('footer')
    @if(!empty($mainSettings['popup_status']) && $mainSettings['popup_status']=='on' && !empty($mainSettings['popup_image']))
        <!-- Modal -->
        <div id="sessionPopup" class="hidden">
            <div id="showPop">
                <div id="popupContact"
                     style="position:absolute; top: 200px; left: 400px; display: block; z-index:999999; width:50%">
                    <div href="javascript:;" id="popupContactClose">
                        <a style="cursor:pointer; font-size:45px;color:red;display:inline-block;margin-top:20px;text-decoration:none !important;"
                           onclick="closePop();">[x]</a>
                    </div>
                    <div id="contactArea" class="show-popup">
                        <a href="{{ $mainSettings['popup_links'] }}" target="_blank"><img
                                    data-src="{{ $mainSettings['popup_image'] }}" class="lazy loaded" width="1"
                                    height="1" style="border-radius:20px; width: auto;height: auto"
                                    src=""
                                    data-was-processed="true"></a>
                    </div>
                </div>
                <div id="backgroundPopup" style="opacity: 0.7; display: block;"></div>
            </div>
        </div>
        <!-- End Modal -->
    @endif

@endpush

@push('script')
    <script>
        $(document).ready(function () {
            setTimeout(() => {
                $('#sessionPopup').removeClass('hidden');
            }, 1500);
        })

        function closePop() {
            $('#sessionPopup').hide();
        }
    </script>
@endpush

