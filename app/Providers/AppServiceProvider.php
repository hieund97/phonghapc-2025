<?php

namespace App\Providers;

use Arr;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Request;
use Schema;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(TelescopeServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Paginator::useBootstrap();

        Blade::directive('money', function ($amount) {

           $price ="
           <?php
            if($amount==0){
                echo 'Liên hệ';
            }else { 
             echo number_format($amount,0,',','.').'₫'; 
            }
           ?>
           ";
            return $price;
        });

        $this->app->resolving(LengthAwarePaginator::class, function ($paginator) {
            return $paginator->appends(Arr::except(Request::all(), $paginator->getPageName()));
        });
    }
}
