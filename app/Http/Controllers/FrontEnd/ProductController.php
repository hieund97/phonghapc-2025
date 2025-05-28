<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReviewRequest;
use App\Models\Attribute;
use App\Models\Banner;
use App\Models\ContactReceiver;
use App\Models\Gift;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOrder;
use App\Models\ProductTag;
use App\Models\Review;
use App\Models\Slider;
use App\Models\TextLink;
use DB;
use Illuminate\Http\Request;
use Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function show(Request $request, $slug)
    {
        $data = [];

        $product = Product::with([
            'getReviewHasApproved' => function ($query) {
                $query->take(3);
            },
        ])->where('slug', $slug)->firstOrFail();

        if ($product->slug != $slug) {
            return Redirect::to(route('fe.product', ["slug" => $product->slug]), 301);
        }
        $textLinks = TextLink::byModel(Product::class)->whereNotNull('text')->get();

        $product->description = getTextLink($product->description, $textLinks);

        $data["product"] = $product;

        $listCategoryId = $product->categories->pluck('id')->toArray();
        $htmlGift       = Gift::with(['category'])
                              ->whereHas('category', function ($q) use ($listCategoryId) {
                                  $q->whereIn('product_categories.id', $listCategoryId);
                              })->where('status', 1)->select('content')->first()
        ;

        if (!$htmlGift) {
            $htmlGift = $product->gift_product;
        } else {
            $htmlGift = $htmlGift->content;
        }

        $data["htmlGift"] = $htmlGift;

        $ids = array_merge($product->relates->pluck('id')
                                            ->toArray(), [$product->id]);

        $similarProducts = $product->similars;
        if ($similarProducts->isEmpty()) {
            $similarProducts = Product::filter($request->all())->with("categories.gift")
                                      ->where('product_category_id', $product->productCategory->id)
                                      ->whereNotIn('id', $ids)
                                      ->orderByDesc('id')
                                      ->take(15)->get()
            ;
        }
        $data["similarProducts"] = $similarProducts;

        //Hotline Contact
        $data['contacts'] = ContactReceiver::with('contact')->where('id',
            config('front_end.contact_receiver_id.hotline_showroom'))->get();
        //End Hotline Contact

        //Newest Post
        $data['newestPost'] = Post::where('status', array_search('publish', Post::STATUS))
                                  ->where('id', '!=', $product->id)
                                  ->orderBy('id', 'desc')
                                  ->get()
                                  ->take(2)
        ;
        //End Newest Post

        //Review comment
        $data['customerReview'] = Review::where('product_id', $product->id)->where('approved', 1)->orderBy('id',
            'DESC')->get()->take(5);
        //End review comment

        // Sản phầm vừa xem
        $productListNew[$product->id] = [
            'id'             => $product->id,
            'slug'           => $product->slug,
            'name'           => $product->name,
            'price'          => $product->price,
            'real_price'     => $product->getRealPriceAttribute(),
            'label_status'   => $product->labelStatus(),
            'sale_percent'   => $product->salePercent(),
            'is_sale'        => $product->isSale(),
            'include_in_box' => $product->include_in_box,
            'productMedias'  => !empty($product->productMedias[0]) ? get_image_url($product->productMedias[0]->url,
                '') : asset(config('admin.image_not_found')),
            //get_image_url($product->productMedias[0]->url, 'default'),
            'status'         => $product->status,
            'status_note'    => $product->status_note,
            'feature_img'    => $product->feature_img,
            'sale_price'     => $product->sale_price,
            'gift_product'   => $product->gift_product,
            'gift_category'  => $product->categories[0]->gift[0]
        ];

        $cookieProduct         = 'recentlyProductViewed';
        $data["cookieProduct"] = $cookieProduct;
        if (isset($_COOKIE[$cookieProduct])) {
            $productList            = json_decode($_COOKIE[$cookieProduct], true);
            $data['recentlyViewed'] = $productList;
            foreach ($productList as $pro) {
                $productListNew[$pro['id']] = [
                    'id'             => $pro['id'],
                    'slug'           => $pro['slug'],
                    'name'           => $pro['name'],
                    'price'          => $pro['price'],
                    'real_price'     => $pro['real_price'],
                    'label_status'   => $pro['label_status'],
                    'sale_percent'   => $pro['sale_percent'],
                    'is_sale'        => $pro['is_sale'],
                    'include_in_box' => $pro['include_in_box'],
                    'productMedias'  => $pro['productMedias'],
                    'status'         => $pro['status'],
                    'status_note'    => $pro['status_note'],
                    'feature_img'    => $pro['feature_img'],
                    'sale_price'     => $pro['sale_price'],
                    'gift_product'   => $pro['gift_product'] ?? '',
                    'gift_category'  => $pro['gift_category'] ?? ''
                ];
            }

            setcookie($cookieProduct, json_encode($productListNew), time() + (86400 * 90), '/');
        } else {
            setcookie($cookieProduct, json_encode($productListNew), time() + (86400 * 90), '/');
        }

        // Hết sản phẩm vừa xem

        /* Set meta */
        $metaTitle       = (!empty($product->seo->title)) ? $product->seo->title : $product->name;
        $metaDescription = strip_tags((!empty($product->seo->description)) ? $product->seo->description : $product->description);
        $metaImage       = (!empty($product->seo->image)) ? $product->seo->image : get_image_url($product->feature_img,
            '');
        $metaKeywords    = (!empty($product->seo->keyword)) ? $product->seo->keyword : '';
        $canonical       = (!empty($product->seo->canonical)) ? $product->seo->canonical : route('fe.product', [
            "slug" => $product->slug,
        ]);

        $robots = getMetaRobots($product->seo, 1);

        if ($metaDescription) {
            if (mb_strlen($metaDescription, 'UTF-8') > 160) {
                $metaDescription = mb_substr(trim($metaDescription), 0, 157, 'UTF-8') . '...';
            } else {
                $metaDescription = mb_substr(trim($metaDescription), 0, 160, 'UTF-8');
            }
        }
        meta()->set('title', $metaTitle)
              ->set('og:title', $metaTitle)
              ->set('description', $metaDescription)
              ->set('og:description', $metaDescription)
              ->set('og:image', $metaImage)
              ->set('canonical', $canonical)
              ->set('keywords', $metaTitle)
              ->set('twitter:title', $metaTitle)
              ->set('twitter:description', $metaDescription)
              ->set('twitter:image', $metaImage)
        ;

        if ($metaKeywords) {
            meta()->set('keywords', $metaKeywords);
        }
        if ($robots) {
            meta()->set('robots', $robots);
        }

        /* Hết Set meta */

        return view('front_end.products.show', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function review(Request $request, $slug, $id)
    {
        $product = Product::with('reviews')->findOrFail($id);
        /* Set meta */
        $metaTitle       = (!empty($product->seo->title)) ? $product->seo->title : $product->name;
        $metaDescription = strip_tags((!empty($product->seo->description)) ? $product->seo->description : $product->technical_specification);
        $metaImage       = (!empty($product->seo->image)) ? $product->seo->image : ((!empty($product->productMedias[0])) ? get_image_url($product->productMedias[0]->url,
            '') : asset(config('admin.image_not_found')));
        $metaKeywords    = (!empty($product->seo->keyword)) ? $product->seo->keyword : '';
        $canonical       = (!empty($product->seo->canonical)) ? $product->seo->canonical : route('fe.product', [
            "slug" => $product->slug,
            'id'   => $product->id,
        ]);

        meta()->set('title', $metaTitle)
              ->set('og:title', $metaTitle)
              ->set('description', $metaDescription)
              ->set('og:description', $metaDescription)
              ->set('og:image', $metaImage)
              ->set('canonical', $canonical)
              ->set('keywords', $metaTitle)
              ->set('twitter:title', $metaTitle)
              ->set('twitter:description', $metaDescription)
              ->set('twitter:image', $metaImage)
        ;
        meta()->set('robots', 'noindex,nofollow');
        $reviews = Review::where('product_id', $id)->orderBy('id', 'desc')->paginate(10);

        return view('front_end.products.review', compact('product', 'reviews'));
    }

    public function category(Request $request, $slug, $id)
    {
        $type             = 0;
        $category         = ProductCategory::findOrFail($id);
        $listAllAttribute = Attribute::where('status', 1)->get();
        $column           = $request->column ?? 'id';
        $sort             = $request->sort ?? 'DESC';

        switch ($request->column) {
            case 'id':
                $type = 1;
                break;
            case 'sale_price':
                if ($request->sort == 'DESC') {
                    $type = 2;
                } else {
                    $type = 3;
                }
                break;
            case 'view_count':
                $type = 4;
                break;
        }

        // Get real price.
        $rawSqlJustPrice     = '(CASE WHEN `sale_price` IS NOT NULL AND `sale_price` != 0 THEN `sale_price`ELSE `price` END)';
        $realJustPriceColumn = DB::raw($rawSqlJustPrice);

        if ($column == 'sale_price') {
            $column = $realJustPriceColumn;
        }

        if ($category->slug != $slug) {
            return Redirect::to(route('fe.product.tag', ["slug" => $category->slug, 'id' => $category->id]), 301);
        }

        // Add gift for tooltip
        $giftOfCategory = Gift::with(['category'])
            ->whereHas('category', function ($q) use ($id) {
                $q->where('product_categories.id', $id);
            })->where('status', 1)->select('content')->first();

        $data = [];

        $data['type']       = $type;
        $data["aryProduct"] = [];
        $data["isCategory"] = true;

        $data["category"]         = $category;
        $data["listAllAttribute"] = $listAllAttribute;
        $data["gift"] = $giftOfCategory;

        if (!empty($category->manyProducts)) {
            $data["aryProduct"] = $category->manyProducts($column, $sort)
                                           ->paginate(config('front_end.number_of.product_in_detail_cate'))
            ;
        }

        $data["link"] = route('fe.product.category', ["id" => $category->id, 'slug' => $category->slug]);
        /* Set meta */

        $metaTitle       = (!empty($category->seo->title)) ? $category->seo->title : $category->title;
        $metaDescription = strip_tags((!empty($category->seo->description)) ? $category->seo->description : $category->description);
        $metaImage       = (!empty($category->seo->image)) ? $category->seo->image : (($category->thumbnail) ? $category->thumbnail : asset(config('admin.og_image_url')));
        $metaKeywords    = (!empty($category->seo->keyword)) ? $category->seo->keyword : '';
        $canonical       = (!empty($category->seo->canonical)) ? $category->seo->canonical : $data["link"];

        $robots = getMetaRobots($category->seo, 0);
        meta()->set('title', $metaTitle)
              ->set('og:title', $metaTitle)
              ->set('description', $metaDescription)
              ->set('og:description', $metaDescription)
              ->set('og:image', $metaImage)
              ->set('canonical', $canonical)
              ->set('keywords', $metaTitle)
              ->set('twitter:title', $metaTitle)
              ->set('twitter:description', $metaDescription)
              ->set('twitter:image', $metaImage)
        ;
        if ($metaDescription) {
            meta()->set('description', $metaDescription)
                  ->set('og:description', $metaDescription)
            ;
        }
        if ($metaKeywords) {
            meta()->set('keywords', $metaKeywords);
        }
        if ($robots) {
            meta()->set('robots', $robots);
        }

        /* Hết Set meta */

        return view('front_end.category_product.index', $data);
    }

    public function get(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $order   = ProductOrder::where('product_category_id', $id)
                               ->where('type', 'category')
                               ->first()
        ;
        $sortSql = 'id';

        if (!empty($order->orders)) {
            $sortSql = DB::raw('FIELD(`id`, ' . implode(',', array_reverse(explode(',', $order->orders))) . ')');
        }
        $productOnTop = null;
        if (!$request->has('price') && !$request->has('sort_type')) {
            $productOnTop = Product::with('productMedias.mediaFile')
                                   ->whereIn('product_category_id', $category->descendants->pluck('id'))
                                   ->where('show_on_top', true)
                                   ->orderByDesc($sortSql)
                                   ->orderByDesc('pin_to_top')
                                   ->take(20)
                                   ->get()
            ;
        }
        $data["productOnTop"] = $productOnTop;
        // Hết sản phẩm nổi bật
        // Danh sách sản phẩm
        $ids = array_merge($category->descendants->pluck('id')
                                                 ->toArray(), [$category->id]);

        $products = Product::filter($request->all())
                           ->with([
                               'productCategory',
                           ])
                           ->whereIn('product_category_id', $ids)
                           ->whereNotIn('id', $productOnTop ? $productOnTop->pluck('id') : [])
        ;

        $this->sortProducts($products);
        $products  = $products
            ->paginate(16)
        ;
        $totalPage = $products->lastPage();

        return response()->json([
            'view'      => view('front_end.products.elements.product-list', compact(
                'products'
            ))->render(),
            'totalPage' => $totalPage,
        ]);
    }

    public static function sortProducts($products)
    {
        static::baseSortProducts($products);
    }

    public static function getProductsByAttributes($products)
    {
        static::getProductsByAttribute($products);
    }

    /**
     * Sort list of the resource.
     *
     * @param Product|mixed $products
     */
    public static function baseSortProducts($products): void
    {
        // $products->orderBy(DB::raw('FIELD(`status`, ' . Product::STATUS['sold'] . ')'));

        // Sort products.
        $sortType      = request('sort_type');
        $sortDirection = request('sort_direction', 'desc');

        // Get real price.
        $rawSql = '(
            CASE
                WHEN `sale_price` IS NOT NULL AND `sale_price` != 0 AND ((`sale_from` IS NULL AND `sale_to` IS NULL) OR (`sale_from` <= NOW() AND `sale_to` >= NOW())) THEN `sale_price`
                ELSE `price`
            END
        )';

        $rawSqlJustPrice = '(CASE WHEN `sale_price` IS NOT NULL AND `sale_price` != 0 THEN `sale_price`ELSE `price` END)';

        $realPriceColumn     = DB::raw($rawSql);
        $realJustPriceColumn = DB::raw($rawSqlJustPrice);
        $realPriceColumnAs   = DB::raw('*, ' . $rawSql . ' AS `real_price`');

        switch ($sortType) {
            case 'price':
                $products->select($realPriceColumnAs)->orderBy('real_price', $sortDirection);
                break;
            case 'price_asc':
                $products->orderBy($realPriceColumn, 'asc');
                break;
            case 'price_desc':
                $products->orderBy($realPriceColumn, 'desc');
                break;
            case 'newest':
                $products->orderBy('updated_at', $sortDirection);
                break;
            case 'viewed':
                $products->orderBy('viewed', $sortDirection);
                break;
            case 'latest':
                $products->orderBy('created_at', $sortDirection);
                break;
            case 'name':
                $products->orderBy('name', $sortDirection);
                break;
            case 'top_rated':
                $products->orderBy('rate_count', $sortDirection)->orderBy('rate_star', $sortDirection);
                break;
            case 'just_price_asc':
                $products->orderBy($realJustPriceColumn, 'asc');
                break;
            case 'just_price_desc':
                $products->orderBy($realJustPriceColumn, 'desc');
                break;
            default:
                $order           = [];
                $productCategory = array_filter(explode(',', request('product_categories')))[0] ?? [];

                if (!empty($productCategory)) {
                    $category = ProductCategory::with([
                        'ancestors' => function (AncestorsRelation $query) {
                            $query->select(['id', '_lft', '_rgt'])->orderByDesc('_lft');
                        },
                    ])->findOrFail($productCategory, ['id', '_lft', '_rgt']);

                    $ids = $category->ancestors->pluck('id')->prepend($category->id);

                    $order = ProductOrder::whereIn('product_category_id', $ids)
                                         ->where('type', 'category')
                                         ->orderBy(DB::raw('FIELD(`product_category_id`, ' . $ids->implode(', ') . ')'))
                                         ->first()
                    ;
                }

                if (!empty($order)) {
                    $products->orderByDesc(DB::raw('FIELD(`id`, ' . implode(',',
                            array_reverse(explode(',', $order->orders))) . ')'));
                } else {
                    $products->orderBy('pin_to_top', $sortDirection)
                             ->orderBy(DB::raw('price - sale_price'), $sortDirection)
                    ;
                }
                break;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function tag(Request $request, $slug, $id)
    {
        $productTag = ProductTag::with(['products'])->findOrFail($id);

        if ($productTag->slug != $slug) {
            return Redirect::to(route('fe.product.tag', ["slug" => $productTag->slug, 'id' => $productTag->id]), 301);
        }

        $data = [];

        $data["productTag"] = $productTag;

        $data["sliders"] = Slider::where('status', true)
                                 ->where('model', ProductTag::class)
                                 ->where('model_id', $id)
                                 ->orderBy('sort')
                                 ->orderByDesc('id')
                                 ->get()
        ;
        $data["banners"] = Banner::where('status', true)
                                 ->where('model', ProductTag::class)
                                 ->where('model_id', $id)
                                 ->orderBy('sort')
                                 ->orderByDesc('id')
                                 ->take(2)
                                 ->get()
        ;
        // Tin nổi bật
        $order   = ProductOrder::where('product_category_id', $id)
                               ->where('type', 'category')
                               ->first()
        ;
        $sortSql = 'id';

        if (!empty($order->orders)) {
            $sortSql = DB::raw('FIELD(`id`, ' . implode(',', array_reverse(explode(',', $order->orders))) . ')');
        }
        $productOnTop = [];

        if (!$request->has('price') && !$request->has('sort_type')) {
            $productOnTop = $productTag->products
                ->where('show_on_top', true)
                ->sortByDesc($sortSql)
                ->sortByDesc('pin_to_top')
                ->take(20)
            ;
        }
        $data["productOnTop"] = $productOnTop;
        // Hết sản phẩm nổi bật

        // Tin tức
        $data["posts"] = $productTag->posts;

        // Text link
        $data["brands"]       = TextLink::byModel(ProductTag::class)->byType(1)
                                        ->where('model_id', $productTag->id)
                                        ->orderBy('sort', 'ASC')
                                        ->get()
        ;
        $data["productTypes"] = TextLink::byModel(ProductTag::class)->byType(2)
                                        ->where('model_id', $productTag->id)
                                        ->orderBy('sort', 'ASC')
                                        ->get()
        ;
        // Hết text link

        $data["link"] = route('fe.product.tag', ["id" => $productTag->id, 'slug' => $productTag->slug]);

        /* Set meta */
        $metaTitle       = (!empty($productTag->seo->title)) ? $productTag->seo->title : $productTag->title;
        $metaDescription = strip_tags((!empty($productTag->seo->description)) ? $productTag->seo->description : $productTag->description);
        $metaImage       = (!empty($productTag->seo->image)) ? $productTag->seo->image : (($productTag->thumbnail) ? $productTag->thumbnail : asset(config('admin.og_image_url')));
        $metaKeywords    = (!empty($productTag->seo->keyword)) ? $productTag->seo->keyword : '';
        $canonical       = (!empty($productTag->seo->canonical)) ? $productTag->seo->canonical : $data["link"];
        $robots          = getMetaRobots($productTag->seo, 0);
        meta()->set('title', $metaTitle)
              ->set('og:title', $metaTitle)
              ->set('og:image', $metaImage)
              ->set('canonical', $canonical)
        ;
        if ($metaDescription) {
            meta()->set('description', $metaDescription)
                  ->set('og:description', $metaDescription)
            ;
        }
        if ($metaKeywords) {
            meta()->set('keywords', $metaKeywords);
        }
        if ($robots) {
            meta()->set('robots', $robots);
        }

        /* Hết Set meta */

        return view('front_end.products.tag', $data);
    }

    public function getProductByTag(Request $request, $id)
    {
        $productTag = ProductTag::findOrFail($id);

        $order   = ProductOrder::where('product_category_id', $id)
                               ->where('type', 'category')
                               ->first()
        ;
        $sortSql = 'id';

        if (!empty($order->orders)) {
            $sortSql = DB::raw('FIELD(`id`, ' . implode(',', array_reverse(explode(',', $order->orders))) . ')');
        }
        $productOnTop = null;
        if (!$request->has('price') && !$request->has('sort_type')) {
            $productOnTop = $productTag->products
                ->where('show_on_top', true)
                ->sortByDesc($sortSql)
                ->sortByDesc('pin_to_top')
                ->take(20)
            ;
        }
        $data["productOnTop"] = $productOnTop;
        // Hết sản phẩm nổi bật
        // Danh sách sản phẩm

        $products = $productTag->products()->filter($request->all())
                               ->with([
                                   'productCategory',
                               ])
                               ->whereNotIn('id', $productOnTop ? $productOnTop->pluck('id') : [])
        ;

        $this->sortProducts($products);
        $products  = $products
            ->paginate(16)
        ;
        $totalPage = $products->lastPage();

        return response()->json([
            'view'      => view('front_end.products.elements.product-list', compact(
                'products'
            ))->render(),
            'totalPage' => $totalPage,
        ]);
    }

    public static function getProductsByAttribute($products)
    {
        $arrAttribute = request('array_attribute');
        if (!is_array($arrAttribute) && isJson($arrAttribute)) {
            $arrAttribute = json_decode($arrAttribute, true);
            $arrAttribute = array_unique($arrAttribute);
        }

        $products->with(['attribute'])
                 ->whereHas('attribute', function ($q) use ($arrAttribute) {
                     $q->whereIn('attribute_values.id', $arrAttribute);
                 })
        ;
    }

    public function filterAttribute(Request $request)
    {
        $isAjax       = true;
        $category     = null;
        $isCategory   = false;
        $arrAttribute = request('array_attribute');
        if (!is_array($arrAttribute) && isJson($arrAttribute)) {
            $arrAttribute = json_decode($arrAttribute, true);
            $arrAttribute = array_unique($arrAttribute);
        }
        if (!empty($request->id)) {
            $isCategory = true;
            $category   = ProductCategory::findOrFail($request->id);
            $aryProduct = $category->manyProducts();
            static::getProductsByAttribute($aryProduct);
            $aryProduct = $aryProduct->get();
        } else {
            $aryProduct = Product::with(['attribute'])
                                 ->whereHas('attribute', function ($q) use ($arrAttribute) {
                                     $q->whereIn('attribute_values.id', $arrAttribute);
                                 })->limit(20)->get()
            ;
        }


        return view('front_end.partials.list-product',
            compact('aryProduct', 'category', 'isAjax', 'title', 'isCategory'));
    }

    public function filterAttributeCategory(Request $request)
    {
        $type             = 0;
        $title            = null;
        $isAjax           = true;
        $category         = null;
        $isFilterCategory = true;
        $isCategory       = true;
        $listIdProd       = [];
        $listAllAttribute = Attribute::all();
        $q                = $request->get('q');
        $column           = $request->column ?? 'id';
        $sort             = $request->sortFilter ?? 'DESC';

        switch ($request->column) {
            case 'id':
                $type = 1;
                break;
            case 'sale_price':
                if ($request->sortFilter == 'DESC') {
                    $type = 2;
                } else {
                    $type = 3;
                }
                break;
            case 'view_count':
                $type = 4;
                break;
            case 'rate_count':
                $type = 5;
                break;
            case 'name':
                $type = 6;
                break;
        }

        // Get real price.
        $rawSqlJustPrice     = '(CASE WHEN `sale_price` IS NOT NULL AND `sale_price` != 0 THEN `sale_price`ELSE `price` END)';
        $realJustPriceColumn = DB::raw($rawSqlJustPrice);

        if ($column == 'sale_price') {
            $column = $realJustPriceColumn;
        }

        $selectedAttribute = request('array_attribute') ?? [];
        if (!is_array($selectedAttribute) && isJson($selectedAttribute)) {
            $selectedAttribute = json_decode($selectedAttribute, true);
            $selectedAttribute = array_unique($selectedAttribute);
        }


        if (!empty($request->id)) {
            $category = ProductCategory::findOrFail($request->id);
        } else {
            $title      = 'Kết quả tìm kiếm:';
            $isCategory = false;
        }

        if (count($selectedAttribute) == 0) {
            $isFilterCategory = false;
            if (!empty($category)) {
                $aryProduct = $category->manyProducts($column, $sort)->get();
            }
            elseif (!empty($q)) {
                $aryProduct = $this->getListProdByArrayAttribute(
                    $selectedAttribute, $q, null, $column, $sort
                );
            }
        } else {
            $aryProduct = $this->getListProdByArrayAttribute(
                $selectedAttribute, $q, !empty($category) ? $category->id : null, $column, $sort
            );
            if (count($aryProduct) == 0) {
                $isFilterCategory = false;
            }
        }

        $gift = Gift::with(['category'])
            ->whereHas('category', function ($q) use ($request) {
                $q->where('product_categories.id', $request->id);
            })->where('status', 1)->select('content')->first();

        if ($request->has('is_call_modal')) {
            $attrCategory = $category;
            $arrProduct   = $aryProduct ?? [];
            //$type         = 0;
            $arrAttribute = $selectedAttribute;

            return view('front_end.build_pc.modal',
                compact('attrCategory', 'arrProduct', 'type', 'arrAttribute', 'listAllAttribute', 'isFilterCategory'));
        } else {
            return view('front_end.category_product.element.content-category',
                compact('aryProduct', 'category', 'isAjax', 'isCategory', 'selectedAttribute', 'isFilterCategory',
                    'listAllAttribute', 'title', 'type', 'gift'));
        }
    }

    public function viewCount(Request $request)
    {
        $product   = Product::findOrFail($request['id']);
        $viewCount = $product->view_count;

        $product->view_count = $viewCount + 1;
        $product->save();

        return response()->json(['message' => 'success'], 200);
    }

    public function rateProduct(ProductReviewRequest $request)
    {
        Review::create([
            'product_id' => $request['product_id'],
            'body'       => $request['body'],
            'full_name'  => $request['full_name'],
            'rating'     => $request['rating'],
            'email'      => $request['email'],
        ]);

        return response()->json(['message' => 'success'], 200);
    }


    /**
     * API Update price for merchant store
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePriceApi()
    {
        $token      = 'ILAEUV6HPQANLTXI67VG94VC6B9NTP08';
        $token_post = request('token', '');
        $url        = request('url', '');
        $price      = request('price', '');

        if (strpos($url, '.html') !== false) {
            $url = str_replace(".html", "", $url);
        }
        //saleoff
        if (!empty($url) && !empty($price) && !empty($token_post)) {
            if ($token_post !== $token) {
                $message = [
                    'status'  => false,
                    'message' => "Invalid Token"
                ];

                return response()->json($message, 400);
            } else {
                $product = Product::where('slug', $url)->first();
                if (!empty($product)) {
                    $product->update([
                        'sale_price' => $price
                    ]);
                    $message = [
                        'status'  => true,
                        'message' => "Success"
                    ];

                    return response()->json($message, 200);
                } else {
                    $message = [
                        'status'  => false,
                        'message' => "Product does not exist"
                    ];

                    return response()->json($message, 404);
                }
            }
        } else {
            $message = [
                'status'  => 400,
                'message' => "One of the request inputs is not valid."
            ];

            return response()->json($message, 400);
        }
    }

    protected function getListProdByArrayAttribute(
        $arrayAttribute,
        $q = null,
        $categoryID = null,
        $column = 'id',
        $sort = 'DESC'
    ) {
        if (!empty($arrayAttribute)) {
            $listIdProd = \DB::table('attribute_relationships')
                             ->select('product_id')
                             ->whereIn('attr_id', $arrayAttribute)
                             ->groupBy('product_id')
                             ->havingRaw('COUNT(product_id) = ' . count($arrayAttribute))
                             ->get()->pluck('product_id')->toArray()
            ;

            $aryProduct = Product::whereIn('id', $listIdProd);
        } else {
            $aryProduct = new Product();
        }


        if (!empty($q)) {
            $aryProduct = $aryProduct->where('name', 'LIKE', "%" . $q . "%");
        }

        if (!empty($categoryID)) {
            $aryProduct = $aryProduct->join('product_category', 'products.id', '=', 'product_category.product_id')
                                     ->where('product_category.product_category_id', $categoryID)
            ;
        }

        return $aryProduct->orderBy($column, $sort)->get();
    }

    public function getConfigDetail(Request $request) {

    }
}
