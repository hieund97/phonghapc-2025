<div class="contain-item-drive"
     data-category_id="{{ $prod['category_id'] }}"
     data-product_id="{{ $prod['product_id'] }}">
    <a target="_blank"
       href="{{ route("fe.product",["slug"=>$prod['slug']]) }}"
       class="d-img">
        <img src="{{ get_image_url($prod['image'],'thumb') }}"
             alt=" {{ $prod['name'] }}">
    </a>
    <div class="d-name">
        <a target="_blank"
           href="{{ route("fe.product",["slug"=>$prod['slug']]) }}">
            {{ $prod['name'] }}
        </a>
        <br>

        Bảo hành: <span
                style="color: red">{{ $prod['warranty'] }}</span>
        <br>
        Kho hàng: <span style="color: red">Còn hàng </span> | Mã SP:
        <span
                style="color: red">{{ $prod['serial'] }}</span> <br>

    </div>
    <span class="d-price" data-price="{{ $prod['price'] }}">@money($prod['price'])</span>
    <i>x</i>
    <input class="count-p" data-category="{{ $prod['category_id'] }}"
           type="number" value="{{ $prod['quantity'] }}"
           min="1" max="50">
    <i>=</i>
    <span class="sum_price" data-sum-price="{{ $prod['price'] * $prod['quantity'] }}">@money($prod['price'] * $prod['quantity'])</span>
    <span class="btn-action_seclect show-popup_select"
          data-id="{{ $prod['category_id'] }}">
        <i class="fa fa-edit edit-item" aria-hidden="true"></i>
    </span>
    <span class="btn-action_seclect delete_select">
        <i class="fa fa-trash remove-item"
           data-category="{{ $prod['category_id'] }}"
           aria-hidden="true"></i>
    </span>
</div>