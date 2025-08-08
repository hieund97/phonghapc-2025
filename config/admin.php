<?php

return [
    /*
     |--------------------------------------------------------------------------
     | User operation log setting
     |--------------------------------------------------------------------------
     |
     | By setting this option to open or close operation log in laravel-admin.
     |
     */
    'operation_log'          => [

        'enable'          => true,

        /*
           * Only logging allowed methods in the list
           */
        'allowed_methods' => ['POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],

        /*
           * Routes that will not log to database.
           *
           * All method to path like: admin/auth/logs
           * or specific method to path like: get:admin/auth/logs.
           */
        'except'          => [
            'admin/settings*',
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Indicates whether to check route permission.
     |--------------------------------------------------------------------------
     */
    'check_route_permission' => true,

    /*
     |--------------------------------------------------------------------------
     | Indicates whether to check menu roles.
     |--------------------------------------------------------------------------
     */
    'check_menu_roles'       => true,

    /*
     |--------------------------------------------------------------------------
     | Define copy right for dev.
     |--------------------------------------------------------------------------
     */
    'copy_right'             => ['url' => 'https://phonghacomputer.vn', 'name' => 'phonghacomputer.vn'],


    /*
     |--------------------------------------------------------------------------
     | Format Date
     |--------------------------------------------------------------------------
     */

    'format_date'      => 'd/m/Y',
    'format_date_time' => 'd/m/Y H:i:s',


    /**
     * Define Editor
     */
    'editor'           => 1,

    'og_image_url'    => env('OG_IMAGE_URL', 'theme/front_end/images/logo_main.png'),
    'image_not_found' => env('IMAGE_NOT_FOUND', 'preview-icon-345x345.png'),

    /**
     * Nếu true thì chạy pjax
     */
    'pjax_show'       => env('PJAX_SHOW', false),

    'product_status' => [
        2 => 'pending',
        3 => 'new',
        4 => 'publish',
        5 => 'out_of_stock',
        6 => 'coming_soon',
    ],

    'attribute_status' => [
        1 => 'publish',
        2 => 'pending',
        3 => 'draft',
    ],

    'product_sale' => [
        0 => 'All',
        1 => 'No',
        2 => 'Yes',
    ],

    'payment_method' => [
        'cod'          => 'Thanh toán tiền mặt khi nhận hàng(COD)',
        'tai_cua_hang' => 'Thanh toán tại cửa hàng',
        'chuyen_khoan' => 'Chuyển khoản ngân hàng',
        'tra_gop'      => 'Trả góp',
    ],

    'navigations_group' => [
        'Thông tin chung'   => 'THÔNG TIN CHUNG',
        'Chính sách chung'  => 'CHÍNH SÁCH CHUNG',
        'Hỗ trợ khách hàng' => 'HỖ TRỢ KHÁCH HÀNG'
    ],

    'navigation_display' => [
        'footer' => 'Footer',
    ],


    'product_price_filter' => [
        'duoi-2-trieu'  => 'Dưới 2 triệu',
        'tu-2-4-trieu'  => 'Từ 2 - 4 triệu',
        'tu-4-7-trieu'  => 'Từ 4 - 7 triệu',
        'tu-7-15-trieu' => 'Từ 7 - 15 triệu',
        'tren-15-trieu' => 'Trên 15 triệu',
    ],

    'product_sort_type' => [
        'default',
        'price_asc',
        'price_desc',
        'latest',
    ],

    'tag_type' => [
        'product',
        'post',
    ],

    'textlink_type' => [
        1 => 'Thương hiệu',
        2 => 'Loại sản phẩm',
    ],

    'seo_model' => [
        'App\\Models\\ProductCategory',
        'App\\Models\\Product',
        'App\\Models\\Category',
        'App\\Models\\Post',
        'App\\Models\\Page',
    ],

    'target' => [
        '_blank',
        '_self',
        '_parent',
        '_top',
        'framename',
    ],

    'robots_meta' => [
        'index'        => 'Index',
        'follow'       => 'Follow',
        'noindex'      => 'No Index',
        'nofollow'     => 'No Follow',
        'noimageindex' => 'No Image Index',
        'noarchive'    => 'No Archive',
        'nosnippet'    => 'No Snippet',
    ],

    'default_status' => [
        0 => 'off',
        1 => 'on',
    ],

    'type_sort_build_pc' => [
        'newest'          => 1,
        'just_price_desc' => 2,
        'just_price_asc'  => 3,
        'viewed'          => 4,
        'top_rated'       => 5,
        'name'            => 6,

    ],
];
