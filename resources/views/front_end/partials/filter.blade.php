<div class="filter-container is-pc">
    <p class="box-title">LỌC SẢN PHẨM</p>
    @if($isCategory)
        <div class="filter-item filter-category">
            <p class="title">DANH MỤC</p>
            @foreach($aryCategory as $child)
                <div class="filter-list">
                    <a href="{{ route('fe.product.category', ["id" => $child->id, 'slug' => $child->slug])}}">
                        {{ $child->title }}
                    </a>
                </div>
            @endforeach
        </div>
    @else
        @php($category = null)
    @endif
    @include('front_end.partials.options_filter', ['category' => $category, 'listAllAttribute' => $listAllAttribute, 'selected' => $selectedAttribute, 'isBuild' => false])
</div>

<div class="filter-container is-mobile" style="padding: 0 0 1.5em 1em !important;">
    <div class="collapse" id="collapseExample" style="margin-top: 2em">
        @if($isCategory)
            <div class="filter-item filter-category">
                <p class="title">DANH MỤC</p>
                <button type="button" class="close" aria-label="Close"
                        data-toggle="collapse" data-target="#collapseExample"
                        aria-expanded="false" aria-controls="collapseExample"
                        style="position:absolute; right:1em; top:0">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
                @foreach($aryCategory as $child)
                    <div class="filter-list">
                        <a href="{{ route('fe.product.category', ["id" => $child->id, 'slug' => $child->slug])}}">
                            {{ $child->title }}
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            @php($category = null)
        @endif
        @include('front_end.partials.options_filter', ['category' => $category, 'listAllAttribute' => $listAllAttribute, 'selected' => $selectedAttribute, 'isBuild' => false])
    </div>
</div>