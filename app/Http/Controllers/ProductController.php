<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Requests\ProductStore;
use App\Http\Requests\ProductUpdate;
use App\Http\Requests\SaveProductSort;
use App\Models\Attribute;
use App\Models\CrawlReport;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductFeature;
use App\Models\ProductOrder;
use DB;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use JsonException;
use Kalnoy\Nestedset\AncestorsRelation;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Tags\Tag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        return view('products.index', [
            'products' => $this->getProducts($request),
        ]);
    }

    protected function getProducts(Request $request): LengthAwarePaginator
    {
        return Product::filter($request->all())
                      ->withoutGlobalScope('enabled')
                      ->withoutGlobalScope('published')
                      ->with([
                          'productCategory',
                          'reviews',
                          'attribute'
                      ])
                      ->orderByDesc('id')
                      ->paginate()
        ;
    }

    /**
     * Export products list as excel.
     *
     * @return \Maatwebsite\Excel\BinaryFileResponse|BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export()
    {
        return Excel::download(new ProductsExport, 'products_' . date('Ymd_His') . '.xlsx');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('products.store');

        $arrAttribute = Attribute::all();

        return view('products.form', compact('arrAttribute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStore $request
     *
     * @return RedirectResponse
     */
    public function store(ProductStore $request): RedirectResponse
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $data['categories'] = $data['product_category_id'];
            if (is_array($data['product_category_id'])) {
                $data['product_category_id'] = reset($data['product_category_id']);
            }
            // Get product type.
            $product = Product::create($data);

            $this->storeExtraData($product, $data);
            if (!empty($data['posts'])) {
                $product->posts()->attach($data['posts']);
            }

            $product->categories()->sync($data['categories'] ?? []);
            //$product->attribute()->sync($data['categories'] ?? []);
            if (!empty($data['attr'])) {
                $this->syncAttributeProduct($data['attr'], $product);
            }

            DB::commit();
            //all good
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());

            return redirect()->back();
        }

        return redirect()->route('products.edit', ['product' => $product->id])->with('success', __('Created success'));
    }

    /**
     * Store product extra data
     *
     * @param Product $product
     * @param array   $data
     *
     * @return void
     */
    public function storeExtraData(Product $product, array $data): void
    {
        if (!empty($data['videos'])) {
            $product->videos()->createMany(collect($data['videos'])->map(function ($video) use ($product) {
                return [
                    'model'    => Product::class,
                    'model_id' => $product->id,
                    'title'    => $video['title'],
                    'full_url' => $video['url'],
                    'video_id' => get_youtube_id_from_url($video['url']),
                ];
            })->toArray());
        }


        // ảnh
        if (!empty($data['picture'])) {
            $product->productMedias()->createMany(collect(json_decode($data['picture']))
                ->map(function ($row) use ($product) {
                    return [
                        'model'         => Product::class,
                        'model_id'      => $product->id,
                        'media_file_id' => $row->media_file_id,
                        'title'         => $row->title,
                        'url'           => $row->url,
                    ];
                })
                ->toArray());
        }

        // real_images
        if (!empty($data['real_images'])) {
            $product->realImages()->createMany(collect(json_decode($data['real_images']))
                ->map(function ($row) use ($product) {
                    return [
                        'model'         => Product::class,
                        'model_id'      => $product->id,
                        'media_file_id' => $row->media_file_id,
                        'title'         => $row->title,
                        'url'           => $row->url,
                    ];
                })
                ->toArray());
        }

        // SEO
        if (!empty($product->seo)) {
            $product->seo()->update($data['seo']);
        } else {
            $product->seo()->create($data['seo']);
        }

        $product->productTags()->sync($data['product_tags'] ?? []);

        $this->syncRelation($product, $data, 'relates', true);
        $this->syncRelation($product, $data, 'similars', true);
    }

    public function syncRelation(Product $product, $data, $relation, $sort = false): void
    {
        $dataUpdate = [];

        if (!empty($data[$relation])) {
            if ($sort) {
                foreach ($data[$relation] as $key => $row) {
                    $dataUpdate[$row] = ['sort' => $key];
                }
            } else {
                $dataUpdate = $data[$relation];
            }
        }

        $product->{$relation}()->sync($dataUpdate);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $product
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit($product)
    {
        $this->authorize('products.update');
        $arrAttribute = Attribute::all();
        $product      = Product::with('posts')
                               ->withoutGlobalScope('enabled')
                               ->withoutGlobalScope('published')
                               ->findOrFail($product)
        ;

        $selectAttribute = $this->getAttributeByCategory($product);

        return view('products.form', compact('product', 'arrAttribute', 'selectAttribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdate $request
     * @param int           $product
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(ProductUpdate $request, $product): RedirectResponse
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $product = Product::withoutGlobalScope('enabled')
                              ->withoutGlobalScope('published')
                              ->findOrFail($product)
            ;

            if (empty($product->author)) {
                $data['author'] = auth()->user()->name;
            }

            $data['categories'] = $data['product_category_id'];
            if (is_array($data['product_category_id'])) {
                $data['product_category_id'] = reset($data['product_category_id']);
            }

            // Get product type.

            if ($product->update($data)) {
                $product->videos()->delete();
                $product->productMedias()->delete();
                $product->realImages()->delete();
                $product->posts()->sync($data['posts'] ?? []);
                $product->categories()->sync($data['categories'] ?? []);
                if (!empty($data['attr'])) {
                    $this->syncAttributeProduct($data['attr'], $product);
                }
                $this->storeExtraData($product, $data);
            }

            $this->updateStatusCrawlProduct($product);
            DB::commit();

            return redirect()
                ->route('products.edit', ['product' => $product->id])
                ->with('success', __('Edited success'))
            ;
            //all good
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());

            return redirect()
                ->route('products.edit', ['product' => $product->id])
                ->with('error', $e->getMessage())
            ;
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $product
     *
     * @return void
     * @throws Exception
     */
    public function destroy($product): void
    {
        $product = Product::withoutGlobalScope('enabled')
                          ->withoutGlobalScope('published')
                          ->findOrFail($product)
        ;

        $this->authorize('products.destroy');

        $product->delete();
    }

    /**
     * @param Request $request
     *
     * @return LengthAwarePaginator
     */
    public function accessories(Request $request): LengthAwarePaginator
    {
        app()->resolving(LengthAwarePaginator::class, function (LengthAwarePaginator $paginator) use ($request) {
            $paginator->appends($request->all());
        });

        $product = Product::ignoreGlobalEagerLoading()
                          ->filter($request->all())
                          ->where('name', 'LIKE', '%' . $request->get('q') . '%')
                          ->whereNotIn('status', Product::$hiddenByStatus)
                          ->whereNull('deleted_at')
                          ->orderBy('created_at', 'DESC')
        ;

        if (!empty($orders = $request->get('orders'))) {
            $product->orderByDesc(DB::raw("FIELD(`id`, $orders)"));
        }

        $product = $product->paginate(10, [
            'id',
            'name',
            'price',
            'sale_price',
            'feature_img'
        ]);

        $product->getCollection()->each->setAppends([]);

        return $product;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function quickUpdate(Request $request): JsonResponse
    {
        $this->authorize('products.update');
        $type      = $request->input('type');
        $value     = $request->input('value');
        $productId = $request->input('product_id');

        $result = Product::ignoreGlobalEagerLoading()
                         ->withoutGlobalScope('published')
                         ->withoutGlobalScope('enabled')->findOrFail($productId)
        ;
        $result->setAppends([]);
        $result->{$type} = $value;

        if ($result->save()) {
            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => 0]);
    }

    public function logs($product)
    {
        $product = Product::ignoreGlobalEagerLoading()->findOrFail($product);
        $product->setAppends([]);

        return $product->logs()->with('user')->orderByDesc('id')->get()->transform(function ($log) {
            $changed = [];

            foreach ($log->loggable_content as $field => $value) {
                if ($field == 'status') {
                    $changed[__("fields.$field")] = [
                        'from' => __('products.status.' . config('admin.product_status')[$value['from']]),
                        'to'   => __('products.status.' . config('admin.product_status')[$value['to']]),
                    ];
                } else {
                    $changed[__("fields.$field")] = $value;
                }
            }

            return [
                'user'    => $log->user->name ?? __('Unknown'),
                'action'  => __($log->action),
                'changed' => $changed,
                'time'    => formatDateTimeShow($log->created_at),
            ];
        });
    }

    public function sort()
    {
        return view('products.sort');
    }

    public function showSort(Request $request, $categoryId)
    {
        $order = ProductOrder::where('product_category_id', $categoryId)
                             ->where('type', $request->get('type'))
                             ->first()
        ;

        if (empty($order)) {
            return [];
        }

        $products = Product::ignoreGlobalEagerLoading()
                           ->with('productCategory')
                           ->whereIn('id', explode(',', $order->orders))
                           ->orderByDesc(DB::raw('FIELD(`id`, ' . implode(',',
                                   array_reverse(explode(',', $order->orders))) . ')'))
                           ->get([
                               'id',
                               'name',
                               'product_category_id',
                           ])
        ;

        $products->each->setAppends([]);

        return compact('order', 'products');
    }

    public function getTopItems(ProductCategory $category)
    {
        $order = ProductOrder::where('product_category_id', $category->id)
                             ->where('type', 'home')
                             ->first()
        ;

        $sortSql = 'id';

        if (!empty($order->orders)) {
            $sortSql = DB::raw('FIELD(`id`, ' . implode(',', array_reverse(explode(',', $order->orders))) . ')');
        }

        $products = Product::ignoreGlobalEagerLoading()
                           ->isEnable()
                           ->whereIn('product_category_id', $category->descendants->pluck('id'))
                           ->where('show_on_top', true)
                           ->orderByDesc($sortSql)
                           ->orderByDesc('pin_to_top')
                           ->paginate()
        ;

        $products->getCollection()->each->setAppends([]);

        return $products;
    }

    public function saveSort(SaveProductSort $request)
    {
        $data           = $request->validated();
        $data['orders'] = implode(',', $data['orders']);
        ProductOrder::updateOrCreate([
            'product_category_id' => $data['product_category_id'],
            'type'                => $data['type'],
        ], $data);

        return redirect()->route('products.index');
    }

    public function removeSort(ProductOrder $productOrder)
    {
        $productOrder->delete();
    }

    public function sortByCategory(Request $request, $categoryId)
    {
        // Get product order.
        $category = ProductCategory::with([
            'ancestors' => function (AncestorsRelation $query) {
                $query->select(['id', '_lft', '_rgt'])->orderByDesc('_lft');
            },
            'descendants:id,_lft,_rgt',
        ])
                                   ->findOrFail($categoryId, ['id', '_lft', '_rgt'])
        ;

        $ids = $category->ancestors->pluck('id')->prepend($category->id);

        $order = ProductOrder::whereIn('product_category_id', $ids)
                             ->where('type', 'category')
                             ->orderBy(DB::raw('FIELD(`product_category_id`, ' . $ids->implode(', ') . ')'))
                             ->first()
        ;

        // Get products.
        $productCategoriesIds = $category->descendants->pluck('id')->prepend($category->id);

        $products = Product::ignoreGlobalEagerLoading()->with('productCategory:id,title');

        if ($request->has('ids')) {
            $products->whereIn('id', explode(',', $request->get('ids')));
        } else {
            $products->whereIn('product_category_id', $productCategoriesIds);
        }

        if (!empty($order)) {
            $products->orderByDesc(DB::raw('FIELD(`id`, ' . implode(',',
                    array_reverse(explode(',', $order->orders))) . ')'));
        } else {
            FrontEnd\ProductController::baseSortProducts($products);
        }

        $products = $products->get(['id', 'name', 'product_category_id']);

        $products->each->setAppends([]);

        return $products;
    }

    public function deleteList()
    {
        $products = Product::onlyTrashed()
                           ->withoutGlobalScope('enabled')
                           ->withoutGlobalScope('published')
                           ->with([
                               'productCategory',
                               'reviews'
                           ])
                           ->orderByDesc('id')->paginate()
        ;

        return view('products.delete', [
            'products' => $products
        ]);
    }

    public function restoreProductDelete($id)
    {
        $product = Product::onlyTrashed()
                          ->withoutGlobalScope('enabled')
                          ->withoutGlobalScope('published')
                          ->findOrFail($id)
        ;
        if ($product->restore()) {
            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => 0]);
    }

    public function syncAttributeProduct($data, $product)
    {
        $aryAttrvalue = [];
        foreach ($data as $attrGroup => $attrValue) {
            $aryAttrvalue = array_merge($aryAttrvalue, $attrValue);
        }

        $product->attribute()->sync($aryAttrvalue);

        return true;
    }

    /**
     * Get list attribute by category
     * @param Request $request
     * @return void
     */
    public function getAttributeByCategory($product = null)
    {
        $arrAttribute    = Attribute::all();
        $selectAttribute = [];
        $resultAttribute = [];
        $listCategoryId  = [];
        if ($product != null) {
            $listCategoryId = $product->categories->pluck('id')->toArray();
        } else {
            $listCategoryId = json_decode(request('aryCategory'), true);
        }

        $listCategory = ProductCategory::with(['attribute'])
                                       ->whereIn('id', $listCategoryId)
                                       ->get()
        ;

        foreach ($listCategory as $category) {
            foreach ($category->attribute as $value) {
                if (empty($value->attrCate)) {
                    continue;
                }
                $selectAttribute[$value->attrCate->id][] = $value->id;
                $selectAttribute[$value->attrCate->id]   = array_unique($selectAttribute[$value->attrCate->id]);
            }
        }
        if ($product != null) {
            return $selectAttribute;
        }

        return view('products.elements.attribute', compact('arrAttribute', 'selectAttribute'));
    }

    public function updateStatusCrawlProduct($product)
    {
        $crawlData = CrawlReport::where('product_id', $product->id)->get();
        $status    = 1; // match price

        foreach ($crawlData as $crawl) {
            $detailCrawled = json_decode($crawl->info_product_url, true);
            $priceCrawled  = $detailCrawled['price'];

            $currentPrice = $product->getPriceSaleOrNot();

            if ($priceCrawled != $currentPrice) {
                $status = 2;
            }

            $crawl->update(['status' => $status]);
        }

        return true;
    }
}
