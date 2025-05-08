@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif

@section('page-title', 'Liên hệ')
@section('content')
    <div class="main-product wrapper" id="main">
        <div class="bres">
            <div class="container pd-10">
                <ul>
                    <li><a href="{{ route('fe.home') }}">Trang chủ</a>/</li>
                    <li>Liên hệ</li>
                </ul>
            </div>
        </div>
        <section class="main-content">
            <div id="main-contact" class="main">
                <div class="container pd-10">
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12 rounded animation-element fade-left animated fadeInLeft">
                            <div class="map-contact">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.0736221396473!2d105.86086851467554!3d20.869082598586672!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135b23293abd205%3A0xff0b8c0543ddfbdf!2zNjggxJAuIFRy4bqnbiBQaMO6LCBUVC4gVGjGsOG7nW5nIFTDrW4sIFRoxrDhu51uZyBUw61uLCBIw6AgTuG7mWksIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1635579400663!5m2!1svi!2s"
                                        width="100%" height="180" frameborder="0" style="border:0"
                                        allowfullscreen=""></iframe>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 rounded animation-element fade-right animated fadeInRight contact-custom-form">
                            <div class="callout callout-success uk-margin-bottom hidden success-box"
                                 style="background:#53A653;padding:8px;color:#fff;margin-bottom:10px">Gửi thành công
                            </div>
                            <div class="callout callout-success uk-margin-bottom hidden fail-box"
                                 style="background:#ec0303;padding:8px;color:#fff;margin-bottom:10px">Gửi thất bại
                            </div>
                            <div class="form-contat">
                                <p class="desc">
                                    Liên hệ với chúng tôi bằng cách <strong>điền thông tin vào form sau</strong>
                                </p>
                                <form action="{{ route('contacts.store') }}" method="post">
                                    @csrf
                                    <input type="text" class="fullname" name="fullname" placeholder="Họ và tên (*)">
                                    <input type="text" class="phone_number" name="phone_number" placeholder="Số điện thoại">
                                    <input type="text" class="email" name="email" placeholder="Email (*)">
                                    <input type="text" class="title" name="title" placeholder="Tiêu đề">
                                    <input type="hidden" class="data-input"
                                           data-status="{{ config('front_end.contact_status.processing') }}"
                                           data-contact-receiver-id="{{ config('front_end.contact_receiver_id.customer') }}"
                                           data-important="{{ config('front_end.contact_important.very_important') }}">
                                    <textarea name="content" class="content" cols="40" rows="10" placeholder="Nội dung"></textarea>
                                    <div class="send-contact">
                                        <div class="item">
                                            <button type="button" class="sbm-btn" name="create">Gửi</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            $('.sbm-btn').on('click', function (e){
                $('.success-box').addClass('hidden');
                $('.fail-box').addClass('hidden');
                let name = $('.fullname').val();
                let phone = $('.phone_number').val();
                let email = $('.email').val();
                let title = $('.title').val();
                let content = $('.content').val();
                let status = $('.data-input').data('status');
                let contactReceiver = $('.data-input').data('contact-receiver-id');
                let important = $('.data-input').data('important');
                $.ajax({
                    url:'{{ route('contacts.store') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        fullname: name,
                        phone_number: phone,
                        email: email,
                        title: title,
                        content: content,
                        status: status,
                        contact_receiver_id: contactReceiver,
                        is_important: important,
                    },
                    success: function (){
                        $('.success-box').removeClass('hidden');
                    },
                    error: function (){
                        $('.fail-box').removeClass('hidden');
                    }
                });
            });
        });
    </script>
@endpush