<?php

namespace App\Http\Controllers\FrontEnd;

use App\Exports\BuildPcExport;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Option;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOrder;
use App\Models\Slider;
use App\Models\TextLink;
use Illuminate\Support\Facades\Cache;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Kalnoy\Nestedset\DescendantsRelation;
use PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App;
use function Deployer\get;
use Jenssegers\Agent\Agent as Agent;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [];

        //Cache Slider homepage
        if (Cache::has('sliders_of_homepage')) {
            $data["sliders"] = Cache::get('sliders_of_homepage');
        } else {
            $data["sliders"] = Cache::remember('sliders_of_homepage', 15, function () {
                return Slider::with('productMedias')
                             ->where('status', true)
                             ->get()
                             ->map(function ($query) {
                                 $query->setRelation('productMedias', $query->productMedias->take(4));

                                 return $query;
                             })
                ;
            });
        }


        // Cache saleProduct
        if (Cache::has('sale_products')) {
            $data["saleProducts"] = Cache::get('sale_products');
        } else {
            $data["saleProducts"] = Cache::remember('sale_products', 15, function () {
                return Product::inSaleTime()
                              ->orderBy('id', 'DESC')
                              ->take(config('front_end.number_of.sale_product'))
                              ->get()
                ;
            });
        }

        // Cache slider customer
        if (Cache::has('slider_customer')) {
            $data["sliderCustomer"] = Cache::get('slider_customer');
        } else {
            $data["sliderCustomer"] = Cache::remember('slider_customer', 15, function () {
                return Slider::with('productMedias')->where('id',
                    config('front_end.home_slider.customer'))->get();
            });
        }

        // Cache main product by category
        if (Cache::has('categories_of_homepage')) {
            $categories = Cache::get('categories_of_homepage');
        } else {
            $categories = Cache::remember('categories_of_homepage', 15, function () {
                return ProductCategory::with([
                    'childrenEnable',
                    'gift',
                    'manyProducts' =>
                        function ($q) {
                            return $q->where('show_on_top', 1)
                                     ->select('id', 'name', 'price', 'sale_price', 'feature_img', 'status', 'slug', 'gift_product', 'border_image', 'is_border')
                                     ->orderBy('created_at', 'DESC')
                            ;
                        }
                ])
                                      ->where('status', true)
                                      ->where('is_menu_home', true)
                                      ->orderBy('ordering_menu_home')
                                      ->get(['id', 'title', 'slug'])
                                      ->take(config('front_end.number_of.cate_in_homepage'))
                                      ->map(function ($query) {
                                          $query->setRelation('manyProducts',
                                              $query->manyProducts->take(config('front_end.number_of.product_in_cate')));

                                          return $query;
                                      })
                                      ->map(function ($childQuery) {
                                          $childQuery->setRelation('childrenEnable',
                                              $childQuery->childrenEnable->take(config('front_end.number_of.product_category_child')));

                                          return $childQuery;
                                      })
                                      ->toArray()
                ;
            });
        }

        $data["categories"] = $categories;

        $metaData = Option::where('option_tab', 'seo')
                          ->orWhere('option_tab', 'info')
                          ->pluck('option_value', 'option_name')
                          ->toArray()
        ;

        if (count($metaData) > 0) {
            /* Set meta */
            $robots = getMetaRobots('', 0);
            meta()->set('title', $metaData['seo_meta_title'])
                  ->set('description', $metaData['seo_meta_description'])
                  ->set('og:title', $metaData['seo_meta_title'])
                  ->set('og:description', $metaData['seo_meta_description'])
                  ->set('og:site_name', $metaData['info_site_name'])
                  ->set('keywords', $metaData['seo_meta_keyword'])
                  ->set('og:image', $metaData['seo_meta_image'] ?? asset('ccc.png'))
                  ->set('canonical', route('fe.home'))
                  ->set('twitter:title', $metaData['seo_meta_title'])
                  ->set('twitter:description', $metaData['seo_meta_description'])
                  ->set('twitter:image', $metaData['seo_meta_image'] ?? asset('ccc.png'))
            ;

            if ($robots) {
                meta()->set('robots', $robots);
            }
            /* Hết Set meta */
        }

        return view('front_end.home.index', $data);
    }

    /*
     * Build PC function
     */
    public function buildPC()
    {
        $arrCateBuildPC = ProductCategory::where('is_build', 1)
                                         ->where('status', 1)
                                         ->orderBy('ordering_menu_build')
                                         ->get()
        ;

        return view('front_end.build_pc.index', compact('arrCateBuildPC'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function callModal(Request $request)
    {
        $type             = 0;
        $arrAttribute     = $request->array_attribute;
        $listAllAttribute = App\Models\Attribute::select('id', 'title')->get();
        $attrCategory     = ProductCategory::where('id', $request->id)->first();
        $column           = 'id';
        $sort             = $request->sort_direction ?? 'DESC';

        if (isset($request->sort_type)) {
            // Get real price.
            $rawSqlJustPrice     = '(CASE WHEN `sale_price` IS NOT NULL AND `sale_price` != 0 THEN `sale_price`ELSE `price` END)';
            $realJustPriceColumn = DB::raw($rawSqlJustPrice);

            switch ($request->sort_type) {
                case 'newest':
                    $column = 'id';
                    $type   = 1;
                    break;
                case 'viewed':
                    $column = 'view_count';
                    $type   = 4;
                    break;
                case 'name':
                    $column = 'name';
                    $type   = 6;
                    break;
                case 'top_rated':
                    $column = 'rate_count';
                    $type   = 5;
                    break;
                case 'just_price_asc':
                    $column = $realJustPriceColumn;
                    $type   = 2;
                    break;
                case 'just_price_desc':
                    $type   = 3;
                    $column = $realJustPriceColumn;
                    break;
                default:
                    break;
            }
        }

        $arrProduct = $attrCategory->manyProducts($column, $sort);

        if (isset($arrAttribute) && !empty(json_decode($arrAttribute, true))) {
            if (!is_array($arrAttribute) && isJson($arrAttribute)) {
                $arrAttribute = json_decode($arrAttribute, true);
                $arrAttribute = array_unique($arrAttribute);
            }

            ProductController::getProductsByAttribute($arrProduct);
        }

        $arrProduct = $arrProduct->get();

        return view('front_end.build_pc.modal',
            compact('attrCategory', 'arrProduct', 'type', 'arrAttribute', 'listAllAttribute'));
    }

    /**
     * View and print product buildPC list
     * @param Request $request
     * @return void
     */
    public function viewAndPrint(Request $request)
    {
        $data = json_decode($request->build_pc, true);
        $pdf  = PDF::loadView('front_end.build_pc.pdf', ['data' => $data]);
        //if you want to view as landscape paper
        // $pdf->setPaper('A4', 'landscape');

        return view('front_end.build_pc.pdf', compact('data'));
    }

    /**
     * Export and download list item of build pc
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excelDownload(Request $request)
    {
        $data = json_decode($request->excel_build_pc, true);

        return Excel::download(new BuildPcExport($data), 'build_pc.xlsx');
    }

    /**
     * Generate image of list build PC
     * @param Request $request
     * @return mixed
     */
    public function generateImage(Request $request)
    {
        $data = json_decode($request->generate_image, true);

        $total = $data['total'];
        unset($data['total']);

        usort($data, function ($a, $b) {
            return $a['sort'] <=> $b['sort'];
        });
        $Agent = new Agent();
        if ($Agent->isMobile()) {
            return view('front_end.build_pc.image_mobile', compact('data', 'total'));
        } else {
            return view('front_end.build_pc.image', compact('data', 'total'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkLocalStorageBuildPc(Request $request)
    {
        $data = json_decode($request->data, true);

        $listView = [];
        foreach ($data as $key => $prod) {
            if ($key == 'total') {
                continue;
            }

            $listView[$prod['category_id']] = view('front_end.build_pc.itemRow', compact('prod'))->render();
        }

        return response()->json(['view' => $listView, 'total' => $data['total']], 200);
    }
}
