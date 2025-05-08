<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->delete();

        DB::table('sliders')->insert([
            0 =>
                [
                    'id'          => 1,
                    'title'       => 'Home Slider - Main',
                    'description' => 'slider lớn tại trang chủ',
                    'info'        => null,
                    'thumbnail'   => null,
                    'link'        => null,
                    'type'        => 1,
                    'product_id'  => null,
                    'model_id'    => 0,
                    'sort'        => 0,
                    'status'      => 1,
                    'model'       => null,
                    'rel'         => null,
                    'target'      => null,
                    'created_at'  => '2023-10-02 10:37:49',
                    'updated_at'  => '2023-10-02 14:10:08',
                ],
            1 =>
                [
                    'id'          => 2,
                    'title'       => 'Home Slider - Right',
                    'description' => '4 slider nhỏ bên phải slider chính tại trang chủ',
                    'info'        => null,
                    'thumbnail'   => null,
                    'link'        => null,
                    'type'        => 1,
                    'product_id'  => null,
                    'model_id'    => 0,
                    'sort'        => 0,
                    'status'      => 1,
                    'model'       => null,
                    'rel'         => null,
                    'target'      => null,
                    'created_at'  => '2023-10-02 10:37:49',
                    'updated_at'  => '2023-10-02 14:10:08',
                ],
            2 =>
                [
                    'id'          => 3,
                    'title'       => 'Home Slider - Bottom',
                    'description' => '4 slider nhỏ bên dưới slider chính tại trang chủ',
                    'info'        => null,
                    'thumbnail'   => null,
                    'link'        => null,
                    'type'        => 1,
                    'product_id'  => null,
                    'model_id'    => 0,
                    'sort'        => 0,
                    'status'      => 1,
                    'model'       => null,
                    'rel'         => null,
                    'target'      => null,
                    'created_at'  => '2023-10-02 10:37:49',
                    'updated_at'  => '2023-10-02 14:10:08',
                ],
            3 =>
                [
                    'id'          => 4,
                    'title'       => 'Home Slider - Customer',
                    'description' => 'Slider sự ủng hộ của khách hàng',
                    'info'        => null,
                    'thumbnail'   => null,
                    'link'        => null,
                    'type'        => 1,
                    'product_id'  => null,
                    'model_id'    => 0,
                    'sort'        => 0,
                    'status'      => 1,
                    'model'       => null,
                    'rel'         => null,
                    'target'      => null,
                    'created_at'  => '2023-10-02 10:37:49',
                    'updated_at'  => '2023-10-02 14:10:08',
                ],
        ]);
    }
}
