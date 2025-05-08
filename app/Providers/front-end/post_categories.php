<?php

use App\Models\Category;
use Illuminate\Support\Facades\View;


View::composer('front_end.partials.post_categories', function ($view) {
    $postCategories = Category::get(['id','title','slug'])->take(12);
    $view->with(compact('postCategories'));
});
