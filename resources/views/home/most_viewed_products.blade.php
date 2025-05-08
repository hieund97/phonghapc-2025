<div class="card">
    <div class="card-header">
        <h3 class="card-title" style="font-weight:bold">Sản phẩm xem nhiều nhất</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-header">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                Thông tin sản phẩm
            </div>
            <div class="col-md-2" style="text-align:right">
                Lượt xem
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <ul class="products-list product-list-in-card pl-2 pr-2">
            @foreach ($mostViewedProduct as $product)
                <li class="item">
                    <div class="row">
                        <div class="product-img col-sm-2">
                            @if (!empty($product->productMedias[0]))
                                <img src="{{ get_image_url($product->productMedias[0]->url, 'smallest') }}"
                                     alt="{{ $product->name }}" class="img-size-50">
                            @endif
                        </div>
                        <div class="product-info col-sm-8" style="margin:0">
                            <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                               class="product-title">{{ $product->name }}
                            </a>
                        </div>
                        <div class="col-md-2">
                            <span class="badge badge-warning float-right">{{ $product->view_count }}</span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- /.card-body -->
    <div class="card-footer text-center">
        <a href="{{ route('products.index') }}" class="uppercase">{{__('View All Products')}}</a>
    </div>
    <!-- /.card-footer -->
</div>
<!-- /.card -->
