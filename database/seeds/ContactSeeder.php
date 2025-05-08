<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_receivers')->delete();
        DB::table('contact_receivers')->insert([
            0 => [
                'id'          => 1,
                'title'       => 'Khách hàng',
                'description' => 'Nhóm liên hệ của khách hàng',
                'status'      => 1,
            ],
            1 => [
                'id'          => 2,
                'title'       => 'Hotline Kinh Doanh',
                'description' => 'Nhóm liên hệ của Showroom',
                'status'      => 1,
            ],
        ]);

        DB::table('contacts')->delete();
        DB::table('contacts')->insert([
            [
                'id'                  => 1,
                'fullname'            => 'Hotline Showroom',
                'email'               => '',
                'contact_receiver_id' => 2,
                'status'              => 1,
                'is_important'        => 1,
                'phone_number'        => '0987.197.719',
            ],

            [
                'id'                  => 2,
                'fullname'            => 'Hotline Kinh Doanh',
                'email'               => '',
                'contact_receiver_id' => 2,
                'status'              => 1,
                'is_important'        => 1,
                'phone_number'        => '0395.969.7791',
            ],

            [
                'id'                  => 3,
                'fullname'            => 'Hotline: Kỹ thuật',
                'email'               => '',
                'contact_receiver_id' => 2,
                'status'              => 1,
                'is_important'        => 1,
                'phone_number'        => '0582.471.988',
            ],
        ]);
    }
}
