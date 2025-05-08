<div class="item-sb item-sb-mobile-hinden">
    <h3 class="title-sb">
        Tin tức mới nhất
    </h3>
    <div class="nav-right-new">
        @if($newestPost)
            @foreach($newestPost as $post)
                <div class="item" style="margin-bottom: 20px">
                    <div class="image" style="width: 100%">
                        <a href="{{ route('fe.post', ['slug' => $post->slug, 'id' => $post->id] ) }}">
                            <img src="{{ get_image_url($post->thumbnail, '') }}"
                                 alt="{{ $post->title }}"
                                 style="height: auto;width: 100%">
                        </a>
                    </div>
                    <div class="nav-img"
                         style="width: 100%;padding-left: 0px;padding-top: 10px">
                        <h3 class="title"><a
                                    href="{{ route('fe.post', ['slug' => $post->slug, 'id' => $post->id] ) }}">{{ $post->title }}</a>
                        </h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endforeach
        @endif
    </div>
</div>