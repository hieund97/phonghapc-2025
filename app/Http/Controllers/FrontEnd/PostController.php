<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\TextLink;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Redirect;
use App\Models\ItemRelate;

class PostController extends Controller
{
    //
    public function index()
    {
        $postCategories = Category::with('posts')->where('highlight', 1)->get([
            'id',
            'title',
            'slug',
            'parent_id'
        ])->take(7);
        $textLinks      = TextLink::byModel('PagePost')->whereNotNull('text')->get(['text', 'link']);
        $featurePost    = Post::where('status', array_search('publish', Post::STATUS))
                              ->where('published_at', '<', now())
                              ->where('is_featured', 1)
                              ->orderBy('published_at', 'desc')
                              ->first()
        ;
        if (empty($featurePost)) {
            $featurePost = Post::where('status', array_search('publish', Post::STATUS))
                               ->orderBy('published_at', 'desc')
                               ->first()
            ;
        }

        $newPosts = Post::where('status', array_search('publish', Post::STATUS))
                        ->when(!empty($featurePost) && !empty($featurePost->id), function ($query) use ($featurePost) {
                            $query->where('id', '!=', $featurePost->id);
                        })
                        ->where('published_at', '<', now())
                        ->orderBy('published_at', 'desc')
                        ->get()
                        ->take(3)
        ;

        $eventPosts   = Post::where('status', array_search('publish', Post::STATUS))
                            ->where('published_at', '<', now())
                            ->where('is_event', 1)
                            ->orderBy('published_at', 'desc')
                            ->get()
                            ->take(5)
        ;
        $featurePosts = Post::where('status', array_search('publish', Post::STATUS))
                            ->where('published_at', '<', now())
                            ->where('is_featured', 1)
                            ->get()
                            ->take(6)
        ;
        /* Set meta */
        $metaTitle       = 'Tin tức công nghệ cập nhật 24h - phonghacomputer.vn';
        $metaDescription = 'Thông tin công nghệ, thiết bị mới nhất được cập nhật hằng giờ. Tin về sản phẩm mới mắt, đánh giá sản phẩm, mẹo hay sử dụng...';
        $robots          = getMetaRobots('', 0);
        meta()->set('title', $metaTitle)
              ->set('og:title', $metaTitle)
              ->set('description', $metaDescription)
              ->set('og:description', $metaDescription)
              ->set('keywords', 'Tin tức, tin công nghệ, tin đồ chơi công nghệ, đánh giá sản phẩm')
              ->set('og:image', asset(config('admin.og_image_url')))
              ->set('canonical', route('fe.post.index'))
        ;
        if ($robots) {
            meta()->set('robots', $robots);
        }

        /* Hết Set meta */

        return view('front_end.posts.index', compact(
            'featurePost',
            'newPosts',
            'eventPosts',
            'featurePosts',
            'postCategories',
            'textLinks'
        ));
    }

    public function getPost(Request $request)
    {
        $ids       = $request->ids;
        $posts     = Post::where('status', array_search('publish', Post::STATUS))
                         ->whereNotIn('id', $ids)
                         ->where('published_at', '<', now())
                         ->with('categories')
                         ->orderBy('published_at', 'desc')
                         ->paginate(10)
        ;
        $totalPage = $posts->lastPage();

        return response()->json([
            'view'      => view('front_end.posts.elements.post-item', compact(
                'posts'
            ))->render(),
            'totalPage' => $totalPage,
        ]);
    }

