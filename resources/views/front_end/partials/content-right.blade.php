<div class="sidebar wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
    <div class="box-static-item">
        <p class="box-title">Yên Tâm Mua Sắm Tại NAMHAPC</p>
        <div class="static-text static-text-list" style="background: #fff">
            <p class="item"><strong>Đội ngũ kỹ thuật tư vấn chuyên sâu</strong></p>

            <p class="item"><strong>Thanh toán thuận tiện</strong></p>

            <p class="item"><strong>Sản phẩm 100% chính hãng</strong></p>

            <p class="item"><strong>Bảo hành&nbsp;tại nơi sử dụng</strong></p>

            <p class="item"><strong>Giá cạnh tranh nhất thị trường</strong></p>
        </div>
    </div>
    <div class="box-static-item">
        <p class="box-title">Liên Hệ Với Kinh Doanh Online</p>
        <div class="static-text static-hotline-list" style="background: #fff">
            @if(!empty($contacts->first()))
                @foreach($contacts->first()->contact as $contact)
                    <div class="item">
                        <i class="fab fa-mobile-phone"></i>
                        <p class="text">{{ $contact->fullname }}: <span
                                    class="red">{{ $contact->phone_number }}</span></p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>


    <div class="box-static-item box-qr-code" style="background: #fff">
        <p>Tham gia Cộng đồng "Cẩm Nang Build PC
            - Gaming, Đồ Họa, Render, Giả Lập"
            để theo dõi thường
            xuyên ưu đãi dành riêng cho thành viên</p>
        <img src="{{ asset('/images/qr1.png') }}" alt="Mã QR" style="width:50%">
    </div>

</div>