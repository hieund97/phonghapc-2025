<?php

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $categories = [
            'Laptop - Máy Tính Xách Tay|1' => [
                'Laptop Gaming|1',
                'Laptop like-new|1',
                'Laptop HP|1',
                'Laptop Lenovo|1',
                'Laptop Dell|1',
                'Laptop MSI|1',
                'Laptop Asus|1',
                'Laptop Acer|1',
                'Laptop Samsung|1',
            ],

            'Máy Tính Chơi Game|1' => [
                'PC Gaming Dưới 10 Triệu|1',
                'PC Gaming 10-20 Triệu|1',
                'PC Gaming 20-30 Triệu|1',
            ],

            'Máy Tính Văn Phòng|1' => [
                'Máy Tính Đồng Bộ All In One|1',
                'Máy Tính Văn Phòng|1',
            ],

            'Loa, Tai Nghe, Mic, Webcam|1' => [
                'Loa|1',
                'Tai Nghe|1',
                'Microphone|1',
                'Webcam|1',
            ],

            'Điện Thoại Iphone - Apple|1' => [
                'Iphone 8 Plus|1',
                'Iphone XS Max|1',
                'Iphone 11 Pro|1',
                'Iphone 11 Pro Max|1',
                'Iphone 13 Pro Max|1',
            ],

        ];

        foreach ($categories as $category => $children) {
            [$categoryName, $categoryType] = explode('|', $category);

            $newCategory = ProductCategory::create([
                'title'        => $categoryName,
                'type'         => $categoryType,
                'slug'         => Str::slug($categoryName),
                'thumbnail'    => '/preview-icon.png',
                'icon'         => null,
                'is_menu_top'  => true,
                'level'        => 1,
                'is_feature'   => true,
                'is_menu_home' => true,
            ]);

            foreach ($children as $child => $childrenOfChild) {
                if (is_numeric($child)) {
                    $child           = $childrenOfChild;
                    $childrenOfChild = [];
                }

                [$childName, $childType] = explode('|', $child);

                $newChildCategory = $newCategory->children()->create([
                    'title'        => $childName,
                    'type'         => $childType,
                    'slug'         => Str::slug($childName),
                    'thumbnail'    => '/preview-icon.png',
                    'icon'         => null,
                    'is_menu_top'  => true,
                    'is_feature'   => true,
                    'level'        => 2,
                    'is_menu_home' => true,
                ]);
                foreach ($childrenOfChild as $childOfChild => $abcxyz) {
                    if (is_numeric($childOfChild)) {
                        $childOfChild = $abcxyz;
                        $abcxyz       = [];
                    }

                    [$childOfName, $childOfType] = explode('|', $childOfChild);

                    $newChildOfCategory = $newChildCategory->children()->create([
                        'title'        => $childOfName,
                        'type'         => $childOfType,
                        'slug'         => Str::slug($childOfName),
                        'thumbnail'    => '/preview-icon.png',
                        'icon'         => null,
                        'is_menu_top'  => true,
                        'is_feature'   => true,
                        'level'        => 3,
                        'is_menu_home' => true,
                    ]);
                    foreach ($abcxyz as $abc) {
                        [$abcName, $abcType] = explode('|', $abc);

                        $newChildOfCategory->children()->create([
                            'title'        => $abcName,
                            'type'         => $abcType,
                            'slug'         => Str::slug($abcName),
                            'thumbnail'    => '/preview-icon.png',
                            'icon'         => null,
                            'is_menu_top'  => true,
                            'is_feature'   => true,
                            'level'        => 4,
                            'is_menu_home' => true,
                        ]);
                    }
                }
            }
        }
    }
}