    public function show($slug, $id)
    {
        $cateNavBar = Category::with('posts')->where('highlight', 1)->get([
            'id',
            'title',
            'slug',
            'parent_id'
        ])->take(7);
        $post       = Post::with(['categories.posts', 'postTags.posts'])->where('status',
            array_search('publish', Post::STATUS))->findOrFail($id);

        // Redirect
        if ($post->slug != $slug) {
            return Redirect::to(route('fe.post', ["slug" => $post->slug, 'id' => $post->id]), 301);
        }
        // End redirect

        $textLinks = TextLink::byModel(Post::class)->whereNotNull('text')->get(['text', 'link']);

        $post->content = getTextLink($post->content, $textLinks);

        $tags        = $post->postTags;
        $randomPosts = Post::with('categories')->whereHas('categories', function ($q) {
            // $q->where('highlight', 1);
        })->where('status', array_search('publish', Post::STATUS))
                           ->where('id', '!=', $id)
                           ->inRandomOrder()
                           ->get()
                           ->take(4)
        ;
        $newPosts            = Post::where('status', array_search('publish', Post::STATUS))
                                   ->where('id', '!=', $id)
                                   ->orderBy('id', 'desc')
                                   ->get()
                                   ->take(4)
        ;
        $postTagCollectionId = new Collection();
        foreach ($tags as $tag) {
            $postTagCollectionId = $postTagCollectionId->merge($tag->posts->pluck('id'));
        }
        $sameCategoryPosts = Post::whereIn('id', $postTagCollectionId)->where('id', '!=', $id)->get()->take(6);

        $postCategories = $post->categories->take(12);


        $productRelateds = ItemRelate::where("model", Post::class)->where("model_id", $post->id)->get();

        /* Set meta */
        $metaTitle       = (!empty($post->seo->title)) ? $post->seo->title : $post->title;
        $metaDescription = strip_tags((!empty($post->seo->description)) ? $post->seo->description : $post->excerpt);
        $metaImage       = (!empty($post->seo->image)) ? $post->seo->image : $post->thumbnail;
        $metaKeywords    = (!empty($post->seo->keyword)) ? $post->seo->keyword : '';
        $canonical       = (!empty($post->seo->canonical)) ? $post->seo->canonical : route('fe.post', [
            "slug" => $post->slug,
            'id'   => $post->id,
        ]);

        $robots = getMetaRobots($post->seo, 1);
        meta()->set('title', $metaTitle)
              ->set('og:title', $metaTitle)
              ->set('description', $metaDescription)
              ->set('og:description', $metaDescription)
              ->set('og:image', $metaImage)
              ->set('canonical', $canonical)
        ;

        if ($metaKeywords) {
            meta()->set('keywords', $metaKeywords);
        }
        if ($robots) {
            meta()->set('robots', $robots);
        }

        $featurePosts = Post::where('status', array_search('publish', Post::STATUS))
                            ->where('published_at', '<', now())
                            ->where('is_featured', 1)
                            ->get()
                            ->take(6);

        /* Hết Set meta */

        return view('front_end.posts.show', compact(
            'post',
            'randomPosts',
            'newPosts',
            'sameCategoryPosts',
            'postCategories',
            'tags',
            'productRelateds',
            'cateNavBar',
            'featurePosts',
        ));
    }

    public function category($slug, $id)
    {
        $postCategories = Category::with('posts')->where('highlight', 1)->get([
            'id',
            'title',
            'slug',
            'parent_id'
        ])->take(7);
        //$postCategories = Category::where('id', '!=', $id)->get(['id', 'title', 'slug', 'parent_id'])->take(7);
        $category     = Category::with(['posts'])->findOrFail($id);
        $postPaginate = $category->posts()->orderBy('id', 'DESC')->paginate(6);
        if ($category->slug != $slug) {
            return Redirect::to(route('fe.post.category', ["slug" => $category->slug, 'id' => $category->id]), 301);
        }
        $productTypes = TextLink::byModel(Category::class)->byType(2)
                                ->where('model_id', $id)
                                ->orderBy('sort', 'ASC')
                                ->get()
        ;
        $featurePost  = $category->posts->where('status', array_search('publish', Post::STATUS))
                                        ->where('is_featured', 1)
                                        ->sortByDesc('id')
                                        ->first()
        ;
        if (empty($featurePost)) {
            $featurePost = Category::findOrFail($id)->posts->where('status', array_search('publish', Post::STATUS))
                                                           ->sortByDesc('id')
                                                           ->first()
            ;
        }
        $newPosts = [];
        if ($featurePost) {
            $idFeaturePost = $featurePost->id;
            $newPosts      = $category->posts->where('status', array_search('publish', Post::STATUS))
                                             ->where('id', '!=', $idFeaturePost)
                                             ->sortByDesc('id')
                                             ->take(3)
            ;
        }


        $eventPosts   = $category->posts->where('status', array_search('publish', Post::STATUS))
                                        ->where('is_event', 1)
                                        ->sortByDesc('id')
                                        ->take(8)
        ;
        $featurePosts = $category->posts->where('status', array_search('publish', Post::STATUS))
                                        ->where('is_featured', 1)
                                        ->take(6)
        ;

        /* Set meta */
        $metaTitle       = (!empty($category->seo->title)) ? $category->seo->title : $category->title;
        $metaDescription = strip_tags((!empty($category->seo->description)) ? $category->seo->description : $category->description);
        $metaImage       = (!empty($category->seo->image)) ? $category->seo->image : $category->thumbnail;
        $metaKeywords    = (!empty($category->seo->keyword)) ? $category->seo->keyword : '';
        $canonical       = (!empty($category->seo->canonical)) ? $category->seo->canonical : route('fe.post.category', [
            "slug" => $category->slug,
            'id'   => $category->id,
        ]);
        $robots          = getMetaRobots($category->seo, 0);
        meta()->set('title', $metaTitle)
              ->set('og:title', $metaTitle)
              ->set('description', $metaDescription)
              ->set('og:description', $metaDescription)
              ->set('og:image', $metaImage)
              ->set('canonical', $canonical)
        ;

        if ($metaKeywords) {
            meta()->set('keywords', $metaKeywords);
        }
        if ($robots) {
            meta()->set('robots', $robots);
        }

        /* Hết Set meta */

        return view('front_end.posts.category', compact(
            'featurePost',
            'newPosts',
            'eventPosts',
            'featurePosts',
            'postCategories',
            'category',
            'productTypes',
            'postPaginate'
        ));
    }

