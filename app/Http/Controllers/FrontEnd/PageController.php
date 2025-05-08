<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show($slug, $id)
    {
        $page = Page::where('id', $id)->firstOrFail()->append('content');

        /* Set meta */
        $metaTitle       = (!empty($page->seo->title)) ? $page->seo->title : $page->title;
        $metaDescription = strip_tags((!empty($page->seo->description)) ? $page->seo->description : $page->title);
        $metaImage       = (!empty($page->seo->image)) ? $page->seo->image : asset(config('admin.og_image_url'));
        $metaKeywords    = (!empty($page->seo->keyword)) ? $page->seo->keyword : '';
        $canonical       = (!empty($page->seo->canonical)) ? $page->seo->canonical : route('fe.page.show', [
            "id"   => $page->id,
            'slug' => $page->slug,
        ]);
        $robots          = getMetaRobots($page->seo, 0);
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

        return view('front_end.pages.show', compact('page'));
    }
}
