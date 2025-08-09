<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Post;
use App\Models\Category;
use App\Models\ProductTag;
use App\Models\PostTag;
use App\Models\Page;

class SiteMapController extends Controller
{
    public function index()
    {
        public function index()
    {
        $sitemaps = [
            'sitemap-product-categories.xml',
            'sitemap-products.xml',
            'sitemap-product-tags.xml',
            'sitemap-post-categories.xml',
            'sitemap-post-tags.xml',
            'sitemap-posts.xml',
            'sitemap-pages.xml',
        ];

        return response()
            ->view('front_end.sitemap.index', compact('sitemaps'))
            ->header('Content-Type', 'text/xml');
    }
    }

    public function productCategories()
    {
        $categories = ProductCategory::latest()->get();

        return response()->view('front_end.sitemap.product_category', [
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml')
            ;
    }

    public function products()
    {
        $products = Product::latest()->get();

        return response()->view('front_end.sitemap.products', [
            'products' => $products,
        ])->header('Content-Type', 'text/xml')
            ;
    }

    public function productTags()
    {
        $tags = ProductTag::all();

        return response()->view('front_end.sitemap.product_tags', [
            'tags' => $tags,
        ])->header('Content-Type', 'text/xml')
            ;
    }

    public function categories()
    {
        $categories = Category::all();

        return response()->view('front_end.sitemap.post_categories', [
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml')
            ;
    }

    public function postTags()
    {
        $tags = PostTag::all();

        return response()->view('front_end.sitemap.post_tags', [
            'tags' => $tags,
        ])->header('Content-Type', 'text/xml')
            ;
    }

    public function posts()
    {
        $posts = Post::all();

        return response()->view('front_end.sitemap.posts', [
            'posts' => $posts,
        ])->header('Content-Type', 'text/xml')
            ;
    }

    public function page()
    {
        $pages = Page::latest()->get();

        return response()->view('front_end.sitemap.pages', [
            'pages' => $pages,
        ])->header('Content-Type', 'text/xml')
            ;
    }
}