    public function getPostCategory(Request $request, $id)
    {
        $ids       = $request->ids;
        $posts     = Category::with(['posts'])
                             ->findOrFail($id)
                             ->posts()
                             ->where('status', array_search('publish', Post::STATUS))
                             ->whereNotIn('id', $ids)
                             ->orderBy('published_at', 'desc')
                             ->paginate(10)
        ;
        $totalPage = $posts->lastPage();

        return response()->json([
            'view'      => view('front_end.posts.elements.post-item', compact(
                'posts'
            ))->render(),
            'totalPage' => $totalPage,
        ]);
    }

    public function tag($slug, $id)
    {
        $tag = PostTag::with(['posts'])->findOrFail($id);

        if ($tag->slug != $slug) {
            return Redirect::to(route('fe.post.tag', ["slug" => $tag->slug, 'id' => $tag->id]), 301);
        }

        $featurePost = $tag->posts->where('status', array_search('publish', Post::STATUS))
                                  ->where('is_featured', 1)
                                  ->sortByDesc('id')
                                  ->first()
        ;
        if (empty($featurePost)) {
            $featurePost = $tag->posts->where('status', array_search('publish', Post::STATUS))
                                      ->sortByDesc('id')
                                      ->first()
            ;
        }
        $newPosts = [];
        if (!empty($featurePost)) {
            $newPosts = $tag->posts->where('status', array_search('publish', Post::STATUS))
                                   ->where('id', '!=', $featurePost->id)
                                   ->sortByDesc('id')
                                   ->take(5)
            ;
        }
        $eventPosts   = $tag->posts->where('status', array_search('publish', Post::STATUS))
                                   ->where('is_event', 1)
                                   ->sortByDesc('id')
                                   ->take(8)
        ;
        $featurePosts = $tag->posts->where('status', array_search('publish', Post::STATUS))
                                   ->where('is_featured', 1)
                                   ->take(6)
        ;
        /* Set meta */
        $metaTitle       = (!empty($tag->seo->title)) ? $tag->seo->title : $tag->title;
        $metaDescription = strip_tags((!empty($tag->seo->description)) ? $tag->seo->description : $tag->description);
        $metaImage       = (!empty($tag->seo->image)) ? $tag->seo->image : (($tag->thumbnail) ? $tag->thumbnail : asset(config('admin.og_image_url')));
        $metaKeywords    = (!empty($tag->seo->keyword)) ? $tag->seo->keyword : '';
        $canonical       = (!empty($tag->seo->canonical)) ? $tag->seo->canonical : route('fe.post.tag', [
            "id"   => $tag->id,
            'slug' => $tag->slug,
        ]);

        $robots = getMetaRobots($tag->seo, 0);
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

        $tags         = null;
        $productTypes = TextLink::byModel(PostTag::class)->byType(2)
                                ->where('model_id', $id)
                                ->orderBy('sort', 'ASC')
                                ->get()
        ;

        return view('front_end.posts.tag', compact(
            'featurePost',
            'newPosts',
            'eventPosts',
            'featurePosts',
            'tag',
            'tags',
            'productTypes'
        ));
    }

    public function getPostTag(Request $request, $id)
    {
        $posts     = PostTag::with(['posts'])
                            ->findOrFail($id)
                            ->posts()
                            ->where('status', array_search('publish', Post::STATUS))
                            ->orderBy('id', 'desc')
                            ->paginate(10)
        ;
        $totalPage = $posts->lastPage();

        return response()->json([
            'view'      => view('front_end.posts.elements.post-item', compact(
                'posts'
            ))->render(),
            'totalPage' => $totalPage,
        ]);
    }

    public function search(Request $request)
    {
        $q    = $request->get('q');
        $type = 'post';
        meta()->set('robots', 'noindex,nofollow');

        return view('front_end.searchs.index', compact('q', 'type'));
    }

    public function viewCount(Request $request){
        $post   = Post::findOrFail($request['id']);
        $viewCount = $post->view_count;

        $post->view_count = $viewCount + 1;
        $post->save();

        return response()->json(['message' => 'success'], 200);
    }
}
