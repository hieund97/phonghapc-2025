<div class="mask-popup">
    <div class="popup-select">
        <div class="header">
            <h4>Chọn {{ $attrCategory->title }} </h4>
            <span class="close-popup" onclick="closePopup()">
                <i class="fa fa-times" aria-hidden="true"></i>
            </span>
        </div>

        <div class="popup-main">
            <div class="popup-main_filter w-25 float_l is-pc">
                <h4>Lọc sản phẩm theo</h4>
                <div class="list-filter filter-container is-pc">
                    @include('front_end.partials.options_filter', ['category' => $attrCategory, 'aryAttribute' => $listAllAttribute, 'selected' => $arrAttribute, 'isFilterCategory' => $isFilterCategory ?? false, 'isBuild' =>true, 'aryProduct' => $arrProduct])
                </div><!--list-filter-->
            </div><!--popup-main_filter-->

            <div class="popup-main_content w-75 w-100-mb float_r">
                <div class="list-filter filter-container is-mobile">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        LỌC SẢN PHẨM
                    </button>
                    <div class="collapse" id="collapseExample"  style="margin-top: 2em">
                        @include('front_end.partials.options_filter', ['category' => $attrCategory, 'aryAttribute' => $listAllAttribute, 'selected' => $arrAttribute, 'isFilterCategory' => $isFilterCategory ?? false, 'isBuild' =>true, 'aryProduct' => $arrProduct])
                    </div>
                </div>
                <div class="sort-paging clear">

                    <div class="sort-block float_l">
                        <span>Sắp xếp: </span>
                        @php
                        $arrTypeConfig = config('admin.type_sort_build_pc');
                        @endphp
                        <select data-category="{{ $attrCategory->id }}" id="js-sort-holder">
                            <option data-type="0" value="">Tùy chọn</option>
                            <option data-type="1" {{ $type == $arrTypeConfig['newest'] ? 'selected' : '' }} value="{{ route("fe.category.filter.new") . "?column=id&sortFilter=DESC" }}">
                                Mới nhất
                            </option>
                            <option data-type="3" {{ $type == $arrTypeConfig['just_price_asc'] ? 'selected' : '' }} value="{{ route("fe.category.filter.new") . "?column=sale_price&sortFilter=ASC" }}">
                                Giá tăng dần
                            </option>
                            <option data-type="2" {{ $type == $arrTypeConfig['just_price_desc'] ? 'selected' : '' }} value="{{ route("fe.category.filter.new") . "?column=sale_price&sortFilter=DESC" }}">
                                Giá giảm dần
                            </option>
                            <option data-type="4" {{ $type == $arrTypeConfig['viewed'] ? 'selected' : '' }} value="{{ route("fe.category.filter.new") . "?column=view_count&sortFilter=DESC" }}">
                                Lượt xem
                            </option>
                            <option data-type="5" {{ $type == $arrTypeConfig['top_rated'] ? 'selected' : '' }} value="{{ route("fe.category.filter.new") . "?column=rate_count&sortFilter=DESC" }}">
                                Đánh giá
                            </option>
                            <option data-type="6" {{ $type == $arrTypeConfig['name'] ? 'selected' : '' }} value="{{ route("fe.category.filter.new") . "?column=name&sortFilter=DESC" }}">
                                Tên A-&gt;Z
                            </option>
                        </select>
                    </div>

                </div>
                <table class="table table-striped list-product-select" id="table-product-dbtable">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($arrProduct))
                        @foreach($arrProduct as $product)
                            @php
                            $checkSale = false;
                            $price = $product->price;
                            if(!empty($product->sale_price)) {
                                $checkSale = true;
                                $price = $product->sale_price;
                            }
                            @endphp
                            <tr class="p-item">
                                <td style="vertical-align:middle;width:20%">
                                    <a href="{{ route("fe.product",["slug"=>$product->slug]) }}"
                                       class="p-img">
                                        <img src="{{ (!empty($product->feature_img)) ? get_image_url($product->feature_img, "thumb") : "/preview-icon720x333.png" }}"
                                             alt="{{ $product->name }}">
                                    </a>
                                </td>
                                <td class="w-55 w-65-mb">
                                    <div class="info">
                                        <a href="{{ route("fe.product",["slug"=>$product->slug]) }}"
                                           class="p-name">
                                            {{ $product->name }}
                                        </a>
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td width="80"><b>Mã SP:</b></td>
                                                <td>{{ $product->serial }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Bảo hành:</b></td>
                                                <td>{{ $product->warranty ?? "12 tháng"}}</td>
                                            </tr>

                                            <tr>
                                                <td valign="top"><b>Kho hàng:</b></td>
                                                <td>
                                                    Còn hàng
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <span class="p-price">@money($price)</span>
                                        @if($checkSale)
                                            <span class="p-price-old">@money($product->price)</span>
                                        @endif
                                    </div>
                                </td>
                                <td style="vertical-align:middle; width: 26%;">
                                    <button type="button" class="btn btn-buy js-select-product "
                                      data-id="{{ $product->id }}"
                                      data-image="{{ (!empty($product->feature_img)) ? get_image_url($product->feature_img, "") : "/preview-icon720x333.png" }}"
                                      data-name="{{ $product->name }}"
                                      data-serial="{{ $product->serial }}"
                                      data-warranty="{{ $product->warranty }}"
                                      data-category="{{ $attrCategory->id }}"
                                      data-slug="{{ $product->slug }}"
                                      data-price="{{ $price }}">
                                        <span class="is-pc-inline-block">Thêm vào cấu hình</span>
                                    </button>
                                </td>
                            </tr>


                        @endforeach
                    @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>