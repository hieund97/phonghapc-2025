@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif

@section('content')
    <div id="body" class="body-container">
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
        <br>
        <div class="container pd-10">
            <div class="row mb20">
                @if( $errors->default->first() != '' )
                    <div class="callout callout-danger uk-margin-bottom"
                         style="background:#AB5858;padding:8px;color:#fff;margin-bottom:10px">{{ $errors->default->first() }}</div>
                @endif
                @if( session()->has('login_failed') )
                    <div class="callout callout-success uk-margin-bottom"
                         style="background:#AB5858;padding:8px;color:#fff;margin-bottom:10px">Đăng nhập thất bại
                    </div>
                @endif
                @if( session()->has('register_successful') )
                    <div class="callout callout-success uk-margin-bottom"
                         style="background:#53A653;padding:8px;color:#fff;margin-bottom:10px">Đăng ký thành công
                    </div>
                @endif

                <div class="col-md-4 col-sm-4 col-xs-12 pd-mb-0">
                    <section class="login-box">
                        <header class="title-primary">
                            <div class="title">
                                <span>
                                    <b>
                                    {{ __('Login')  }}
                                    </b>
                                </span>
                            </div>
                        </header>
                        <section class="panel-body height100 pd-1-r-0">
                            <form method="post" action="{{ route('fe.login') }}">
                                @csrf
                                <div class="log login">
                                    <div class="body">
                                        <div class="form-row">
                                            <input type="text" name="email_log" class="form-control"
                                                   value="{{ old('email_log') }}"
                                                   placeholder="Email" style="margin-bottom:10px">
                                        </div>
                                        <div class="form-row">
                                            <input type="password" name="password_log" class="form-control"
                                                   placeholder="Mật khẩu" style="margin-bottom:10px">
                                        </div>
                                        <div class="form-row text-center">
                                            <button type="submit" class="btn btn-default">{{ __('Đăng nhập') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </section>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12 pd-mb-0">
                    <section class="register-box">
                        <header class="title-primary">
                            <div class="title">
                                <span>
                                    <b>
                                    {{ __('Register')  }}
                                    </b>
                                </span>
                            </div>
                        </header>
                        <section class="panel-body">
                            <div>
                                <p>Nếu bạn đã là thành viên xin mời bạn Đăng Nhập, Nếu chưa là thành viên xin mời bạn
                                    đăng ký tài khoản.</p>
                            </div>
                            <form method="post" action="{{ route('fe.register') }}">
                                @csrf
                                <div class="log login">
                                    <div class="form-row" style="margin-bottom:10px">
                                        <input type="text" name="name" value="{{ old('name') }}"
                                               placeholder="Tên đầy đủ (*)"
                                               class="form-control">
                                    </div>
                                    <div class="form-row" style="margin-bottom:10px">
                                        <input type="text" name="email" value="{{ old('email') }}"
                                               placeholder="Email (*)"
                                               class="form-control">
                                    </div>
                                    <div class="form-row" style="margin-bottom:10px">
                                        <input type="text" name="mobile" value="{{ old('mobile') }}"
                                               placeholder="Số điện thoại (*)"
                                               class="form-control">
                                    </div>
                                    <div class="form-row" style="margin-bottom:10px">
                                        <input type="password" name="password" value="{{ old('password') }}"
                                               placeholder="Mật khẩu (*)"
                                               class="form-control">
                                    </div>
                                    <div class="form-row" style="margin-bottom:10px">
                                        <input type="password" name="re_password" value="{{ old('re_password') }}"
                                               placeholder="Nhập lại mật khẩu (*)" class="form-control">
                                    </div>
                                    <div class="form-row text-center">
                                        <button type="submit" class="btn btn-default">{{ __('Đăng ký') }}</button>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </section>
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