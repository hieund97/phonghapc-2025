<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();

        DB::table('categories')->insert([
            [
                'id'          => 1,
                'title'       => 'Tin tức',
                'slug'        => Str::slug('Tin tức'),
                'description' => 'Tin tức của trang web',
                'thumbnail'   => '',
                'status'      => 1,
                '_lft'        => 1,
                '_rgt'        => 2,
                'parent_id'   => null,
                'created_at'  => '2021-09-16 10:37:49',
                'updated_at'  => '2021-09-16 14:10:08',
            ],

            [
                'id'          => 2,
                'title'       => 'Tin tức chung',
                'slug'        => Str::slug('Tin tức chung'),
                'description' => 'Tin tức chung của trang web',
                'thumbnail'   => '',
                'status'      => 1,
                '_lft'        => 1,
                '_rgt'        => 2,
                'parent_id'   => 1,
                'created_at'  => '2021-09-16 10:37:49',
                'updated_at'  => '2021-09-16 14:10:08',
            ],

            [
                'id'          => 3,
                'title'       => 'Tin tức công nghệ',
                'slug'        => Str::slug('Tin tức công nghệ'),
                'description' => 'Tin tức công nghệ của trang web',
                'thumbnail'   => '',
                'status'      => 1,
                '_lft'        => 1,
                '_rgt'        => 2,
                'parent_id'   => 1,
                'created_at'  => '2021-09-16 10:37:49',
                'updated_at'  => '2021-09-16 14:10:08',
            ],

            [
                'id'          => 4,
                'title'       => 'Giải pháp - Thủ thuật',
                'slug'        => Str::slug('Giải phát - Thủ thuật'),
                'description' => 'Các giải pháp và các thủ thuật của trang web',
                'thumbnail'   => '',
                'status'      => 1,
                '_lft'        => 1,
                '_rgt'        => 2,
                'parent_id'   => null,
                'created_at'  => '2021-09-16 10:37:49',
                'updated_at'  => '2021-09-16 14:10:08',
            ],

            [
                'id'          => 5,
                'title'       => 'Laptop',
                'slug'        => Str::slug('Laptop'),
                'description' => 'Các giải pháp và thủ thuật của laptop',
                'thumbnail'   => '',
                'status'      => 1,
                '_lft'        => 1,
                '_rgt'        => 2,
                'parent_id'   => 4,
                'created_at'  => '2021-09-16 10:37:49',
                'updated_at'  => '2021-09-16 14:10:08',
            ],

            [
                'id'          => 6,
                'title'       => 'Phần mềm',
                'slug'        => Str::slug('Phần mềm'),
                'description' => 'Các giải pháp và thủ thuật của phần mềm',
                'thumbnail'   => '',
                'status'      => 1,
                '_lft'        => 1,
                '_rgt'        => 2,
                'parent_id'   => 4,
                'created_at'  => '2021-09-16 10:37:49',
                'updated_at'  => '2021-09-16 14:10:08',
            ],

            [
                'id'          => 7,
                'title'       => 'Giới thiệu',
                'slug'        => Str::slug('Giới thiệu'),
                'description' => 'Giới thiệu về trang web ',
                'thumbnail'   => '',
                'status'      => 1,
                '_lft'        => 1,
                '_rgt'        => 2,
                'parent_id'   => null,
                'created_at'  => '2021-09-16 10:37:49',
                'updated_at'  => '2023-09-16 14:10:08',
            ],
        ]);
    }
}