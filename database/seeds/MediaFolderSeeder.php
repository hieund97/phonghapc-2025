<?php

use Illuminate\Database\Seeder;
use App\Models\MediaFolder;
use App\Models\User;
use Illuminate\Support\Str;

class MediaFolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $folders = [
            'Sản phẩm',
            'Danh mục sản phẩm',
            'Slider',
            'Danh mục tin tức',
            'Tin tức',
        ];

        $dataToInsert = [];

        $user = User::find(1);

        MediaFolder::truncate();

        foreach ($folders as $index => $folder) {
            $dataToInsert = [
                'id'         => $index + 1,
                'name'       => $folder,
                'slug'       => Str::slug($folder),
                'parent_id'  => 0,
                'user_id'    => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            MediaFolder::create($dataToInsert);
        }
    }
}
