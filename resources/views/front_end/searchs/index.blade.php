@extends('front_end.layouts.app')
@if(!empty($q))
@section('breadcrumbs')
    {{Breadcrumbs::view('breadcrumbs::json-ld', 'fe.search',$q)}}
@stop
@endif
@section('page-title', "Kết quả tìm kiếm: " . $q )
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/category_product.css') }}">
@endpush
@section('content')
    <section class="main-content product-catalogue-product">
        <div class="container pd-10">
            <div class="row">
                <div class="col-3 col-md-3 col-lg-3">
                    @include('front_end.partials.filter', ['isCategory' => false, 'arrAttribute' => $arrAttribute ?? [], 'listAllAttribute' => $listAllAttribute, 'selectedAttribute' => $selectedAttribute ?? []])
                </div>

                <div class="col-md-9 col-sm-9 col-xs-12 right-catalog-pr">
                    @include('front_end.partials.list-product', ['aryProduct' => $products, 'title' => "Kết quả tìm kiếm: " . $q ])
                </div>
            </div>
        </div>
    </section>
@endsection
