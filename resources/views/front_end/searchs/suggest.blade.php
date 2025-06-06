@if($products->isNotEmpty())
    <div class="listResult">
        @foreach ($products as $product)
            <div class="result-item col-md-12">
                <div class="product uk-clearfix">
                    <div class="thumb">
                        <a class="image img-cover"
                           href="{{ Route('fe.product',["slug"=>$product->slug]) }}"
                           title="{{ $product->name }}">
                            <img src="{{ get_image_url($product->feature_img, 'default') }}"
                                 alt="{{ $product->name }}">
                        </a>
                    </div>
                    <div class="info">
                        <h2 class="title">
                            <a href="{{ Route('fe.product',["slug"=>$product->slug]) }}"
                               title="{{ $product->name }}">
                                {{ $product->name }}
                            </a>
                        </h2>
                        <div class="price">
                            <div class="new">@money($product->getRealPriceAttribute())</div>
                            <div class="old">@money($product->price)</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

