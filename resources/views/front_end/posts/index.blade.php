@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif
@section('page-title', 'Tin tức công nghệ')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/postCate.css') }}">
@endpush

@section('content')
    <div class="article-page">
        <div class="art-category-group m-0">
            @if($postCategories)
                @foreach($postCategories as $cate)
                    @if($cate->parent_id == null)
                        <a style="text-transform:uppercase"
                           href="{{ route('fe.post.category', ['slug'=>$cate->slug, 'id' => $cate->id]) }}"
                        ">{{ $cate->title }}</a>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <section class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="nav-main-content">
                        <div class="main-content">
                            <div class="new-home">
                                @if($postCategories)
                                    @foreach($postCategories as $key => $cate)
                                        @if($cate->parent == null)
                                            <div>
                                                <h3 style="font-size: 24px;">{{ $cate->title }}</h3>
                                            </div>
                                            <div style="border-bottom: 1px solid #eee;">
                                                @if($cate->posts)
                                                    @php
                                                        $posts = $cate->posts->take(5)->toArray();
                                                    @endphp
                                                    @if($posts)
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="img">
                                                                    <a href="{{ route('fe.post', ['slug' => $posts[0]['slug'], 'id' => $posts[0]['id']]) }}">
                                                                        <img src="{{ $posts[0]['thumbnail'] }}"
                                                                             alt="{{ $posts[0]['title'] }}">
                                                                    </a>
                                                                </div>
                                                                <h3>
                                                                    <a href="{{ route('fe.post', ['slug' => $posts[0]['slug'], 'id' => $posts[0]['id']]) }}" style="font-weight:bold">{{ $posts[0]['title'] }}</a>
                                                                </h3>
                                                                <p class="date">Ngày
                                                                    đăng: {{ \Carbon\Carbon::parse($posts[0]['published_at'])->format('d/m/Y') }}
                                                                    - Lượt xem:
                                                                    {{ $posts[0]['view_count'] }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                @for($i = 1; $i < count($posts); $i++)
                                                                    <div class="item-new">
                                                                        <div class="image">
                                                                            <a href="{{ route('fe.post', ['slug' => $posts[$i]['slug'], 'id' => $posts[$i]['id']]) }}"><img
                                                                                        src="{{ $posts[$i]['thumbnail'] }}"
                                                                                        alt="{{ $posts[$i]['title'] }}">
                                                                            </a>
                                                                        </div>
                                                                        <div class="nav-image">
                                                                            <h3 class="title"><a
                                                                                        href="{{ route('fe.post', ['slug' => $posts[$i]['slug'], 'id' => $posts[$i]['id']]) }}">{{ $posts[$i]['title'] }}</a>
                                                                            </h3>
                                                                            <p class="date">Ngày
                                                                                đăng: {{ \Carbon\Carbon::parse($posts[$i]['created_at'])->format('d/m/Y') }}
                                                                                - Lượt xem:
                                                                                {{ $posts[$i]['view_count'] }}</p>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
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
