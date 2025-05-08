<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->delete();
        DB::table('posts')->insert([
            [
                'id'               => 1,
                'title'            => 'Test post 1',
                'slug'             => Str::slug('Test post 1'),
                'content'          => 'test post',
                'excerpt'          => 'test post',
                'thumbnail'        => '',
                'status'           => 1,
                'is_featured'      => 1,
                'is_home_featured' => 1,
            ],

            [
                'id'               => 2,
                'title'            => 'Test post 2',
                'slug'             => Str::slug('Test post 2'),
                'content'          => 'test post',
                'excerpt'          => 'test post',
                'thumbnail'        => '',
                'status'           => 1,
                'is_featured'      => 1,
                'is_home_featured' => 1,
            ],
            [
                'id'               => 3,
                'title'            => 'Test post',
                'slug'             => Str::slug('Test post'),
                'content'          => 'test post',
                'excerpt'          => 'test post',
                'thumbnail'        => '',
                'status'           => 1,
                'is_featured'      => 1,
                'is_home_featured' => 1,
            ],
            [
                'id'               => 4,
                'title'            => 'Test post',
                'slug'             => Str::slug('Test post'),
                'content'          => 'test post',
                'excerpt'          => 'test post',
                'thumbnail'        => '',
                'status'           => 1,
                'is_featured'      => 1,
                'is_home_featured' => 1,
            ],
            [
                'id'               => 5,
                'title'            => 'Test post',
                'slug'             => Str::slug('Test post'),
                'content'          => 'test post',
                'excerpt'          => 'test post',
                'thumbnail'        => '',
                'status'           => 1,
                'is_featured'      => 1,
                'is_home_featured' => 1,
            ],
        ]);

        DB::table('category_post')->delete();
        DB::table('category_post')->insert([
            [
                'category_id' => 1,
                'post_id'     => 1,
            ],

            [
                'category_id' => 2,
                'post_id'     => 1,
            ],

            [
                'category_id' => 1,
                'post_id'     => 2,
            ],

            [
                'category_id' => 3,
                'post_id'     => 2,
            ],

            [
                'category_id' => 4,
                'post_id'     => 3,
            ],

            [
                'category_id' => 5,
                'post_id'     => 3,
            ],

            [
                'category_id' => 4,
                'post_id'     => 4,
            ],

            [
                'category_id' => 6,
                'post_id'     => 4,
            ],

            [
                'category_id' => 7,
                'post_id'     => 5,
            ],
        ]);
    }
}
