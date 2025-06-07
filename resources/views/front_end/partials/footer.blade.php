<footer id="footer-site">
    @include('front_end.partials.block-benefit')
    <div class="top-footer footer-bottom wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{ route('fe.home') }}" class="logo-footer">
                        <img class="lazy entered loaded" data-src="/uploads/images/untitled-1.png"
                             alt="MÁY TÍNH PHONG HÀ" data-ll-status="loaded"
                             src="{{ $mainSettings['info_logo_footer'] }}">
                    </a>
                    <div class="title-footer">
                        {{ $mainSettings['info_company']}}
                    </div>
                    <div class="nav-bottom">
                        <p><span>Địa chỉ: </span>{{ $mainSettings['contact_address_company'] }}</p>

                        <p><span>Email: </span>{{ $mainSettings['contact_email'] }}</p>
                        <p><span>Hotline: </span>{{ $mainSettings['contact_hotline'] }}</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="row">
                        @if($mainFooters)
                            @foreach($mainFooters as $label=>$footer)
                                <div class="item col-lg-4 col-md-4">
                                    <h3 class="title-footer" style="text-transform:uppercase">{{ $label }}</h3>
                                    <div class="nav-item-adress">
                                        <ul>
                                            @foreach($footer as $row)
                                                <li><a href="{{ $row->link }}" rel="nofollow">
                                                        <i class="fal fa-angle-right"></i>{{ $row->name }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="map-footer">
                        <h3 class="title-footer">Fanpage Facebook</h3>
                        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fp%2FM%25C3%2581Y-T%25C3%258DNH-PHONG-H%25C3%2580-100057216169392%2F&tabs=timeline&width=340&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=2700411746766380"
                                width="385" height="159" style="border:none;overflow:hidden" scrolling="no"
                                frameborder="0" allowfullscreen="true"
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{--    <div class="copy-right">--}}
    {{--        <div class="container">--}}
    {{--            <div class="wp-copy text-center" style="color:#fff">--}}
    {{--                {{ $mainSettings['info_copyright'] }}--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
</footer>

<style type="text/css" media="screen">

    @media (min-width:1650px){
        .container-benefit{
            width:100%;

        }
    }

    .container-benefit{
        width:100%;
        max-width:100%;
        padding:0 10px;
        margin-right:auto;
        margin-left:auto;
        background:#e5e5e5;
        display:flex;
        justify-content:center;
        align-items:center;
    }

    .ph-footer-policies{
        width: 1500px;
        display:-webkit-box;
        display:-webkit-flex;
        display:-moz-box;
        display:-ms-flexbox;
        display:flex;
        -webkit-box-align:center;
        -webkit-align-items:center;
        -moz-box-align:center;
        -ms-flex-align:center;
        align-items:center;
        -webkit-flex-wrap:wrap;
        -ms-flex-wrap:wrap;
        flex-wrap:wrap;
        -webkit-box-pack:justify;
        -webkit-justify-content:space-between;
        -moz-box-pack:justify;
        -ms-flex-pack:justify;
        justify-content:space-between;
        padding-bottom:25px;
        padding-top:0
    }

    .policy-container{
        width:25%;
        display:-webkit-box;
        display:-webkit-flex;
        display:-moz-box;
        display:-ms-flexbox;
        display:flex;
        -webkit-box-align:center;
        -webkit-align-items:center;
        -moz-box-align:center;
        -ms-flex-align:center;
        align-items:center;
        margin-top:30px
    }

    .policy-icon{
        color:#ed1b24;
        font-size:32px;
        margin-right:15px
    }

    .policy-info-title{
        font-size:16px;
        font-weight:700;
        margin:0
    }

    .policy-info-content{
        display:block;
        font-size:13px
    }

    .wp-copy.text-center{
        text-align:center;
    }

    .right-pc-position ul li:last-child{
        right:-25px;
    }

    .holine-footer1:after{
        content:"";
    }

    .copy-right{
        width:100%;
        display:inline-block;
        background:#0f1424;
        /*height: 44px;*/
        /*line-height: 44px;*/
        text-align:center;
        font-size:14px;
        color:#bdbdbd;
        margin:0;
        padding:10px 0;
        /*border-top: 1px solid #fff;*/
    }

    .right-pc-position{
        position:fixed;
        bottom:9em;
        width:13em;
        right:45px;
        z-index:999;
    }

    @media (max-width:1500px){
        .right-pc-position{
            position:fixed;
            bottom:10%;
            right:35px;
            z-index:999;
        }
    }

    @media only screen and (max-width:768px){
        .right-pc-position{
            width:1em !important;
        }
    }

    .right-pc-position ul{
        list-style:none;
        margin:0;
        padding:0;
        display:inline-block;
    }

    .right-pc-position ul li{
        padding-bottom:10px;
        width:45px;
        height:45px;
        position:relative;
        margin-bottom:5px;
        text-align:center;
        line-height:45px;
    }

    .right-pc-position ul.social-footer li i{
        color:#000;
        color:#fff;
        width:45px;
        height:45px;
        border-radius:50%;
        position:absolute;
        /* padding: 5px 9px; */
    }

    .right-pc-position ul li .fa-facebook-f{
        background:#3B5997;
    }

    .right-pc-position ul li .fa-twitter{
        background:#00ACF0;
    }

    .right-pc-position ul li .fa-instagram{
        background:#447397;
    }

    .right-pc-position ul li .fa-youtube{
        background:#D12E2E;
    }

    .right-pc-position ul li .fa-google{
        background:#DB4F48;

    }

    body #divBannerFloatLeft{
        padding-right:10px;
    }

    body #divBannerFloatRight{
        padding-left:10px;
    }

    .fillter_bl .content_fillter [class^="group-fillter fill-key-"] .attribute-title:after{

    }

    }
