@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/postCate.css') }}">
@endpush

@section('page-title', $post->title)

@section('content')
    <div class="article-page">
        <div class="art-category-group m-0">
            @if($cateNavBar)
                @foreach($cateNavBar as $cate)
                    @if($cate->parent_id == null)
                        <a href="{{ route('fe.post.category', ['slug'=>$cate->slug, 'id' => $cate->id]) }}"
                           class="{{ $post->categories->first()->slug == $cate->slug ? 'current' : '' }}"
                           style="text-transform:uppercase">{{ $cate->title }}</a>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <div id="main" class="wrapper main-product">
        <div class="bres">
            <div class="container">
                <ul>
                    <li><a href="{{ route('fe.home') }}">Trang chủ</a>/</li>
                    @foreach($post->categories as $cate)
                        <li>
                            <a href="{{ route('fe.post.category', ['slug' => $cate->slug, 'id' => $cate->id]) }}">{{ $cate->title }}</a>
                            /
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <section class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="nav-main-content">
                            <div class="content-detail-new">
                                @if($post)
                                    <h1 style="font-size:36px; font-weight:700; text-transform:uppercase">{!! $post->title !!}</h1>
                                    {!! $post->excerpt !!}
                                    {!! $post->content !!}
                                @endif
                            </div>
                            <input type="hidden" data-id="{{ $post->id }}" id="view-count-data">
                            <div class="new-home other-new">
                                <h2 class="title22 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                    Tin tức liên quan</h2>
                                @if($randomPosts)
                                    @foreach($randomPosts as $post)
                                        <div class="item-new wow fadeInUp"
                                             style="visibility: visible; animation-name: fadeInUp;">
                                            <div class="image">
                                                <a href="{{ route('fe.post', ['slug' => $post->slug, 'id' => $post->id]) }}"><img
                                                            src="{{ get_image_url($post->thumbnail) }}"
                                                            alt="{{ $post->title }}">
                                                </a>
                                            </div>
                                            <div class="nav-image">
                                                <h3 class="title"><a
                                                            href="{{ route('fe.post', ['slug' => $post->slug, 'id' => $post->id]) }}">{{ $post->title }}</a>
                                                </h3>
                                                <p class="date">{{ Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}</p>
                                                <p class="desc">{{ strip_tags($post->excerpt) }}</p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@push('footer')
    @if(!empty($mainSettings['is_popup']) && $mainSettings['is_popup']==1 && !empty($mainSettings['popup']))
        <!-- Modal -->
        <div class="modal fade" id="notifyModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="notifyModalCenterTitle"
             aria-hidden="true" data-time="2">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! $mainSettings['popup'] !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    @endif
@endpush

@push('script')
    <script>
        $(document).ready(function () {
            let id = $('#view-count-data').data('id');

            setTimeout(() => {
                $.ajax({
                    type   : "POST",
                    url    : "{{ route('fe.post.viewCount') }}",
                    data   : {
                        _token    : '{{ csrf_token() }}',
                        id        : id,
                    },
                    success: function (response) {
                        console.log('counted');
                    }
                });
            }, 2000);
        })
    </script>
@endpush
