<?php

use Illuminate\Database\Seeder;
use App\Models\Navigation;

class FooterLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws JsonException
     */
    public function run()
    {
        DB::table('navigations')->delete();
        $navigations = [

            [
                'name'       => 'Giới thiệu chung',
                'icon'       => null,
                'link'       => route('fe.post', ['slug' => 'gioi-thieu-ve-may-tinh-nam-ha', 'id' => 14]),
                'group'      => 'Thông tin chung',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Tin tức - Cập nhật',
                'icon'       => null,
                'link'       => route('fe.post.index'),
                'group'      => 'Thông tin chung',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Thông tin khuyến mại',
                'icon'       => null,
                'link'       => route('fe.post.category', ['slug' => 'thong-tin-khuyen-mai', 'id' => 70]),
                'group'      => 'Thông tin chung',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Thông tin liên hệ',
                'icon'       => null,
                'link'       => route('fe.contact'),
                'group'      => 'Thông tin chung',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Chính sách vận chuyển',
                'icon'       => null,
                'link'       => route('fe.post', ['slug' => 'chinh-sach-van-chuyen', 'id' => 10]),
                'group'      => 'Chính sách chung',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Chính sách bảo hành vàng',
                'icon'       => null,
                'link'       => route('fe.post', ['slug' => 'chinh-sach-bao-hanh-vang', 'id' => 17]),
                'group'      => 'Chính sách chung',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Chính sách bảo hành',
                'icon'       => null,
                'link'       => route('fe.post', ['slug' => 'chinh-sach-bao-hanh', 'id' => 7]),
                'group'      => 'Chính sách chung',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Chính sách đổi trả',
                'icon'       => null,
                'link'       => '',
                'group'      => 'Chính sách chung',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Chính sách bảo mật',
                'icon'       => null,
                'link'       => route('fe.post', ['slug' => 'chinh-sach-bao-mat', 'id' => 8]),
                'group'      => 'Chính sách chung',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Hướng dẫn mua trực tuyến',
                'icon'       => null,
                'link'       => '',
                'group'      => 'Hỗ trợ khách hàng',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Hướng dẫn mua trả góp',
                'icon'       => null,
                'link'       => route('fe.post', ['slug' => 'hinh-thuc-thanh-toan-tra-gop', 'id' => 5]),
                'group'      => 'Hỗ trợ khách hàng',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Hướng dẫn thanh toán',
                'icon'       => null,
                'link'       => '',
                'group'      => 'Hỗ trợ khách hàng',
                'display_in' => 'footer',
            ],
            [
                'name'       => 'Tư vẫn ký thuật',
                'icon'       => null,
                'link'       => '',
                'group'      => 'Hỗ trợ khách hàng',
                'display_in' => 'footer',
            ],
        ];

        Navigation::insert($navigations);
    }
}
