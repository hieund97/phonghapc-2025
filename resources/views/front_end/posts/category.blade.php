@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif
@section('page-title', $category->title)
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/postCate.css') }}">
@endpush

@section('content')
    <div class="article-page">
        <div class="art-category-group m-0">
            @if($postCategories)
                @foreach($postCategories as $cate)
                    @if($cate->parent_id == null)
                        <a href="{{ route('fe.post.category', ['slug'=>$cate->slug, 'id' => $cate->id]) }}"
                           class="{{ Str::contains(url()->current(), $cate->slug) ? 'current' : '' }}"
                           style="text-transform:uppercase">{{ $cate->title }}</a>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <section class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <div class="nav-main-content page-article-catalogues">
                        <h2 class="h2 products-section-title text-uppercase">
                            <span>Tin nổi bật</span>
                        </h2>
                        @if($featurePosts)
                            <div class="slider-large owl-carousel owl-theme owl-loaded owl-drag">
                                @foreach($featurePosts as $post)
                                    <div class="item-new wow fadeInUp"
                                        style="visibility: visible; animation-name: fadeInUp;">
                                        <div>
                                            <a href="{{ route('fe.post', ['slug' => $post->slug, 'id' => $post->id]) }}">
                                                <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}">
                                            </a>
                                        </div>
                                        <div>
                                            <h3 class="title">
                                                <a href="{{ route('fe.post', ['slug' => $post->slug, 'id' => $post->id]) }}">
                                                    {{ $post->title }}
                                                </a>
                                            </h3>
                                            <p class="date">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</p>
                                            <p class="desc">{!! strip_tags($post->excerpt) !!}</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-8  col-xs-12">
                    <div class="nav-main-content page-article-catalogues">
                        <div class="new-home">
                            <h2 class="title22 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                {{ $category->title }}</h2>

                            @if($postPaginate)
                                <div class="row">
                                    @foreach($postPaginate as $post)
                                        <div class="item-new wow fadeInUp col-md-6 col-sm-6 col-xs-12"
                                             style="visibility: visible; animation-name: fadeInUp;">
                                            <div class="">
                                                <a href="{{ route('fe.post', ['slug' => $post->slug, 'id' => $post->id]) }}"><img
                                                            src="{{ $post->thumbnail }}" alt="{{ $post->title }}">
                                                </a>
                                            </div>
                                            <div class="">
                                                <h3 class="title"><a
                                                            href="{{ route('fe.post', ['slug' => $post->slug, 'id' => $post->id]) }}">{{ $post->title }}</a>
                                                </h3>
                                                <p class="date">{{ Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</p>
                                                <p class="desc">{!! strip_tags($post->excerpt) !!}</p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        {{ $postPaginate->links('pagination.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
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
