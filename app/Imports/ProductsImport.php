<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Redirection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\MediaFile;
use Str;
use Storage;
use Image;

class ProductsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        //$i = 0;
        //$y = 0;
        //foreach ($rows as $row) {
        //    if ($i == 2454 || $i == 2383) {
        //        // dump($row);
        //    }
        //    if ($i > 0) {
        //        if (!empty($row[1])) {
        //            $name = $row[1];
        //            if (!empty($row[14])) {
        //                $name =  $name . ' ' . $row[14];
        //            }
        //            $urlOld = 'https://maytinhnamha.vn/products/' . $row[0];
        //            $parentId = null;
        //            $firstParent = Product::where("url_old", $urlOld)->first();
        //            if (!empty($firstParent->id)) {
        //                $parentId = $firstParent->id;
        //            }
        //            $price = $row[20];
        //            $sale_price = null;
        //            if(!empty($row[21])){
        //
        //                $price = $row[21];
        //                $sale_price = $row[20];
        //
        //            }
        //            $product = Product::create([
        //                'name' => $name,
        //                'price' => $price,
        //                'sale_price' => $sale_price,
        //                'serial' => '',
        //                'technical_specification' => '',
        //                'description' => $row[2],
        //                'slug' => Str::slug($name),
        //                'status' => 4,
        //                'parent_id' => $parentId,
        //                'product_category_id' => 2,
        //                'warranty' => '',
        //                'skus' => $row[14],
        //                'url_old' => $urlOld,
        //                'published_at' => date("Y-m-d h:m:s"),
        //            ]);
        //
        //            $product->seo()->create([]);
        //
        //
        //            // insert redirect
        //            Redirection::create([
        //                'link_from' => '/products/' . $row[0],
        //                'link_to' => Route('fe.product',["slug"=>$product->slug,"id"=>$product->id],false),
        //                'type' => 301,
        //            ]);
        //
        //            // insert ảnh đầu tiền
        //            $arrImg =[
        //                'https://product.hstatic.net/1000170465/product/1_8ebd9e1bf4044fdd8202426e34881d18.jpg',
        //                'https://product.hstatic.net/1000170465/product/mainx5s_4819c9b8ab1749d6ad1a715272b3f65c.jpg',
        //                'https://product.hstatic.net/1000170465/product/man-hinh-lien-camera-360-oledpro-x6s_48eb08d68a0e4f9db208dc7783a769d6.jpg',
        //                'https://product.hstatic.net/1000170465/product/accent-c1s_652f5bf5548447259ed5bf666db57a96.jpg',
        //                'https://product.hstatic.net/1000170465/product/man-hinh-lien-camera-360-oledpro-x5s-tucson_bdd0a63d7d3541549d45a7eacf10de79.jpg',
        //                'https://product.hstatic.net/1000170465/product/xe-vin_082857f1b3b94e1cbf751b81833fb364.jpg',
        //                'https://product.hstatic.net/1000170465/product/kia-seltos_1a9325e026094e2f8e5edc9b27b4a51a.jpg',
        //                'https://product.hstatic.net/1000170465/product/man-hinh-olepro-x6s_0fd6c3612974430e8325ce9b4ac62244.jpg',
        //            ];
        //            if (!empty($row[25]) && !in_array($row[25],$arrImg)) {
        //
        //                $mediaModel = MediaFile::orderByDesc('id')->get(['id', 'path']);
        //                $medias     = $mediaModel->pluck('path')->all();
        //
        //                $urlImage = $row[25];
        //                $fileName = basename($urlImage);;
        //                $filePath = "uploads/san-pham/$fileName";
        //
        //                if (!in_array($filePath, $medias)) {
        //                    if (!Storage::disk('public')->exists($filePath)) {
        //                        Storage::disk('public')->put(
        //                            $filePath,
        //                            $this->getImage($urlImage)
        //                        );
        //                    }
        //                }
        //                // resize
        //                $arrResize = config('media.sizes');
        //                $full_path = Storage::disk('public')->path($filePath);
        //                $path_parts = pathinfo($full_path);
        //                $fName = $path_parts["filename"];
        //                $fExt = $path_parts["extension"];
        //                foreach ($arrResize as $key=>$size) {
        //                    $readable_size = explode('x', $size);
        //                    $fileNameResize = $fName . '-' . $size . '.' . $fExt;
        //                    $filePathResize = "uploads/san-pham/$fileNameResize";
        //                    if (!Storage::disk('public')->exists($filePathResize)) {
        //                        $image_resize = Image::make($full_path);
        //                        $image_resize->resize($readable_size[0], $readable_size[1]);
        //                        $image_resize->save(Storage::disk('public')->path($filePathResize));
        //                    }
        //                }
        //
        //                $insert = [
        //                    'folder_id' => 2,
        //                    'name' => $fileName,
        //                    'mime_type' => 'image/png',
        //                    'size' => Storage::disk('public')->size($filePath),
        //                    'path' => 'storage/' . $filePath,
        //                    'url' => 'http://cdn.chungauto.vn/'.$filePath,
        //                    'user_id' => 1,
        //                ];
        //
        //                $media = MediaFile::create($insert);
        //                $product->productMedias()->create(
        //                    [
        //                        'model' => Product::class,
        //                        'model_id' => $product->id,
        //                        'media_file_id' => $media->id,
        //                        'title' => $media->name,
        //                        'url' => $media->url,
        //                    ]
        //                );
        //            }
        //        } else {
        //            //  dump($row);
        //            $y++;
        //        }
        //    }
        //
        //    $i++;
        //}
    }

    protected function getImage($url)
    {

        return file_get_contents($url, false);
    }
}
