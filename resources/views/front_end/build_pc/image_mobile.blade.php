<div id="build-pc-image" style="padding-left:10px">
    <div style="height:50px">
        <p style="display:none">PHONG HÀ COMPUTER</p>
    </div>
    <div style="display:flex; justify-content:center; margin-bottom:30px; margin-top:50px">
        <img style="width:7em" src="{{ asset('images/logo-white.png') }}">
    </div>

    @foreach($data as $key => $product)
        <div style="display:flex; justify-content:center; align-items:center; margin-bottom:40px">
            <div style="width:25%; margin-right: 10px;position:relative;">
                <img style="width:97px" src="{{ get_image_url($product['image'], "") }}"
                     alt="{{ $product['name'] }}">
            </div>
            <div style="width: 50%">
                <p style="font-size:1em; font-weight:bold">{{ $product['name'] }}</p>
                <p></p>
                <table style="width:300px">
                    <tbody>
                    <tr>
                        <td style="padding:5px 0 !important; border:none !important; " width="80"><b>Mã SP:</b></td>
                        <td style="padding:5px 0 !important; border:none !important; ">{{ $product['serial'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px 0 !important; border:none !important; " width="80"><b>Bảo hành:</b></td>
                        <td style="padding:5px 0 !important; border:none !important; ">{{ $product['warranty'] }}</td>
                    </tr>

                    <tr>
                        <td style="padding:5px 0 !important; border:none !important; " width="80"><b>Kho hàng:</b></td>
                        <td style="padding:5px 0 !important; border:none !important; ">
                            Còn hàng
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:5px 0 !important; border:none !important; " colspan="2">
                            <span style="color:#ec1b23; font-weight:800; font-size:1em">@money($product['price']) x {{ $product['quantity'] }}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="width: 22%;">
                <span style="color:#ec1b23; font-weight:800; font-size:1em">= @money($product['price'] * $product['quantity'])</span>
            </div>
        </div>
    @endforeach


    <div style="text-align:center">
        <h2 style="color:red; font-size:25px; font-weight:800">
            Tổng chi phí: @money($total)
        </h2>
    </div>

    <div style="text-align:center; margin-bottom:50px;">
        <p style="font-size:15px">
            <b>Quý khách lưu ý: </b>Giá bán, khuyến mại và tình trạng hàng hoá có thể thay đổi mà không kịp báo trước
            khách hàng vui lòng liên hệ nhân viên tư vấn hoặc hotline <b>078 692 6666</b>
        </p>
    </div>
    <div style="height:50px">
        <p style="display:none">PHONG HÀ COMPUTER</p>
    </div>
</div>