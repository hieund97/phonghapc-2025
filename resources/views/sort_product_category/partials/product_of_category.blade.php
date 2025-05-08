@foreach($aryProducts as $product)
    <div class="card card-body">
        <div class="row" style="align-items:center">
            <div class="col-md-2" style="text-align:center">
                <img style="width:40%" src="{{ get_image_url($product->feature_img) }}">
            </div>
            <div class="col-md-5" style="width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ $product->name }}
            </div>
            <div class="col-md-2">
                <label for="sort_in_cate_{{ $product->id }}">Thứ tự:</label>
                <input
                        style="max-width: 50px; display:inline-block !important;"
                        type="text"
                        class="form-control quick-update-product"
                        value="{{ $product->ordering_in_cate }}"
                        data-id="{{ $product->id }}"
                        data-type="ordering_in_cate"
                        id="sort_in_cate_{{ $product->id }}"
                />
            </div>
            <div class="col-md-3">
                <div class="icheck-primary d-inline">
                    <input class="quick-update-product" data-type="show_on_top" type="checkbox"
                           data-id="{{ $product->id }}" id="show_on_top_{{ $product->id }}"
                           @if ($product->show_on_top ?? false) checked @endif>
                    <label for="show_on_top_{{ $product->id }}">{{ __('Show on top?') }}</label>
                </div>
            </div>
        </div>
    </div>
@endforeach
