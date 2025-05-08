@php
    $categoryId = empty(request()->route('id'))  && isset($category) ? $category->id : request()->route('id');
    $typeSort = 0;
    if(isset($type)) {
        $typeSort = $type;
    }

    $stringSearch = '?q=';
    $seperate     = '?';
    if(strpos(request()->fullUrl(), $stringSearch) !== false){
        $seperate = '&';
    }
@endphp
<div class="product-page is-pc">
    <div class="product-sort-group d-flex flex-wrap align-items-center justify-content-between">
        <div class="product-sort-button">
            <a class="{{ $typeSort == 0 ? 'selected-sort' : '' }}"
               data-cateid="{{ $categoryId }}"
               data-column="id"
               data-sort="DESC"
               href="javascript:void(0)"
                onclick="filterProduct('{{ $categoryId }}', 'id', 'DESC', true)"
            >
                Hàng mới
            </a>

            <a class="{{ $typeSort == 1 ? 'selected-sort' : '' }}"
               data-cateid="{{ $categoryId }}"
               data-column="sale_price"
               data-sort="ASC"
               href="javascript:void(0)"
                onclick="filterProduct('{{ $categoryId }}', 'sale_price', 'ASC', true)"
            >
                Giá tăng dần
            </a>

            <a class="{{ $typeSort == 2 ? 'selected-sort' : '' }}"
               data-cateid="{{ $categoryId }}"
               data-column="sale_price"
               data-sort="DESC"
               href="javascript:void(0)"
                onclick="filterProduct('{{ $categoryId }}', 'sale_price', 'DESC', true)"
            >
                Giá giảm dần
            </a>

            <a class="{{ $typeSort == 3 ? 'selected-sort' : '' }}"
               data-cateid="{{ $categoryId }}"
               data-column="view_count"
               data-sort="DESC"
               href="javascript:void(0)"
                onclick="filterProduct('{{ $categoryId }}', 'view_count', 'DESC', true)"
            >
                Xem nhiều
            </a>
        </div>
    </div>
</div>

<div class="product-page is-mobile" style="width:100%">
    <div class="product-box-sort">
        <select class="sort-by-group" id="select_sort">
            <option {{ $typeSort == 0 ? 'selected' : '' }} data-cateid="{{ $categoryId }}" data-column="id" data-sort="DESC" class="js-select-path">Sắp xếp</option>
            <option {{ $typeSort == 1 ? 'selected' : '' }} data-cateid="{{ $categoryId }}" data-column="id" data-sort="DESC">
                Hàng mới
            </option>

            <option {{ $typeSort == 3 ? 'selected' : '' }} data-cateid="{{ $categoryId }}" data-column="sale_price" data-sort="ASC">
                Giá tăng dần
            </option>

            <option {{ $typeSort == 2 ? 'selected' : '' }} data-cateid="{{ $categoryId }}" data-column="sale_price" data-sort="DESC">
                Giá giảm dần
            </option>

            <option {{ $typeSort == 4 ? 'selected' : '' }} data-cateid="{{ $categoryId }}" data-column="view_count" data-sort="DESC">
                Xem nhiều
            </option>
        </select>

        <div class="product-btn-group">
            <a href="javascript:void(0)" class="btn-filter" data-toggle="collapse" data-target="#collapseExample"
               aria-expanded="false" aria-controls="collapseExample">
                <i class="mb-icons icon-filter"></i>
                <span style="font-size: 14px;">Lọc</span>
            </a>
        </div>
    </div>


</div>

