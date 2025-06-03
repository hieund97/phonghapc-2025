<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $column   = $request->column ?? 'id';
        $sort     = $request->sort ?? 'DESC';
        $q        = $request->get('q');
        $products = Product::where('name', 'LIKE', "%{$q}%")
                           ->orderBy($column, $sort)
                           ->paginate()
        ;
        $listAllAttribute = Attribute::all();
        $type     = 'product';
        if ($q) {
            /* Set meta */
            $metaTitle = 'Kết quả tìm kiếm ' . $q . ' | maytinhnamha.vn';

            meta()->set('title', $metaTitle)
                  ->set('og:title', $metaTitle)
                  ->set('description', $metaTitle)
                  ->set('og:description', $metaTitle)
                  ->set('keywords', $q)
                  ->set('canonical', route('fe.search.index', ['q' => $q]))
            ;
            /* Hết Set meta */
        }

        meta()->set('robots', 'noindex,nofollow');

        return view('front_end.searchs.index', compact('q', 'type', 'products', 'listAllAttribute'));
    }

    public function get(Request $request)
    {
        $q    = $request->get('q');
        $type = $request->get('type');
        if ($type == 'post') {
            $posts     = Post::filter($request->all())->where('title', 'LIKE', "%{$q}%")
                             ->paginate(16)
            ;
            $totalPage = $posts->lastPage();

            return response()->json([
                'view'      => view('front_end.posts.elements.post-list', compact(
                    'posts'
                ))->render(),
                'totalPage' => $totalPage,
            ]);
        } else {
            if ($type == 'product') {
                $products  = Product::filter($request->all())->where('name', 'LIKE', "%{$q}%")
                                    ->orderByDesc('id')
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
        }
    }

    public function suggest(Request $request)
    {
        $q        = $request->get('q');
        $products = Product::where('name', 'LIKE', "%" . $q . "%")
                           ->withoutGlobalScope('published')
                           ->orderBy('id', 'DESC')
                           ->take(16)
                           ->get()
        ;

        return view('front_end.searchs.suggest', compact('products'));
    }
}
