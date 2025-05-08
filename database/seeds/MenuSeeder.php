<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menus')->delete();

        DB::table('admin_menus')->insert([
            0 => [
                'id' => 1,
                'name' => 'Top Header',
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],

            1 => [
                'id' => 2,
                'name' => 'Main Menu',
                'created_at' => '2023-10-04 15:35:53',
                'updated_at' => '2023-10-04 15:35:53',
            ],
        ]);

    }
}
