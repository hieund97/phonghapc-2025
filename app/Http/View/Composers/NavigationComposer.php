<?php

namespace App\Http\View\Composers;

use App\Models\ProductCategory;
use App\Models\Slider;
use App\Models\Attribute;
use Harimayco\Menu\Models\Menus;
use Illuminate\View\View;
use Menu;
use Cache;
use App\Models\Option;
use App\Models\Branch;
use App\Models\Navigation;
use Config;

class NavigationComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view): void
    {
        $navigation = [
            [
                'name'       => __('Dashboard'),
                'link'       => route('dashboard'),
                'icon'       => 'fa-tachometer-alt',
                'permission' => 'dashboard.index',
            ],
            [
                'name'     => __('Product Manager'),
                'link'     => '#',
                'icon'     => 'fa-tv',
                'children' => [
                    [
                        'link'       => route('product_categories.index'),
                        'name'       => __('Category Product Manager'),
                        'permission' => 'product_categories.index',
                    ],
                    [
                        'name'       => __('List Product'),
                        'link'       => route('products.index'),
                        'permission' => 'products.index',
                        'include'    => [
                            'products.show',
                            'products.edit',
                            'products.sort',
                        ],
                    ],
                    [
                        'name'       => __('Add'),
                        'link'       => route('products.create'),
                        'permission' => 'products.store',
                        'include'    => [
                            'products.attributes',
                            'products.skus',
                        ],
                    ],
                    [
                        'name'       => __('Gift'),
                        'link'       => route('gift.index'),
                        'permission' => 'product_categories.index',
                    ]

                ],
            ],
            [
                'name'       => __('Sort Product Category'),
                'link'       => route('sort.category'),
                'icon'       => 'fa-solid fa-sort',
                'permission' => 'product_categories.index',
            ],
            [
                'name'       => __('Crawl Report price'),
                'link'       => route('crawl-report.index'),
                'icon'       => 'fa fa-window-restore',
                'permission' => 'crawl_report.index',
                'children' => [
                    [
                        'name'       => __('List Crawl'),
                        'link'       => route('crawl-report.index'),
                        'permission' => 'crawl_report.index',
                    ],
                    [
                        'name'       => __('Add new crawl'),
                        'link'       => route('crawl-report.create'),
                        'permission' => 'crawl_report.store',
                    ],
                ],
            ],
            [
                'name'     => __('Posts Manager'),
                'link'     => '#',
                'icon'     => 'fa-newspaper',
                'children' => [
                    [
                        'name'       => __('List'),
                        'link'       => route('posts.index'),
                        'permission' => 'posts.index',
                        'include'    => ['posts.edit']
                    ],
                    [
                        'name'       => __('Add'),
                        'link'       => route('posts.create'),
                        'permission' => 'posts.store',
                    ],
                    [
                        'name'       => __('Category'),
                        'link'       => route('categories.index'),
                        'permission' => 'categories.index',
                    ],
                ],
            ],
            [
                'name'     => __('Ads Manager'),
                'link'     => '#',
                'icon'     => 'fa-ad',
                'name'     => __('Slider Manager'),
                'link'     => '#',
                'icon'     => 'fa-ad',
                'children' => [
                    [
                        'name'       => __('List of sliders'),
                        'link'       => route('sliders.index'),
                        'permission' => 'sliders.index',
                        'include'    => [
                            'sliders.edit',
                        ],
                    ],
                    [
                        'name'       => __('Create slider'),
                        'link'       => route('sliders.create'),
                        'permission' => 'sliders.store',
                    ]
                ],
            ],
            //[
            //    'name'     => __('Pages Manager'),
            //    'link'     => '#',
            //    'icon'     => 'fa-external-link-alt',
            //    'children' => [
            //        [
            //            'name'       => __('List of pages'),
            //            'link'       => route('pages.index'),
            //            'permission' => 'pages.index',
            //        ],
            //        [
            //            'name'       => __('Create Page'),
            //            'link'       => route('pages.create'),
            //            'permission' => 'pages.store',
            //        ],
            //    ],
            //],
            // [
            //     'name' => __('Seo Manager'),
            //     'link' => '#',
            //     'icon' => 'fa-filter',
            //     'children' => [
            //         [
            //             'name' => __('List'),
            //             'link' => route('seos.index',['model'=>'App\\Models\\Product']),
            //             'permission' => 'seos.index',
            //             'include' => ['seos.index','seos.edit'],
            //         ],
            //
            //     ],
            // ],
            [
                'name'     => __('Tags Manager'),
                'link'     => '#',
                'icon'     => 'fa-tag',
                'children' => [
                    [
                        'name'       => __('Product tag'),
                        'link'       => route('product_tags.index'),
                        'permission' => 'product_tags.index',
                    ],
                    [
                        'name'       => __('Post tag'),
                        'link'       => route('post_tags.index'),
                        'permission' => 'post_tags.index',
                    ],
                ],
            ],
            [
                'name'     => __('Attribute Manager'),
                'link'     => '#',
                'icon'     => 'fa-th',
                'children' => [
                    [
                        'name'       => __('Attribute_category'),
                        'link'       => route('attribute.index'),
                        'permission' => 'attribute.index',
                    ],
                    [
                        'name'       => __('Attribute_value'),
                        'link'       => route('attribute_value.index'),
                        'permission' => 'attribute.index',
                    ],
                ],
            ],
            [
                'name'     => __('Contact Manager'),
                'link'     => '#',
                'icon'     => 'fa-address-card',
                'children' => [
                    [
                        'name'       => __('Contact receiver'),
                        'link'       => route('contacts_receiver.index'),
                        'permission' => 'contacts_receiver.index',
                    ],
                    [
                        'name'       => __('Contact list'),
                        'link'       => route('contacts.index'),
                        'permission' => 'contacts.index',
                    ],
                ],
            ],
            //[
            //    'name' => __('Text Link Manager'),
            //    'link' => '#',
            //    'icon' => 'fa-link',
            //    'children' => [
            //        [
            //            'name' => __('List'),
            //            'link' => route('text_links.index'),
            //            'permission' => 'text_links.index',
            //        ],
            //        [
            //            'name' => __('text_links.store'),
            //            'link' => route('text_links.create'),
            //            'permission' => 'text_links.store',
            //            'include' => [
            //                'text_links.edit',
            //            ],
            //        ],
            //    ],
            //],
            // [
            //     'name' => __('Redirections Manager'),
            //     'link' => '#',
            //     'icon' => 'fa-forward',
            //     'children' => [
            //         [
            //             'name' => __('List of redirections'),
            //             'link' => route('redirections.index'),
            //             'permission' => 'redirections.index',
            //         ],
            //         [
            //             'name' => __('redirections.store'),
            //             'link' => route('redirections.create'),
            //             'permission' => 'redirections.store',
            //         ],
            //     ],
            // ],
            [
                'name'       => __('Order Manager'),
                'link'       => route('orders.index'),
                'icon'       => 'fa-shopping-cart',
                'permission' => 'orders.index',
                'include'    => [
                    'orders.create',
                    'orders.edit',
                    'orders.show',
                ],
            ],

            [
                'name'       => __('Reviews Manager'),
                'link'       => route('reviews.index'),
                'icon'       => 'fa-comments',
                'permission' => 'reviews.index',
                'include'    => [
                    'reviews.create',
                    'reviews.edit',
                ],
            ],
            [
                'name'       => __('Media'),
                'link'       => route('media.index'),
                'icon'       => 'fa-image',
                'permission' => 'media.index',
            ],

            [
                'name'     => __('System Settings'),
                'link'     => '#',
                'icon'     => 'fa-cog',
                'children' => [
                    [
                        'name'       => __('Setting'),
                        'link'       => route('settings.index'),
                        'permission' => 'settings.index',
                    ],
                    // [
                    //     'name' => __('System logs'),
                    //     'link' => route('settings.log'),
                    //     'permission' => 'settings.log',
                    // ],
                    //[
                    //    'name'       => __('Branches'),
                    //    'link'       => route('branches.index'),
                    //    'permission' => 'branches.index',
                    //    'include'    => ['branches.create']
                    //],
                ],
            ],

            [
                'name'     => __('Menu Manager'),
                'link'     => '#',
                'icon'     => 'fa-users',
                'children' => [
                    [
                        'name'       => __('List'),
                        'link'       => route('menus.index'),
                        'permission' => 'menus.index',
                    ],

                ],
            ],


            [
                'name'     => __('Footer Manager'),
                'link'     => '#',
                'icon'     => 'fa-external-link-alt',
                'children' => [
                    [
                        'name'       => __('List'),
                        'link'       => route('navigations.index'),
                        'permission' => 'navigations.index',
                        'include'    => ['navigations.edit'],
                    ],
                    [
                        'name'       => __('Add'),
                        'link'       => route('navigations.create'),
                        'permission' => 'navigations.store',
                    ],
                ],
            ],

            [
                'name'     => __('Users Manager'),
                'link'     => '#',
                'icon'     => 'fa-user',
                'children' => [
                    [
                        'name'       => __('List'),
                        'link'       => route('users.index'),
                        'permission' => 'users.index',
                    ],
                    //[
                    //    'name'       => __('Add'),
                    //    'link'       => route('users.create'),
                    //    'permission' => 'users.store',
                    //],
                ],
            ],

            [
                'name'     => __('Admin'),
                'link'     => '#',
                'icon'     => 'fa-user-lock',
                'children' => [
                    [
                        'name'       => __('List'),
                        'link'       => route('admins.index'),
                        'permission' => 'users.index',
                    ],
                    [
                        'name'       => __('Add'),
                        'link'       => route('admins.create'),
                        'permission' => 'users.store',
                    ],
                    [
                        'name'       => __('List of roles'),
                        'link'       => route('roles.index'),
                        'permission' => 'roles.index',
                    ],
                ],
            ],


        ];

        // Menu
        $mainMenus = Cache::rememberForever('main-menu', function () {
            return Menus::with('items')->get();
        });

        // Setting 
        $mainSettings = Cache::rememberForever('main-setting', function () {
            $settings = Option::get();

            $tempSettings = [];

            foreach ($settings as $setting) {
                $tempSettings[$setting->option_name] = $setting->option_value;
            }
            //Config::set('captcha.secret', $tempSettings['captcha_secret']);
            //Config::set('captcha.sitekey', $tempSettings['captcha_sitekey']);

            return $tempSettings;
        });
        // Danh sách attribute
        $mainAttribute = Cache::rememberForever('main-attribute', function () {
            return Attribute::limit(5)->get();
        });

        // Footer
        $mainFooters = Cache::rememberForever('main-footer', function () {
            return Navigation::where('display_in', 'footer')
                             ->orderByDesc('order')
                             ->get([
                                 'id',
                                 'name',
                                 'icon',
                                 'link',
                                 'group',
                                 'display_in',
                                 'order',
                             ])
                             ->groupBy('group')
            ;
        });

        //Header
        $mainHeaders = Cache::rememberForever('main-header', function () {
            return ProductCategory::with('childrenEnable')->where('status', 1)->where('is_feature', 1)->orderBy('ordering_menu_top')->get()->take(13);
        });

        $view->with(compact('navigation', 'mainMenus', 'mainSettings', 'mainAttribute', 'mainFooters', 'mainHeaders'));
    }
}
