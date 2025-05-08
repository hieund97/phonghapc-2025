@extends('layouts.app')

@section('page-title', __('Dashboard'))

@section('content')
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-camera"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('Products')}}</span>
                        <span class="info-box-number">
              {{$countProduct}}
            </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="far fa-newspaper"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('Posts')}}</span>
                        <span class="info-box-number">{{$countPost}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('Orders')}}</span>
                        <span class="info-box-number">{{$countOrder}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('Users')}}</span>
                        <span class="info-box-number">{{$countUser}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        {{--@include('home.site_analytics',[$totalVisitorsAndPageViews])--}}
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
                <!-- MAP & BOX PANE -->
                <!-- TABLE: LATEST ORDERS -->
                @include('home.latest_orders',[$latestOrders])
                {{--@include('home.top_most_visit_pages',[$latestOrders])--}}

            </div>
            <!-- /.col -->

            <div class="col-md-4">
                <!-- PRODUCT LIST -->
                @include('home.recently_added_products',[$recentlyAddedProducts])
                {{--@include('home.top_browsers',[$latestOrders])
                @include('home.top_referrers',[$latestOrders])--}}

            </div>
            <!-- /.col -->

            <div class="col-md-8"></div>
            <div class="col-md-4">
                {{--MOST VIEW PRODUCT LIST--}}
                @include('home.most_viewed_products', [$mostViewedProduct])
            </div>
        </div>
        <!-- /.row -->
    </div><!--/. container-fluid -->
@endsection
