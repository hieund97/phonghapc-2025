<div class="row" style="margin-top: 30px">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="nav-main-content">
            <div class="content-product">
                <div class="content-detail-product">
                    <div style="margin-top: 0px">
                        <ul class="nav nav-tabs nav-tp-custom">
                            <li class="active">
                                <a data-toggle="tab" href="#new-post-tab">Tin tức mới nhất</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="new-post-tab" class="tab-pane fade in active">
                                <div class="content-box">
                                    <div class="nav-product">
                                        <div id="news-slider-detail" class="owl-carousel owl-theme owl-loaded owl-drag">
                                            @if($newestPost)
                                                @foreach($newestPost as $post)
                                                    <div class="item-product">
                                                        <div class="image">
                                                            <a href="{{ route('fe.post', ['slug' => $post->slug, 'id' => $post->id] ) }}" class="thubmail-img">
                                                                <img class="lazy"
                                                                     data-src="{{ get_image_url($post->thumbnail, '') }}"
                                                                     alt="{{ $post->title }}"
                                                                     src=""
                                                                     style="height: 200px; width: 100%; object-fit: cover;">
                                                            </a>
                                                        </div>
                                                        <h3 class="title" style="height: 48px; overflow: hidden; margin-top: 10px; line-height: 24px;">
                                                            <a href="{{ route('fe.post', ['slug' => $post->slug, 'id' => $post->id] ) }}">{{ $post->title }}</a>
                                                        </h3>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>