<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menu_items')->delete();

        DB::table('admin_menu_items')->insert([
            //Top Header
            0 => [
                'id' => 1,
                'label' => 'Giải Pháp - Thủ Thuật',
                'link' => route('fe.post.category', ['slug' => 'giai-phap-thu-thuat', 'id' => 78]),
                'parent' => 0,
                'sort' => 0,
                'class' => null,
                'menu'=> 1,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            1 => [
                'id' => 2,
                'label' => 'Xây Dựng Cấu Hình',
                'link' => route('fe.page.build-pc'),
                'parent' => 0,
                'sort' => 1,
                'class' => null,
                'menu'=> 1,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            2 => [
                'id' => 3,
                'label' => 'Tin Tức',
                'link' => route('fe.post.index'),
                'parent' => 0,
                'sort' => 2,
                'class' => null,
                'menu'=> 1,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            3 => [
                'id' => 4,
                'label' => 'Liên Hệ',
                'link' => route('fe.contact'),
                'parent' => 0,
                'sort' => 3,
                'class' => null,
                'menu'=> 1,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            4 => [
                'id' => 5,
                'label' => 'Hotline 0247.306.3686',
                'link' => 'tel:0247.306.3686',
                'parent' => 0,
                'sort' => 4,
                'class' => null,
                'menu'=> 1,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            5 => [
                'id' => 6,
                'label' => 'Chương trình khuyến mãi',
                'link' => route('fe.post', ['slug' => 'truong-chinh-khuyen-mai', 'id' => 16]),
                'parent' => 0,
                'sort' => 5,
                'class' => null,
                'menu'=> 1,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            6 => [
                'id' => 7,
                'label' => 'Chính sách sản phẩm',
                'link' => '',
                'parent' => 0,
                'sort' => 6,
                'class' => null,
                'menu'=> 1,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],


            //Main Menu
            7 => [
                'id' => 8,
                'label' => 'LAPTOP MỚI',
                'link' => route('fe.product.category', ['slug' => 'laptop-may-tinh-xach-tay', 'id' => 151]),
                'parent' => 0,
                'sort' => 0,
                'class' => null,
                'menu'=> 2,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            8 => [
                'id' => 9,
                'label' => 'PC GAMING',
                'link' => route('fe.product.category', ['slug' => 'may-tinh-choi-game', 'id' => 145]),
                'parent' => 0,
                'sort' => 1,
                'class' => null,
                'menu'=> 2,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            9 => [
                'id' => 10,
                'label' => 'PC-VĂN PHÒNG',
                'link' => route('fe.product.category', ['slug' => 'may-tinh-van-phong', 'id' => 160]),
                'parent' => 0,
                'sort' => 2,
                'class' => null,
                'menu'=> 2,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            10 => [
                'id' => 11,
                'label' => 'PHỤ KIỆN',
                'link' => route('fe.product.category', ['slug' => 'loa-tai-nghe-mic-webcam', 'id' => 147]),
                'parent' => 0,
                'sort' => 3,
                'class' => null,
                'menu'=> 2,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            11 => [
                'id' => 12,
                'label' => 'ĐIỆN THOẠI IPHONE',
                'link' => route('fe.product.category', ['slug' => 'dien-thoai-iphone-apple', 'id' => 208]),
                'parent' => 0,
                'sort' => 4,
                'class' => null,
                'menu'=> 2,
                'depth'=> 0,
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],
        ]);

    }
}
