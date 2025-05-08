<?php

// Trang chủ
Breadcrumbs::for('fe.home', function ($trail) {
    $trail->push('Trang chủ', route('fe.home'));
});

/** ---------- Tin tức -------------**/
// Home > Tin tức
Breadcrumbs::for('fe.post.index', function ($trail) {
    $trail->parent('fe.home');
    $trail->push('Tin tức', route('fe.post.index'));
});
// Home > Tin tức > [Category]
Breadcrumbs::for('fe.post.category', function ($trail, $category) {
    $trail->parent('fe.post.index');
    $trail->push($category->title, route('fe.post.category', ['slug'=>$category->slug,'id'=>$category->id]));
});

// Home > Tin tức > [Category] > [Post]
Breadcrumbs::for('fe.post', function ($trail, $post) {
    $trail->parent('fe.post.index');
    foreach($post->categories as $category){
        $trail->push($category->title, route('fe.post.category', ['slug'=>$category->slug,'id'=>$category->id]));
    }
    //dd($trail);
     //$trail->push($post->title, route('fe.post', ['slug'=>$post->slug,'id'=>$post->id]));
});
// Home > Tin tức > [Tag]
Breadcrumbs::for('fe.post.tag', function ($trail, $tag) {
    $trail->parent('fe.home');
    $trail->push($tag->title, route('fe.post.tag', ['slug'=>$tag->slug,'id'=>$tag->id]));
});

/** ---------- Hết tin tức -------------**/


/** ---------- Sản phẩm -------------**/

// Home > [Category]
Breadcrumbs::for('fe.product.category', function ($trail, $category) {
    $trail->parent('fe.home');
    foreach ($category->ancestors as $ancestor) {
        $trail->push($ancestor->title, route('fe.product.category', ['slug'=>$ancestor->slug,'id'=>$ancestor->id]));
    }
    $trail->push($category->title, route('fe.product.category', ['slug'=>$category->slug,'id'=>$category->id]));
});

// Home > [Tag]
Breadcrumbs::for('fe.product.tag', function ($trail, $productTag) {
    $trail->parent('fe.home');
    $trail->push($productTag->title, route('fe.product.tag', ['slug'=>$productTag->slug,'id'=>$productTag->id]));
});

// Home > [Category] > [Product]
Breadcrumbs::for('fe.product', function ($trail, $product) {
    $trail->parent('fe.product.category', $product->productCategory);
    //$trail->push($product->name, route('fe.product', ['slug'=>$product->slug,'id'=>$product->id]));
    //$trail->push('', route('fe.product', ['slug'=>$product->slug,'id'=>$product->id]));
});

/** ---------- Hết sản phẩm -------------**/

/** ---------- Tìm kiếm -------------**/
Breadcrumbs::for('fe.search', function ($trail,$p) {
    $trail->parent('fe.home');
    $trail->push($p, route('fe.search.index'));
});
/** ---------- Hết tìm kiếm -------------**/

/** ---------- Trang tĩnh -------------**/
Breadcrumbs::for('fe.page.show', function ($trail, $page) {
    $trail->parent('fe.home');
    $trail->push($page->title, route('fe.page.show', ['slug'=>$page->slug,'id'=>$page->id]));
});
/** ---------- Trang tĩnh -------------**/




