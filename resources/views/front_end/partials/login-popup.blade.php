{{--Pop up Login--}}
<div class="global-popup-login" style="display: block; display:none">
    <div class="global-popup-content">
        <div class="item-left-login"><img src="{{ asset('images/login-popup.png') }}" alt="popup"
                                    class="lazy loading" data-was-processed="true"></div>

        <div class="item-right-login" id="js-popup-holder">
        </div>
    </div>

    <div class="bg-popup close-btn"></div>
</div>

<script>
    const login_template = `
        <div class="popup-content-group d-block" id="js-popup-login">
            <div class="popup-btn-direction justify-content-end">
                <a href="/"></a>
                <a href="javascript:void(0)" class="close-popup mb-icons close-btn"><i class="fas fa-times"></i></a>
            </div>

            <div class="box-title">
                <p>Đăng nhập bằng Email</p>
                <p><a href="javascript:void(0)" class="register-btn">Đăng ký</a> nếu chưa có tài khoản.</p>
            </div>

            <div class="input-holder">
                <div class="input-box">
                    <input type="text" placeholder="Email" id="js-popup-login-email"/>
                </div>

                <div class="input-box input-password">
                    <input type="password" placeholder="Mật khẩu" id="js-popup-login-password"/>
                </div>

                <p class="mt-1 red" id="js-popup-login-note" style="white-space: pre-line; color:red"><!-- // note --></p>

                <div class="d-flex flex-wrap align-items-center justify-content-end">
<!--                    <a href="javascript:void(0)" class="btn-forgot-password">Quên mật khẩu ?</a>-->

                    <a href="javascript:void(0)" onclick="login()" class="popup-btn btn-login login-btn">Đăng nhập</a>
                </div>

                <div class="text-center" style="color:#0a0302; text-align:center">
                    <p class="text-16 mb-text-14" style="margin: 0 0 24px 0;font-size:20px">- Hoặc đăng nhập bằng -</p>

                    <div class="popup-icons-group">
                        <a href="javascript:void(0)"  class="icons icon-google"></a>
                        <a href="javascript:void(0)"  class="icons icon-facebook"></a>
                    </div>
                </div>
            </div>
        </div>
    `;

    const register_template = `
        <div class="popup-content-group d-block popup-registor-group" id="js-popup-registor">
            <div class="popup-btn-direction">
                <a href="javascript:void(0)" class="btn-back"></a>
                <a href="javascript:void(0)" class="close-popup mb-icons close-btn"><i class="fas fa-times"></i></a>
            </div>

            <div class="box-title">
                <p>Tạo tài khoản</p>
                <p>Vui lòng cho chúng tôi biết thông tin về bạn </p>
            </div>

            <div class="input-holder">
                <div class="input-box">
                    <input type="text" placeholder="Tên bạn" id="js-popup-register-name"/>
                </div>

                <div class="input-box">
                    <input type="email" placeholder="Email" id="js-popup-register-email"/>
                </div>

                <div class="input-box">
                    <input type="text" placeholder="Số điện thoại" id="js-popup-register-phone-number"/>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class = row>
                        <div class="input-box input-password col-md-6">
                            <input type="password" placeholder="Mật khẩu" id="js-popup-register-password"/>
                        </div>
                        <div class="input-box input-password col-md-6">
                            <input type="password" placeholder="Nhập lại mật khẩu" id="js-popup-register-password-2"/>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="g-recaptcha" id="html_element_regis" data-sitekey="{#RECAPTCHA_SITE_KEY#}"
                    render="explicit"></div>
                    <span class="note-error-plp" id="check_user2" style="color: #ff0000;"></span>
                </div>

                <p class="m-0 red" id="js-popup-register-note" style="white-space: pre-line;"><!-- // note --></p>
                <a href="javascript:void(0)" onclick="register()" class="popup-btn">Tạo tài khoản</a>
            </div>
        </div>
    `;

    const forgot_password_template = `
        <div class="popup-content-group d-block" id="js-popup-forgot-password">
            <div class="popup-btn-direction">
                <a href="javascript:void(0)" class="btn-back"></a>
                <a href="javascript:void(0)" class="fas fa-times close-popup mb-icons close-btn"><i class="fas fa-times"></i></a>
            </div>

            <div class="box-title">
                <p>Quên mật khẩu tài khoản</p>
                <p>Nhập địa chỉ email của bạn dưới đây và hệ thống sẽ gửi cho bạn một liên kết để đặt lại mật khẩu của bạn</p>
            </div>

            <div class="input-holder">
                <div class="input-box">
                    <input type="text" placeholder="Nhập email của bạn..." id="js-forgotpass-email"/>
                </div>

                <a href="javascript:void(0)" class="popup-btn m-0 mt-4" onclick="accountRecoverPassword($('#js-forgotpass-email').val());">Lấy lại mật khẩu</a>
            </div>

            <div class="mt-3 red" id="js-forgotpass-note" style="white-space: pre-line;"><!--// note --> </div>
        </div>
    `;

    $(document).ready(function () {
        $('.global-popup-login').hide();
    });

    // Login
    $(document).on('click', '.open-login', function (e) {
        $('.global-popup-login').show();
        $('.item-right-login').html(login_template);
    });

    $(document).on('click', '.open-register', function (e) {
        $('.global-popup-login').show();
        $('.item-right-login').html(register_template);
    });

    $(document).on('click', '.close-btn', function (e) {
        $('.global-popup-login').hide();
    });

    $(document).on('click', '.btn-back', function (e) {
        $('.item-right-login').html(login_template);
    });

    $(document).on('click', '.icon-google', function (e) {
        loginGoolge();
    });

    $(document).on('click', '.icon-facebook', function (e) {
        loginFacebook();
    });

    $(document).on('click', '.register-btn', function (e) {
        $('.item-right-login').html(register_template);
    });

    // $(document).on('click', '.btn-forgot-password', function (e) {
    //     $('.item-right-login').html(forgot_password_template);
    // });

    function login() {
        var homePage = '{{ route('fe.home') }}';
        var email = $('#js-popup-login-email').val();
        var password = $('#js-popup-login-password').val();

        $.ajax({
            type   : "POST",
            url    : '{{ route('fe.login') }}',
            data   : {
                _token      : '{{ csrf_token() }}',
                email_log   : email,
                password_log: password,
            },
            success: function (response) {
                window.location.href = homePage;
            },
            error  : function (xhr) {
                $('#js-popup-login-note').html('Tài khoản hoặc mật khẩu của bạn không đúng');
            }
        });
    }

    function loginGoolge() {
        $.ajax({
            type   : "POST",
            url    : '{{ route('fe.login.google') }}',
            success: function (response) {
                window.location.href = response.url;
            },
            error  : function (xhr) {

            }
        });
    }

    function loginFacebook() {
        $.ajax({
            type   : "POST",
            url    : '{{ route('fe.login.facebook') }}',
            success: function (response) {
                window.location.href = response.url;
            },
            error  : function (xhr) {

            }
        });
    }

    function register() {
        var email = $('#js-popup-register-email').val();
        var password = $('#js-popup-register-password').val();
        var phone = $('#js-popup-register-phone-number').val();
        var name = $('#js-popup-register-name').val();
        var re_pass = $('#js-popup-register-password-2').val();
        $.ajax({
            type   : "POST",
            url    : '{{ route('fe.register') }}',
            data   : {
                _token     : '{{ csrf_token() }}',
                name       : name,
                mobile     : phone,
                email      : email,
                password   : password,
                re_password: re_pass,
            },
            success: function (response) {
                $('#js-popup-register-note').attr('style', 'color:green');
                $('#js-popup-register-note').html('Đăng ký thành công');
            },
            error  : function (xhr) {
                $('#js-popup-register-note').attr('style', 'color:red');
                $('#js-popup-register-note').html('Đăng ký thất bại, vui lòng thử lại!');
            }
        });
    }
</script>