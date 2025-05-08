<div class="alert alert-danger" id="error_type" style="display:none">
     Bạn chưa chọn đúng trang web cần lấy dữ liệu hoặc url không đúng
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="status">{{ __('Type crawl') }}</label>
    <select
            name="type"
            id="type_crawl"
            class="form-control select2bs4 @error('type') is-invalid @enderror"
            required
    >
        @foreach(\App\Models\CrawlReport::TYPE as $type => $label)
            <option
                    value="{{ $type }}"
                    @if(old('status') == $type || (!empty($currentCrawlData) && $currentCrawlData->type == $type)) selected @endif>
                {{ $label }}
            </option>
        @endforeach
    </select>

    @error('status')
    <span class="error invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group clearfix">
    <input type="hidden" name="follow" value="0" />
    <div class="icheck-primary d-inline">
        <input type="checkbox" id="follow" name="follow" value="1" @if (old('follow')==1 ||
            (!empty($currentCrawlData) && $currentCrawlData->follow == 1)) checked @endif>
        <label for="follow">
            {{__('Follow product')}}
        </label>
    </div>
</div>

<div class="form-group">
    <label for="title">{{ __('url') }}</label>
    <span class="text-danger">(*)</span>
    @if(!empty($currentCrawlData))
        <button class="btn btn-sm btn-primary" type="button" id="reupdate_crawl" style="float:right; margin-bottom:5px;">Cập nhật lại</button>
    @endif
    <input
            id="url_crawl" type="text" name="url" class="form-control @error('url') is-invalid @enderror"
            value="{{ old('url') ?: (!empty($currentCrawlData) ? $currentCrawlData->url : '') }}" required
    />


    <div id="info-product-url">
        @if(!empty($currentCrawlData))
            @php
                $myProduct = $currentCrawlData->product->first();
                $myPrice =  $myProduct->sale_price == 0 || $myProduct->sale_price == null ? $myProduct->price : $myProduct->sale_price;
                $aryCrawledProduct = json_decode($currentCrawlData->info_product_url, true);
            @endphp
            <div class="card card-body" style="flex-direction:row; align-items:center;">
                <div class="col-md-2">
                    <img style="max-width:50%;" src="{{ $aryCrawledProduct['image'] }}">
                </div>
                <div class="col-md-9" style="font-size:18px;">
                    <b>Tên sản phẩm:</b> : {{ $aryCrawledProduct['name'] }}
                    <br>
                    <b>Giá sản phẩm:</b> :<span style="color:red">@money($aryCrawledProduct['price'])</span>
                </div>

                <input type="hidden" name="product_new_price" id="product_new_price" value="{{ $aryCrawledProduct['price'] }}">
                <input type="hidden" name="product_new_name" id="product_new_name" value="{{ $aryCrawledProduct['name'] }}">
                <input type="hidden" name="product_new_image" id="product_new_image" value="{{ $aryCrawledProduct['image'] }}">
            </div>
            <p style="color:red; font-weight:lighter; font-style:italic">*Lưu ý: Nút cập nhật nhanh sẽ không lưu sản phẩm*</p>

        @endif
    </div>

    @error('title')
    <span class="error invalid-feedback" style="display: block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="card" id="original-select">
    <div class="card-header">
        <h3 class="card-title">
            {{ __('Choose Product') }}{{-- (<span class="text-danger">*</span>)--}}
        </h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @php
                    if (!empty(old('parent_id'))) {
                        $parents = [['value' => old('parent_id'), 'label' => 'ID: ' . old('parent_id')]];
                    } elseif (!empty($myProduct)) {
                        $parents = [[
                            'value' => $currentCrawlData->product_id,
                            'label' => $myProduct->name,
                            'img'   => $myProduct->feature_img,
                            'price' => $myPrice,
                        ]];
                    }
                    else {
                        $parents = [];
                    }
                @endphp

                @include('partials.modals.choose-products-crawl', [
                    'label'      => __('Product'),
                    'name'       => 'parent_id',
                    'data'       => $parents ?? [],
                    'dataUrl'    => route('products.accessories', ['type' => 'all', 'hide_children' => 1]),
                    'required'   => true,
                    'single'     => true,
                    'hide_label' => true,
                ])
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="status_crawl" name="status" value="{{ $currentCrawlData->status ?? 2 }}">

<div class="alert alert-info" id="match_price" style="{{ empty($currentCrawlData) || $currentCrawlData->status == 2 ? 'display:none' : ''  }}">
    Không phát hiện thay đổi về giá
</div>

<div class="alert alert-warning" id="not_match_price" style="{{ empty($currentCrawlData) || $currentCrawlData->status == 1 ? 'display:none' : ''  }}">
    <strong>Phát hiện!</strong>  Giá của sản phẩm có sự chênh lệch
</div>

@push('scripts')
    <script>
        $('#type_crawl').on('change', function (){
            $('#info-product-url').html('');
            $('#error_type').hide();
            let url = $('#url_crawl').val();
            let typeCrawl = $(this).val();

            ajaxCrawl(url, typeCrawl)
        });

        $('input#url_crawl').on("keyup",function() {
            $('#info-product-url').html('');
            $('#error_type').hide();
            let typeCrawl = $('#type_crawl').val();
            let url = $(this).val();

            ajaxCrawl(url, typeCrawl)
        });

        $('#reupdate_crawl').on('click', function (){
            let typeCrawl = $('#type_crawl').val();
            let url = $('#url_crawl').val();
            ajaxCrawl(url, typeCrawl);
        })

        function formatMoney(money) {
            return new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(money);
        }

        function ajaxCrawl(url, typeCrawl) {
            $.ajax({
                url    : '{{ env('APP_URL_CRAWL') }}',
                type   : 'GET',
                crossDomain: false,
                data   : ({
                    url: url,
                    type: typeCrawl,
                }),
                success: function (result) {
                    $('#error_type').hide();
                    let converPrice = result.price.replace(/\./g,'').replace(',','.');
                    let price = parseInt(converPrice,10);

                    $('#product_new_price').val(price);
                    let myPrice = $('#product_update_id').data('price');

                    if (typeof myPrice !== 'undefined' && typeof price !== 'undefined') {
                        comparePrice(myPrice, price)
                    }

                    let htmlDetail = `<div class="card card-body" style="flex-direction:row; align-items:center;">
                                        <div class="col-md-2">
                                            <img style="max-width:50%;" src="${result.image}">
                                        </div>
                                        <div class="col-md-10" style="font-size:18px;">
                                            <b>Tên sản phẩm:</b> : ${result.name}
                                            <br>
                                            <b>Giá sản phẩm:</b> :<span style="color:red">${formatMoney(price)}</span>
                                            <input type="hidden" name="product_new_price" id="product_new_price" value="${price}">
                                            <input type="hidden" name="product_new_name" id="product_new_name" value="${result.name}">
                                            <input type="hidden" name="product_new_image" id="product_new_image" value="${result.image}">
                                        </div>
                                    </div>`;

                    $('#info-product-url').html(htmlDetail);
                },
                error  : function (error) {
                    $('#info-product-url').html('');
                    $('#error_type').show();
                }
            });
        }
    </script>
@endpush
