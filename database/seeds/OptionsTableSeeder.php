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
        $options = [
            //Tab Info
            'info_site_name'          => ['value' => 'Phong Hà Computer', 'type' => '', 'tab' => 'info'],
            'info_company'            => ['value' => 'CÔNG TY CP CÔNG NGHỆ PHONG HÀ', 'type' => '', 'tab' => 'info'],
            'info_site_description'   => ['value' => '', 'type' => '', 'tab' => 'info'],
            'info_header'             => ['value' => asset('images/header.png'), 'type' => 'upload', 'tab' => 'info'],
            'info_slogan'             => ['value' => '', 'type' => '', 'tab' => 'info'],
            'info_logo'               => ['value' => asset('images/logo.png'), 'type' => 'upload', 'tab' => 'info'],
            'info_logo_mobile'        => ['value' => asset('images/logo_mobile.png'), 'type' => 'upload', 'tab' => 'info'],
            'info_logo_footer'        => ['value' => asset('images/logo.png'), 'type' => 'upload', 'tab' => 'info'],
            'info_cover_image'        => ['value' => '', 'type' => 'upload', 'tab' => 'info'],
            'info_sale_prod_url'      => ['value' => '', 'type' => '', 'tab' => 'info'],
            'info_installment'        => ['value' => '', 'type' => '', 'tab' => 'info'],
            'info_youtube_url'        => ['value' => '', 'type' => '', 'tab' => 'info'],
            'robots'                  => ['value' => 'noindex, nofollow', 'type' => '', 'tab' => 'seo'],
            'info_hotline_footer_1'   => [
                'value' => '<p><strong><span style="font-size:16px;">Tổng Đài Hỗ Trợ</span></strong></p>

                            <p><a href="http://tel:02473063686"><span style="color:#ffffff;">024.730.63686</span></a>&nbsp;&nbsp;(8h00- 18h30)</p>
                            
                            <p>- Nhánh 1 Phòng KD&nbsp;bán lẻ.</p>
                            
                            <p>- Nhánh 2 phòng KD dự án.</p>
                            
                            <p>- Nhánh 3&nbsp;phòng kỹ thuật dịch vụ - bảo hành.</p>
                            
                            <p>- Nhánh 4 hỗ trợ camera giám sát.</p>
                            ',
                'type'  => 'textarea',
                'tab'   => 'info'
            ],
            'info_hotline_footer_2'   => [
                'value' => '<p style="text-align:start; margin-bottom:10px"><span style="font-size:14px"><span style="box-sizing:border-box"><span style="color:#ffffff"><span style="font-family:Play, sans-serif"><span style="font-style:normal"><span style="font-variant-ligatures:normal"><span style="font-weight:400"><span style="white-space:normal"><span style="background-color:#555555"><span style="text-decoration-thickness:initial"><span style="text-decoration-style:initial"><span style="text-decoration-color:initial">Mr.Khải:&nbsp;<span style="box-sizing:border-box"><span style="color:#3498db"><u style="box-sizing:border-box; color:#ffffff">KD Laptop</u></span></span></span></span></span></span></span></span></span></span></span></span></span></span></p>
                            
                            <p style="text-align:start; margin-bottom:10px"><span style="font-size:14px"><span style="box-sizing:border-box"><span style="color:#ffffff"><span style="font-family:Play, sans-serif"><span style="font-style:normal"><span style="font-variant-ligatures:normal"><span style="font-weight:400"><span style="white-space:normal"><span style="background-color:#555555"><span style="text-decoration-thickness:initial"><span style="text-decoration-style:initial"><span style="text-decoration-color:initial"><img alt="zalo" data-src="/template/oct2020/images/zalo-icon-2020.png" data-was-processed="true" src="'.$iconZalo.'" style="box-sizing:border-box; border:0px; vertical-align:middle; max-width:100%; transition:all 0.7s ease 0s; color:#ffffff; width:21px; height:20px" />&nbsp;<a href="tel:0984.284.101" style="box-sizing:border-box; background:0px 0px; color:#ffffff; text-decoration:none"><span style="box-sizing:border-box"><span style="color:#ffffff">0984.284.101</span></span></a>&nbsp;</span></span></span></span></span></span></span></span></span></span></span></span></p>
                            
                            <p style="text-align:start; margin-bottom:10px"><span style="font-size:14px"><span style="box-sizing:border-box"><span style="color:#ffffff"><span style="font-family:Play, sans-serif"><span style="font-style:normal"><span style="font-variant-ligatures:normal"><span style="font-weight:400"><span style="white-space:normal"><span style="background-color:#555555"><span style="text-decoration-thickness:initial"><span style="text-decoration-style:initial"><span style="text-decoration-color:initial">Mr.Tuấn KD&nbsp;<span style="box-sizing:border-box"><span style="color:#3498db"><u style="box-sizing:border-box; color:#ffffff">PC - M&aacute;y T&iacute;nh Để B&agrave;n</u></span></span></span></span></span></span></span></span></span></span></span></span></span></span></p>
                            
                            <p style="text-align:start; margin-bottom:10px"><span style="font-size:14px"><span style="box-sizing:border-box"><span style="color:#ffffff"><span style="font-family:Play, sans-serif"><span style="font-style:normal"><span style="font-variant-ligatures:normal"><span style="font-weight:400"><span style="white-space:normal"><span style="background-color:#555555"><span style="text-decoration-thickness:initial"><span style="text-decoration-style:initial"><span style="text-decoration-color:initial"><img alt="zalo" data-src="/template/oct2020/images/zalo-icon-2020.png" data-was-processed="true" src="'.$iconZalo.'" style="box-sizing:border-box; border:0px; vertical-align:middle; max-width:100%; transition:all 0.7s ease 0s; color:#ffffff; width:21px; height:20px" />&nbsp;<a href="tel:0987.197.719" style="box-sizing:border-box; background:0px 0px; color:#ffffff; text-decoration:none"><span style="box-sizing:border-box"><span style="color:#ffffff">0987.197.719</span></span></a>&nbsp;</span></span></span></span></span></span></span></span></span></span></span></span></p>
                            
                            <p style="text-align:start; margin-bottom:10px"><span style="font-size:14px"><span style="box-sizing:border-box"><span style="color:#ffffff"><span style="font-family:Play, sans-serif"><span style="font-style:normal"><span style="font-variant-ligatures:normal"><span style="font-weight:400"><span style="white-space:normal"><span style="background-color:#555555"><span style="text-decoration-thickness:initial"><span style="text-decoration-style:initial"><span style="text-decoration-color:initial">Mr.Bắc KD&nbsp;<a href="https://maytinhnamha.vn/camera-giam-sat.html" style="box-sizing:border-box; background:0px 0px; color:#ffffff; text-decoration:none"><font color="#3498db"><font style="box-sizing:border-box; color:#ffffff"><u style="box-sizing:border-box; color:#ffffff">Camera Gi&aacute;m s&aacute;t</u></font></font></a></span></span></span></span></span></span></span></span></span></span></span></span></p>
                            
                            <p style="text-align:start; margin-bottom:10px"><span style="font-size:14px"><span style="box-sizing:border-box"><span style="color:#ffffff"><span style="font-family:Play, sans-serif"><span style="font-style:normal"><span style="font-variant-ligatures:normal"><span style="font-weight:400"><span style="white-space:normal"><span style="background-color:#555555"><span style="text-decoration-thickness:initial"><span style="text-decoration-style:initial"><span style="text-decoration-color:initial"><img alt="zalo" data-src="/template/oct2020/images/zalo-icon-2020.png" data-was-processed="true" src="'.$iconZalo.'" style="box-sizing:border-box; border:0px; vertical-align:middle; max-width:100%; transition:all 0.7s ease 0s; color:#ffffff; width:21px; height:20px" />&nbsp;<a href="tel:0966.844.886" style="box-sizing:border-box; background:0px 0px; color:#ffffff; text-decoration:none">0966.844.886</a>&nbsp;</span></span></span></span></span></span></span></span></span></span></span></span></p>
                            
                            <p style="text-align:start; margin-bottom:10px"><span style="font-size:14px"><span style="box-sizing:border-box"><span style="color:#ffffff"><span style="font-family:Play, sans-serif"><span style="font-style:normal"><span style="font-variant-ligatures:normal"><span style="font-weight:400"><span style="white-space:normal"><span style="background-color:#555555"><span style="text-decoration-thickness:initial"><span style="text-decoration-style:initial"><span style="text-decoration-color:initial">Mr Vương&nbsp;<span style="box-sizing:border-box"><span style="color:#3498db"><u style="box-sizing:border-box; color:#ffffff">KD Dự &Aacute;n - Doanh Nghiệp</u></span></span></span></span></span></span></span></span></span></span></span></span></span></span></p>
                            
                            <p><img alt="zalo" data-src="/template/oct2020/images/zalo-icon-2020.png" data-was-processed="true" height="20" src="'.$iconZalo.'" width="21" />&nbsp;<a href="tel:0336.555.966">0336.555.966</a>&nbsp;</p>
                           ',
                'type'  => 'textarea',
                'tab'   => 'info'
            ],
            'info_copyright'          => [
                'value' => 'Mã số thuế: 0109810789 - Do sở kế hoạch và đầu tư thành phố Hà Nội Cấp ngày 10/11/2021',
                'type'  => '',
                'tab'   => 'info'
            ],
            'info_status'             => ['value' => 'open', 'type' => 'dropdown', 'tab' => 'info'],

            //Tab Contact
            'contact_address_company' => [
                'value' => 'Showroom số 68 Trần phú - Thường tín- Hà nội',
                'type'  => '',
                'tab'   => 'contact',
            ],
            'contact_work_time'       => ['value' => '8:00 - 18:00', 'type' => '', 'tab' => 'contact'],
            'contact_phone_company'   => ['value' => '02473063686', 'type' => '', 'tab' => 'contact'],
            'contact_hotline'         => ['value' => '02473063686', 'type' => '', 'tab' => 'contact'],
            'contact_zalo'            => ['value' => '0987197719', 'type' => '', 'tab' => 'contact'],
            'contact_email'           => ['value' => 'maytinhnamha.vn@gmail.com', 'type' => '', 'tab' => 'contact'],
            'contact_website'         => ['value' => 'maytinhnamha.vn', 'type' => '', 'tab' => 'contact'],
            'contact_link_map'        => [
                'value' => '',
                'type'  => '',
                'tab'   => 'contact'
            ],

            //Tab Common
            'common_banner_1'         => ['value' => '', 'type' => 'upload', 'tab' => 'common'],
            'common_banner_2'         => ['value' => '', 'type' => '', 'tab' => 'common'],
            'common_banner_3'         => ['value' => '', 'type' => 'upload', 'tab' => 'common'],
            'common_banner_4'         => ['value' => '', 'type' => '', 'tab' => 'common'],
            'common_banner_5'         => ['value' => '', 'type' => 'upload', 'tab' => 'common'],
            'common_banner_6'         => ['value' => '', 'type' => '', 'tab' => 'common'],

            //Tab Title
            'title_1'                 => ['value' => 'Yên Tâm Mua Sắm Tại NAMHAPC', 'type' => '', 'tab' => 'title'],
            'title_2'                 => ['value' => '', 'type' => 'textarea', 'tab' => 'title'],
            'title_3'                 => ['value' => '', 'type' => '', 'tab' => 'title'],
            'title_4'                 => [
                'value' => 'Liên Hệ Với Kinh Doanh Online',
                'type'  => 'textarea',
                'tab'   => 'title'
            ],
            'title_qr'                => ['value' => '', 'type' => '', 'tab' => 'title'],

            //Tab SEO
            'seo_meta_title'          => [
                'value' => 'NAM HÀ COMPUTER | Đại lý máy tính đồ họa, PC đồ họa,	Máy tính Xách tay- Laptop , Máy tính chơi games- Gaming',
                'type'  => '',
                'tab'   => 'seo'
            ],
            'seo_meta_keyword'        => [
                'value' => 'Máy tính đồ họa, PC đồ họa,	Máy tính Xách tay- Laptop , Máy tính chơi games- Gaming,  ',
                'type'  => '',
                'tab'   => 'seo'
            ],
            'seo_meta_description'    => [
                'value' => 'NAM HÀ COMPUTER LÀ THƯƠNG HIỆU HÀNG ĐẦU VỀ LAPTOP ,MÁY TÍNH GAMING, MÁY TÍNH VĂN PHÒNG, VỚI ĐỘI NGŨ KỸ THUẬT CHUYÊN NGHIỆP NHIỆT TÌNH. UY TÍN - CHẤT LƯỢNG - CAO CẤP 02473063686',
                'type'  => '',
                'tab'   => 'seo'
            ],
            'seo_meta_image'          => ['value' => '', 'type' => 'upload', 'tab' => 'seo'],

            //Tab Social
            'social_facebook_url'     => [
                'value' => 'https://www.facebook.com/phonghacomputer68',
                'type'  => '',
                'tab'   => 'social'
            ],
            'social_youtube_url'      => [
                'value' => 'https://www.youtube.com/@phonghacomputer',
                'type'  => '',
                'tab'   => 'social'
            ],
            'social_zalo'             => ['value' => '0987197719', 'type' => '', 'tab' => 'social'],

            //Tab Script
            'script_header'           => ['value' => '', 'type' => 'textarea', 'tab' => 'script'],
            'script_body'             => ['value' => '', 'type' => 'textarea', 'tab' => 'script'],

            //Tab Popup
            'popup_image'             => ['value' => '', 'type' => 'upload', 'tab' => 'popup'],
            'popup_links'             => ['value' => '', 'type' => '', 'tab' => 'popup'],
            'popup_status'            => ['value' => 'off', 'type' => 'dropdown', 'tab' => 'popup'],

            //'shop_list_url' => ['value' => '', 'type' => ''],
            //'facebook_url'  => ['value' => 'https://www.facebook.com/phonghacomputer68', 'type' => '', 'tab' => ],
            //'twitter_url'   => ['value' => 'https://twitter.com/home', 'type' => ''],
            //'instagram_url' => ['value' => 'https://www.instagram.com//', 'type' => ''],
            //'phone_company' => ['value' => '0359.71.74.68', 'type' => ''],
            //
            //'robots'              => ['value' => 'noindex, nofollow', 'type' => ''],
            //'footer'              => ['value' => '', 'type' => 'textarea'],
            //'header'              => ['value' => '', 'type' => 'textarea'],
            //'messenger'           => ['value' => 'https://www.messenger.com/', 'type' => ''],
            //'zalo'                => ['value' => '0925588666', 'type' => ''],
            //'seo_schema'          => ['value' => '', 'type' => 'textarea'],
            //'cart_successfull'    => ['value' => '', 'type' => 'textarea'],
            //'is_popup'            => ['value' => '', 'type' => 'checkbox'],
            //'popup'               => ['value' => '', 'type' => 'textarea'],
            //'popup_start'         => ['value' => '', 'type' => ''],
            //'popup_time'          => ['value' => '', 'type' => ''],
            //'buy_contact'         => ['value' => '', 'type' => ''],
            //'post_description'    => ['value' => '', 'type' => 'textarea'],
            //'post_banner'         => ['value' => '', 'type' => 'upload'],
            //'post_banner_url'     => ['value' => '', 'type' => ''],
            //'captcha_secret'      => ['value' => '', 'type' => ''],
            //'captcha_sitekey'     => ['value' => '', 'type' => ''],
            //'policy_sell_product' => ['value' => '', 'type' => 'textarea'],
            //'policy_exchange'     => ['value' => '', 'type' => 'textarea'],
            //'dmca'                => ['value' => '', 'type' => 'textarea'],
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
