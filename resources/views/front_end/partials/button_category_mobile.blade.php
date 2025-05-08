<div class="home-button-group is-mobile">
    <a href="javascript:void(0)" class="toggle-second">
        <i class="mb-icons icon-menu"></i>
        <span>Danh mục<br>sản phẩm</span>
    </a>

    <a href="/blog/chuong-chinh-khuyen-mai-b16.html">
        <i class="mb-icons icon-bold"></i>
        <span>Chương trình<br>Khuyến mãi</span>
    </a>

    <a href="/danh-muc-bai-viet/tin-tuc-e1.html">
        <i class="mb-icons icon-list"></i>
        <span>Trang<br>Tin tức</span>
    </a>

    <a href="/build-pc">
        <i class="icons icon-buildpc"></i>
        <span>Xây dựng<br>cấu hình</span>
    </a>
</div>
@push('script')
    <script>
        $(function () {
            $('.toggle-second').on('click', function (){
                $('.toggle').click();
            })
        })
    </script>
@endpush