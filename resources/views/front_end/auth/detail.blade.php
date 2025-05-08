@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif
@section('page-title', 'Profile')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
    @if( $errors->default->first() != '' )
        <div class="callout callout-danger uk-margin-bottom"
             style="background:#AB5858;padding:8px;color:#fff;margin-bottom:10px">{{ $errors->default->first() }}</div>
    @endif
    @if( session()->has('profile_updated') )
        <div class="callout callout-success uk-margin-bottom"
             style="background:#53A653;padding:8px;color:#fff;margin-bottom:10px">Cập nhật thành công
        </div>
    @endif
    @if( session()->has('password_updated') )
        <div class="callout callout-success uk-margin-bottom"
             style="background:#53A653;padding:8px;color:#fff;margin-bottom:10px">Cập nhật mật khẩu thành công
        </div>
    @endif
    @php
        $listOrder = [];
        if (auth()->check()) {
            $listOrder = auth()->user()->orders;
        }
    @endphp
    <div class="body-container" id="body">
        <div class="bres">
            <div class="container pd-10">
                <ul>
                    <li>
                        <a href="{{ route('fe.home') }}">{{ __('Home')  }}</a>/
                    </li>
                    <li>
                        {{ __('Đăng ký')  }}
                    </li>
                </ul>
            </div>
        </div>
        <div class="top_barr customers-tabs_">
            <div class="container">
                <div class="relative">
                    <ul class="nav nav-tabs" role="tablist" id="profile-tabs">
                        <li class="nav-item {{ session()->get('tab') == 'profile_update' || !session()->has('tab') ? 'active' : '' }}">
                            <a class="nav-link" id="tabs-detail-tab" data-toggle="pill"
                               href="#tabs-detail" role="tab" aria-controls="tabs-detail"
                               aria-selected="true">Hồ sơ cá nhân</a>
                        </li>
                        <li class="nav-item {{ session()->get('tab') == 'change_password' ? 'active' : '' }}">
                            <a class="nav-link" id="tabs-password-tab" data-toggle="pill"
                               href="#tabs-password" role="tab" aria-controls="tabs-password"
                               aria-selected="false">Đổi mật khẩu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tabs-order-tab" data-toggle="pill"
                               href="#tabs-order" role="tab" aria-controls="tabs-order"
                               aria-selected="false">Đơn hàng</a>
                        </li>
                    </ul>
                </div>
                <div class="pd-10">
                    <div class="tab-content detail-tab">
                        <div class="tab-pane fade {{ session()->get('tab') == 'profile_update' || !session()->has('tab') ? 'active in' : '' }}"
                             id="tabs-detail" role="tabpanel"
                             aria-labelledby="tabs-detail-tab">
                            <section class="profile_box">
                                <header class="panel-head">
                                    <div class="heading-2 heading-detail-user">
                                        <span>Thông tin thành viên</span>
                                    </div>
                                </header>
                                <section class="panel-body pd-1-r-0">
                                    <div class="profile project-create uk-panel-body">
                                        <form method="post" action="{{ route('fe.profile.update') }}">
                                            @csrf
                                            <div class="content_content content-form-user row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="label-left bg_bg">
                                                            <label class="label-label">Email</label>
                                                        </div>
                                                        <label class="label-label">
                                                            <input type="text" readonly class="form-control"
                                                                   value="{{ auth()->user()->email }}">
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="label-left bg_bg">
                                                            <label class="label-label">Họ và tên</label>
                                                        </div>
                                                        <label class="label-label">
                                                            <input type="text" name="name" class="form-control"
                                                                   value="{{ auth()->user()->name }}">
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="label-left bg_bg">
                                                            <label class="label-label">Số điện thoại</label>
                                                        </div>
                                                        <label class="label-label">
                                                            <input type="text" name="mobile" class="form-control"
                                                                   value="{{ auth()->user()->mobile }}">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="label-left bg_bg">
                                                            <label class="label-label">Giới tính</label>
                                                        </div>
                                                        <label class="label-label">
                                                            <select class="form-control" name="sex">
                                                                <option value="0" {{ auth()->user()->sex == 0 ? 'selected' : '' }}>
                                                                    Chọn giới tính
                                                                </option>
                                                                <option value="1" {{ auth()->user()->sex == 1 ? 'selected' : '' }}>
                                                                    Nam
                                                                </option>
                                                                <option value="2" {{ auth()->user()->sex == 2 ? 'selected' : '' }}>
                                                                    Nữ
                                                                </option>
                                                            </select>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="label-left bg_bg">
                                                            <label class="label-label">Tỉnh thành</label>
                                                        </div>
                                                        <label class="label-label">
                                                            <select class="form-control" name="province">
                                                                <option value="0" {{ auth()->user()->province == 0 ? 'selected' : '' }}>
                                                                    Chọn tỉnh thành
                                                                </option>
                                                                @foreach($aryProvince as $province)
                                                                    <option value="{{ $province->id }}" {{ auth()->user()->province == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="label-left bg_bg">
                                                            <label class="label-label">Địa chỉ</label>
                                                        </div>
                                                        <label class="label-label">
                                                            <input type="text" name="address" class="form-control"
                                                                   value="{{ auth()->user() ? auth()->user()->address : '' }}">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <div class="label-left bg_bg">
                                                        <label class="label-label">Mô tả bản thân</label>
                                                    </div>
                                                    <label class="label-label" style="line-height:0">
                                            <textarea name="description" cols="40" rows="10" class="form-control"
                                                      placeholder="Giới thiệu bản thân"
                                                      style="padding:5px">{{ auth()->user() ? auth()->user()->description : '' }}</textarea>
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="login_button" type="submit"
                                                >Lưu thông tin
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </section>
                            </section>
                        </div>
                        <div class="tab-pane fade {{ session()->get('tab') == 'change_password' ? 'active in' : '' }}"
                             id="tabs-password" role="tabpanel"
                             aria-labelledby="tabs-password-tab">
                            <div class="page-change-password row mb20">
                                <div class="col-lg-4 col-lg-push-4 pd-mb-0">
                                    <section class="profile_box">
                                        <form method="post" action="{{ route('fe.profile.update.password') }}">
                                            @csrf
                                            <div class="line-form bor_bor">
                                                <div class="box_title_2">
                                                    <span>Đổi mật khẩu</span>
                                                </div>
                                            </div>
                                            <div class="content_content">
                                                <div class="item-form">
                                                    <div class="label-left bg_bg">
                                                        <label class="label-label">Mật khẩu mới</label>
                                                    </div>
                                                    <div class="label-right">
                                                        <label class="label-label">
                                                            <input type="password" name="new_password">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="item-form">
                                                    <div class="label-left bg_bg">
                                                        <label class="label-label">Nhập lại</label>
                                                    </div>
                                                    <div class="label-right">
                                                        <label class="label-label">
                                                            <input type="password" name="re_new_password">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <input class="login_button" name="update" type="submit"
                                                       value="Cập nhật">
                                            </div>
                                        </form>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-order" role="tabpanel" aria-labelledby="tabs-order-tab">
                            <div class="main-inner">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span style="font-weight:bold">
                                            <i class="fas fa-history" aria-hidden="true"></i>
                                            Lịch sử mua hàng
                                        </span>
                                    </div>
                                    @forelse($listOrder as $order)
                                        <div class="cart-items-group">
                                            @foreach($order->orderProducts as $item)
                                                <div class="item js-item-row" data-variant_id="0" data-item_id="2903"
                                                     data-item_type="product">
                                                    <div class="item-left">
                                                        <span class="item-img">
                                                            <img src="{{ (!empty($item->product->feature_img)) ? get_image_url($item->product->feature_img, 'default'):asset(config('admin.image_not_found')) }}"
                                                                 alt="{{ $item->product->name }}">
                                                        </span>

                                                        <div class="item-text">
                                                            <a href="{{ route("fe.product",["slug"=> $item->product->slug]) }}"
                                                               class="item-name">{{ $item->product->name }}</a>
                                                            <p class="item-status">
                                                            <span style="color: #0DB866;">
                                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                                Còn hàng
                                                            </span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="item-right">
                                                        <div class="item-price-holder">
                                                            <p class="total-item-price">
                                                                <span class="js-total-item-price total-item-{{ $item->id }}">
                                                                     {{ $item->amount }} x @money($item->price)
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @empty
                                        <div class="panel-body">
                                            <div class="empty">
                                                Bạn chưa có đơn hàng nào
                                            </div>
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    @if(!empty($mainSettings['is_popup']) && $mainSettings['is_popup']==1 && !empty($mainSettings['popup']))
        <!-- Modal -->
        <div class="modal fade" id="notifyModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="notifyModalCenterTitle"
             aria-hidden="true" data-time="2">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! $mainSettings['popup'] !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    @endif
@endpush