</style>
<div class="right-pc-position is-pc">
    @if($mainSettings['social_facebook_url'])
        <a class="contact-box-wrapper nut-chat-facebook" href="{{ $mainSettings['social_facebook_url'] }}"
           target="_blank"
           rel="nofollow">
            <div class="contact-icon-box" style="border: none;margin-right:10px"><img
                        src="{{ asset('images/facebook.png') }}"></div>
            <div class="contact-info">
                <b>Fanpage Facebook</b>
            </div>
        </a>
    @endif

    @if($mainSettings['contact_zalo'])
        <a class="contact-box-wrapper nut-chat-zalo" href="http://zalo.me/{{ $mainSettings['contact_zalo'] }}"
           target="_blank" rel="nofollow">
            <div class="contact-icon-box" style="border: none;">
                <img style="margin-bottom:10px" src="{{ asset('images/logo-zalo.png') }}">
            </div>
            <div class="contact-info">
                <b>Chat Zalo</b>
                <span>{{ $mainSettings['contact_zalo'] }}</span>
            </div>
        </a>
    @endif

    @if($mainSettings['social_youtube_url'])
        <a class="contact-box-wrapper nut-goi-hotline" href="{{ $mainSettings['social_youtube_url'] }}" rel="nofollow">
            <div class="contact-icon-box" style="color: #ed1b24;">
                <img style="margin-bottom:10px" src="{{ asset('images/youtube-footer.png') }}">
            </div>
            <div class="contact-info">
                <b>Kênh Youtube</b>
            </div>
        </a>
    @endif
</div>

<div class="right-pc-position is-mobile">
    <div class="contact-icon-box" style="border: none;">
        <a href="{{ $mainSettings['social_facebook_url'] }}">
            <img src="{{ asset('images/facebook.png') }}">
        </a>
    </div>

    <div class="contact-icon-box" style="border: none;">
        <a href="http://zalo.me/{{ $mainSettings['contact_zalo'] }}">
            <img src="{{ asset('images/logo-zalo.png') }}">
        </a>
    </div>

    <div class="contact-icon-box" style="color: #ed1b24;">
        <a href="{{ $mainSettings['social_youtube_url'] }}">
            <img src="{{ asset('images/youtube-footer.png') }}">
        </a>
    </div>
</div>
<style type="text/css" media="screen">
    i.fa.fa-plus.css-icon-plus.show:before{
        content:"\f107";
    }

    .fillter_bl .content_fillter [class^="group-fillter fill-key-"] .attribute-title:after, .fa.fa-plus.css-icon-plus:before{
        content:"\f105";
        font-weight:bold;
    }

    .fillter_bl .content_fillter [class^="group-fillter fill-key-"] .attribute-title.show:after{
        content:"\f107";
    }
</style>
@push('script')
    <script type="text/javascript" charset="utf-8" async defer>
        // $('#main-menu1 > ul > li').attr('style','width: calc(100% / '+$('#main-menu1 > ul > li').length+')');

        if (jQuery(window).width() <= 768) {
            $('.main-slider').attr('style', "padding-top: " + $('.nav-category-home.hello').height() + "px");
            $('.css-icon-plus').click(function () {
                if (jQuery(this).next().css('display') == 'none') {

                    jQuery(this).next().attr('style', 'opacity: 1;display: block;visibility: inherit;position: inherit;left: 0px;');

                    // jQuery(this).next().css('display','block');

                    jQuery(this).addClass('show');

                } else {

                    jQuery(this).next().attr('style', 'opacity: 0;display: none;visibility: hidden;position: absolute;');
                    // jQuery(this).next().css('display','none');

                    jQuery(this).removeClass('show');

                }
                // $(this).parent().find('.vertical-dropdown-menu').attr('style', 'opacity: 1;display: block;visibility: inherit;');
            });
        }
        jQuery('.fillter_bl .content_fillter [class^="group-fillter fill-key-"] .attribute-title').click(function (e) {

            e.preventDefault();

            if (jQuery(this).next().css('display') == 'none') {

                jQuery(this).next().css('display', 'block');

                jQuery(this).addClass('show');

            } else {

                jQuery(this).next().css('display', 'none');

                jQuery(this).removeClass('show');

            }

            return false;

        });

    </script>
@endpush

