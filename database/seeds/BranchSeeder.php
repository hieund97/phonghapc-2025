<?php

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            [
                'title'   => 'Hà Nội',
                'address' => '87, Phố Thiên Hiền, Đình Thôn, Mỹ Đình, Từ Liêm, TP. Hà Nội',
                'hotline' => '092.55.88.666 | (Mr.Giáp)',
            ],
            [
                'title'   => 'Đà Nẵng',
                'address' => 'Đường Cách Mạng tháng 8',
                'hotline' => '092.55.88.666 (Mr.Giáp)',
            ],
            [
                'title'   => 'Hồ Chí Minh',
                'address' => '400 Hồng Bàng phường 16 quận 11, tp HCM',
                'hotline' => '0973.426.962 (Mr.An) 092.55.88.666',
            ],
        ];
        foreach ($branches as $row) {
            Branch::create(['title' => $row["title"], 'address' => $row["address"], 'hotline' => $row["hotline"]]);
        }
    }
}