<?php


use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->delete();
        $iconZalo = asset('images/icons8-zalo-48.png');
        $options  = [
            //Tab Info
            'info_site_name'          => ['value' => 'Phong Hà Computer', 'type' => '', 'tab' => 'info'],
            'info_company'            => ['value' => '', 'type' => '', 'tab' => 'info'],
            'info_site_description'   => ['value' => '', 'type' => '', 'tab' => 'info'],
            'info_slogan'             => ['value' => '', 'type' => '', 'tab' => 'info'],
            'info_logo'               => ['value' => asset('images/logo.png'), 'type' => 'upload', 'tab' => 'info'],
            'info_logo_mobile'        => [
                'value' => asset('images/logo-mobile.png'),
                'type'  => 'upload',
                'tab'   => 'info'
            ],
            'info_logo_footer'        => [
                'value' => asset('images/logo-black.png'),
                'type'  => 'upload',
                'tab'   => 'info'
            ],
            'info_sale_prod_url'      => ['value' => '', 'type' => '', 'tab' => 'info'],

            'info_installment'        => ['value' => '', 'type' => '', 'tab' => 'info'],
            'info_youtube_url'        => ['value' => '', 'type' => '', 'tab' => 'info'],
            'robots'                  => ['value' => 'index, follow', 'type' => '', 'tab' => 'seo'],
            'info_status'             => ['value' => 'open', 'type' => 'dropdown', 'tab' => 'info'],

            //Tab Contact
            'contact_address_company' => [
                'value' => '',
                'type'  => '',
                'tab'   => 'contact',
            ],
            'contact_work_time'       => ['value' => '', 'type' => '', 'tab' => 'contact'],
            //'contact_phone_company'   => ['value' => '', 'type' => '', 'tab' => 'contact'],
            'contact_hotline'         => ['value' => '', 'type' => '', 'tab' => 'contact'],
            'contact_zalo'            => ['value' => '', 'type' => '', 'tab' => 'contact'],
            'contact_email'           => ['value' => '', 'type' => '', 'tab' => 'contact'],
            'contact_website'         => ['value' => '', 'type' => '', 'tab' => 'contact'],
            'contact_link_map'        => [
                'value' => '',
                'type'  => '',
                'tab'   => 'contact'
            ],
            'contact_bank'            => ['value' => '', 'type' => '', 'tab' => 'contact'],
            'contact_bank_number'     => ['value' => '', 'type' => '', 'tab' => 'contact'],
            'contact_bank_owner'      => ['value' => '', 'type' => '', 'tab' => 'contact'],

            //Tab Common
            'info_header'             => [
                'value' => 'https://placehold.co/1422x56',
                'type'  => 'upload',
                'tab'   => 'common'
            ],
            'info_header_url'         => ['value' => '', 'type' => '', 'tab' => 'common'],
            'info_header_status'      => ['value' => 'off', 'type' => 'dropdown', 'tab' => 'common'],
            'banner_hompage'          => [
                'value' => 'https://placehold.co/1650x100',
                'type'  => 'upload',
                'tab'   => 'common'
            ],
            'banner_hompage_url'      => ['value' => '', 'type' => '', 'tab' => 'common'],
            'banner_hompage_status'   => ['value' => 'off', 'type' => 'dropdown', 'tab' => 'common'],
            'common_banner_1'         => ['value' => '', 'type' => 'upload', 'tab' => 'common'],
            'common_banner_2'         => ['value' => '', 'type' => '', 'tab' => 'common'],
            'common_banner_3'         => [
                'value' => 'https://placehold.co/130x400',
                'type'  => 'upload',
                'tab'   => 'common'
            ],
            'common_banner_4'         => ['value' => '', 'type' => '', 'tab' => 'common'],
            'common_banner_4_status'  => ['value' => 'off', 'type' => 'dropdown', 'tab' => 'common'],
            'common_banner_5'         => [
                'value' => 'https://placehold.co/130x400',
                'type'  => 'upload',
                'tab'   => 'common'
            ],
            'common_banner_6'         => ['value' => '', 'type' => '', 'tab' => 'common'],
            'common_banner_6_status'  => ['value' => 'off', 'type' => 'dropdown', 'tab' => 'common'],

            'banner_build_PC'          => [
                'value' => 'https://placehold.co/1650x100',
                'type'  => 'upload',
                'tab'   => 'common'
            ],
            'banner_build_pc_status'   => ['value' => 'off', 'type' => 'dropdown', 'tab' => 'common'],

            //Tab SEO
            'seo_meta_title'          => [
                'value' => 'Phong hà computer',
                'type'  => '',
                'tab'   => 'seo'
            ],
            'seo_meta_keyword'        => [
                'value' => 'Phong hà computer',
                'type'  => '',
                'tab'   => 'seo'
            ],
            'seo_meta_description'    => [
                'value' => 'Phong hà computer',
                'type'  => '',
                'tab'   => 'seo'
            ],
            'seo_meta_image'          => ['value' => '', 'type' => 'upload', 'tab' => 'seo'],

            //Tab Social
            'social_facebook_url'     => [
                'value' => '',
                'type'  => '',
                'tab'   => 'social'
            ],
            'social_youtube_url'      => [
                'value' => '',
                'type'  => '',
                'tab'   => 'social'
            ],
            'social_zalo'             => ['value' => '', 'type' => '', 'tab' => 'social'],

            //Tab Script
            'script_header'           => ['value' => '', 'type' => 'textarea', 'tab' => 'script'],
            'script_body'             => ['value' => '', 'type' => 'textarea', 'tab' => 'script'],

            //Tab Popup
            'popup_image'             => ['value' => '', 'type' => 'upload', 'tab' => 'popup'],
            'popup_links'             => ['value' => '', 'type' => '', 'tab' => 'popup'],
            'popup_status'            => ['value' => 'off', 'type' => 'dropdown', 'tab' => 'popup'],
        ];

        foreach ($options as $name => $row) {
            if (!Option::where('option_name', '=', $name)->exists()) {
                Option::create([
                    'option_name'  => $name,
                    'option_value' => $row["value"],
                    'option_type'  => $row["type"],
                    'option_tab'   => $row["tab"],
                ]);
            }
        }
    }
}
