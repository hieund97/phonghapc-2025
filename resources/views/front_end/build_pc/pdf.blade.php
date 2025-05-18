<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Báo giá sản phẩm</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        .list_table{border-collapse:collapse}

        .list_table td{border:solid 1px #aaa;padding:5px;text-algin:center;vertical-align:middle}

        .cart_first_tr{background-color:#ccc}

        BODY, FORM, TABLE, TD, SPAN, DIV{font-family:Arial, Helvetica, sans-serif;font-size:12px}

        .title a{color:#00F;font-family:Arial, Helvetica, sans-serif;font-size:12px;text-decoration:none}

        .title a:hover{color:#00F;text-decoration:underline}
    </style>
</head>
<body>
<div style="width: 900px;margin: 0 auto;">
    <table width="900">
        <tbody>
        <tr>
            <td colspan="8" valign="right">
                <b>CÔNG TY CP CÔNG NGHỆ NAM HÀ</b>
            </td>
        </tr>
        <tr>
            <td colspan="8" valign="right">
                Địa chỉ ĐKKD: Showroom số 68 Trần phú - Thường tín- Hà nội
            </td>
        </tr>
        <tr>
            <td colspan="8" valign="right">
                Điện thoại: 02473063686
            </td>
        </tr>
        <tr>
            <td colspan="8" valign="right">
                Email: maytinhnamha.vn@gmail.com
            </td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8"
                style="border-top: 4px double #ccc;;font-size:21px; font-weight:bold; text-align:center; padding:15px 0;">
                BẢNG BÁO GIÁ THIẾT BỊ
            </td>
        </tr>
        </tbody>
    </table>
    <table width="900">
        <tbody>
        <tr>
            <td colspan="5" align="left"></td>
            <td colspan="3" align="right">
                Ngày báo giá: <span id="price_time">{{ date('d-m-Y H:i') }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="5" align="left"></td>
            <td colspan="3" align="right">
                <i>Đơn vị tính: VNĐ</i>
            </td>
        </tr>
        </tbody>
    </table>
    <div style="padding: 10px;"></div>
    <table width="900" class="list_table" border="1">
        <tbody>
        <tr align="center" style="color: #ffffff; background-color:#0676d8;font-weight: bold;">
            <td style="background-color:#555555; border: 0.5px solid black;color:#ffffff;">STT</td>
            <td style="background-color:#555555; border: 0.5px solid black;color:#ffffff;">Mã sản phẩm</td>
            <td style="background-color:#555555; border: 0.5px solid black;color:#ffffff; width:300px" colspan="2">Tên sản phẩm</td>
            <td style="background-color:#555555; border: 0.5px solid black;color:#ffffff;">Bảo hành</td>
            <td style="background-color:#555555; border: 0.5px solid black;color:#ffffff;">Số lượng</td>
            <td style="background-color:#555555; border: 0.5px solid black;color:#ffffff; width:100px;">Đơn giá</td>
            <td style="background-color:#555555; border: 0.5px solid black;color:#ffffff; width:100px;">Thành tiền</td>
        </tr>

        @php
            $total = 0;
        @endphp
        @if(!empty($data))
            @foreach($data as $key => $product)
                @php
                    $total = $data['total'];
                    if($key == 'total') {
                        continue;
                    }
                @endphp
                <tr align="center">
                    <td style="border: 0.5px solid black">{{ $loop->index ==  0 ?  $loop->index + 1 :  $loop->index }}</td>
                    <td style="border: 0.5px solid black">{{ $product['serial'] }}</td>
                    <td style="border: 0.5px solid black" colspan="2" align="left">
                        <a target="_blank" href="{{ route("fe.product",["slug"=>$product['slug']]) }}">
                            {{ $product['name'] }}
                        </a>
                    </td>
                    <td style="border: 0.5px solid black">{{ $product['warranty'] }}</td>
                    <td style="border: 0.5px solid black">{{ $product['quantity'] }}</td>
                    <td style="border: 0.5px solid black" align="right">@money($product['price'])</td>
                    <td style="border: 0.5px solid black" align="right">@money($product['price'] * $product['quantity'])</td>
                </tr>
            @endforeach
        @endif


        <tr>
            <td style="border: 0.5px solid black" colspan="5"></td>
            <td colspan="2" style="background:#b8cce4; border: 0.5px solid black;">Tổng tiền đơn hàng</td>
            <td style="background:#b8cce4; border: 0.5px solid black;" align="right">@money($total)</td>
        </tr>
        </tbody>
    </table>
    <table width="900">
        <tbody>
        <tr>
            <td colspan="8">
                <b>Cung cấp:</b> Tại Hà Nội ngay sau khi khách hàng thanh toán
            </td>
        </tr>
        <tr>
            <td>
                <b>Thanh toán:</b> Tiền mặt hoặc chuyển khoản
            </td>
        </tr>
        <tr>
            <td>
                Với quý khách hàng khi thanh toán vui lòng chuyển khoản vào tài khoản dưới đây:
            </td>
        </tr>
        <tr>
            <td>
                Ngân hàng Vpbank – Chi nhánh Thường tín - Hà Nội
            </td>
        </tr>
        <tr>
            <td>
                STK: 0986560586
            </td>
        </tr>
        <tr>
            <td>
                CTK: NGUYEN VAN VUONG
            </td>
        </tr>
        </tbody>
    </table>
    <div style="text-align: center;padding: 20px 0;" class="hide-print">
        <a href="{{ route('fe.page.build-pc') }}" class="btn_red" style="width:150px;display:inline-block;">Xây lại cấu
            hình</a>
        <a href="javascript:window.print()" style="width:100px;display:inline-block;" class="btn_red">In đơn hàng</a>
    </div>
</div>
<style>
    @media print{
        .hide-print{display:none;}
    }
</style>


</body>
</html>