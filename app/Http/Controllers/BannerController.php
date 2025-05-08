<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerStore;
use App\Models\Banner;
use App\Models\ProductCategory;
use App\Models\Category;
use App\Models\ProductTag;
use App\Models\PostTag;
use DB;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $references = Banner::where('model', '<>', 'Home');

        $type = $request->get('type');

        if (!empty($type)) {
            $references->where('model', $type);

            if ($type == ProductCategory::class && !empty($category = $request->get('category'))) {
                $references->where('model_id', $category);
            }
        }

        $references = $references->groupBy(['model', 'model_id'])->paginate(15, [
            DB::raw('COUNT(id) AS quantity'),
            'model',
            'model_id',
        ]);

        // Load relations
        $categories = ProductCategory::whereIn('id', $this->getRelationId($references->items(), ProductCategory::class))
            ->get(['id', 'title']);


        $references->getCollection()->transform(function ($item) use ($categories) {
            if ($item->model == ProductCategory::class) {
                $item->reference = $categories->where('id', $item->model_id)->first();
            }
            return $item;
        });

        return view('banners.index', compact('references'));
    }

    public function create()
    {
        return view('banners.form');
    }

    protected function getRelationId($items, $class)
    {
        return collect($items)->filter(fn ($item) => ($item->model == $class))->pluck('model_id')->values()->toArray();
    }

    public function listBanners($type, $id)
    {
        
       
        if (!in_array($type, ['category','category_post', 'home','product_tag','post_tag'])) {
            return [];
        }
        $mapModel = [
            'category' => ProductCategory::class,
            'category_post' => Category::class,
            'home' => 'Home',
            'product_tag' => ProductTag::class,
            'post_tag' => PostTag::class,
        ];
        return Banner::where('model', $mapModel[$type])
            ->where('model_id', $id)
            ->get();
    }

    public function store(BannerStore $request)
    {
        $data = $request->validated();

        $banner = null;

        if (!empty($data['id'])) {
            $banner = Banner::find($data['id']);
        }

        if (!empty($banner)) {
        } else {
            $banner = new Banner();
        }

        foreach ($data as $key => $value) {

            if (in_array($key, $banner->getFillable())) {
                $banner->{$key} = $value;
            }
        }
        $banner->sort = 1;
        $banner->save();

        return $banner;
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
    }

    public function destroyModel($model, $modelId)
    {
    }
}
