@extends('layouts.app')

@section('page-title', __('System Settings'))

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" class="card-outline-tabs" method="POST"
                              action="{{route('settings.update') }}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="setting-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tabs-info-tab" data-toggle="pill"
                                           href="#tabs-info" role="tab" aria-controls="tabs-info"
                                           aria-selected="true">{{ __('Info') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-contact-tab" data-toggle="pill"
                                           href="#tabs-contact" role="tab" aria-controls="tabs-contact"
                                           aria-selected="false">{{ __('Contact') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-common-tab" data-toggle="pill"
                                           href="#tabs-common" role="tab" aria-controls="tabs-common"
                                           aria-selected="false">{{ __('Common') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-title-tab" data-toggle="pill"
                                           href="#tabs-title" role="tab" aria-controls="tabs-title"
                                           aria-selected="false">{{ __('Title') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-seo-tab" data-toggle="pill"
                                           href="#tabs-seo" role="tab" aria-controls="tabs-seo"
                                           aria-selected="false">{{ __('SEO') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-social-tab" data-toggle="pill"
                                           href="#tabs-social" role="tab" aria-controls="tabs-social"
                                           aria-selected="false">{{ __('Social') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-script-tab" data-toggle="pill"
                                           href="#tabs-script" role="tab" aria-controls="tabs-script"
                                           aria-selected="false">{{ __('Script') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabs-popup-tab" data-toggle="pill"
                                           href="#tabs-popup" role="tab" aria-controls="tabs-popup"
                                           aria-selected="false">{{ __('Pop up') }}</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="tab-content" id="tabs-content-info">
                                    {{--Info--}}
                                    <div class="tab-pane fade show active" id="tabs-info" role="tabpanel"
                                         aria-labelledby="tabs-info-tab">
                                        @include('setting.elements.info', ['view' => 'info'])
                                    </div>
                                    {{--End Info--}}

                                    {{--Contact--}}
                                    <div class="tab-pane fade" id="tabs-contact" role="tabpanel"
                                         aria-labelledby="tabs-contact-tab">
                                        @include('setting.elements.info', ['view' => 'contact'])
                                    </div>
                                    {{--End Contact--}}

                                    {{--Common--}}
                                    <div class="tab-pane fade" id="tabs-common" role="tabpanel"
                                         aria-labelledby="tabs-common-tab">
                                        @include('setting.elements.info', ['view' => 'common'])

                                    </div>
                                    {{--End Common--}}

                                    {{--Title--}}
                                    <div class="tab-pane fade" id="tabs-title" role="tabpanel"
                                         aria-labelledby="tabs-title-tab">
                                        @include('setting.elements.info', ['view' => 'title'])

                                    </div>
                                    {{--End Title--}}

                                    {{--SEO--}}
                                    <div class="tab-pane fade" id="tabs-seo" role="tabpanel"
                                         aria-labelledby="tabs-seo-tab">
                                        @include('setting.elements.info', ['view' => 'seo'])

                                    </div>
                                    {{--End SEO--}}

                                    {{--Social--}}
                                    <div class="tab-pane fade" id="tabs-social" role="tabpanel"
                                         aria-labelledby="tabs-social-tab">
                                        @include('setting.elements.info', ['view' => 'social'])

                                    </div>
                                    {{--End Social--}}

                                    {{--Script--}}
                                    <div class="tab-pane fade" id="tabs-script" role="tabpanel"
                                         aria-labelledby="tabs-script-tab">
                                        @include('setting.elements.info', ['view' => 'script'])

                                    </div>
                                    {{--End Script--}}

                                    {{--Pop Up--}}
                                    <div class="tab-pane fade" id="tabs-popup" role="tabpanel"
                                         aria-labelledby="tabs-popup-tab">
                                        @include('setting.elements.info', ['view' => 'popup'])

                                    </div>
                                    {{--End Pop Up--}}
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('scripts')
    @include('partials.js.rv_media',['buttonMoreImages'=>[]])
    @include('partials.editors.summernote',['editors'=>['popup','post_description'],'buttons'=>[],'realButtons'=>[]])
    @include('partials.editors.summernote',['editors'=>['popup','policy_sell_product'],'buttons'=>[],'realButtons'=>[]])
    @include('partials.editors.summernote',['editors'=>['popup','policy_exchange'],'buttons'=>[],'realButtons'=>[]])

@endpush
