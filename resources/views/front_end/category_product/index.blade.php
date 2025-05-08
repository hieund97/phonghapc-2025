@extends('front_end.layouts.app')
@section('page-title', $category->title)
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif
@section('page-title', $category->title)
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/category_product.css') }}">
@endpush

@section('content')
    <section class="main-content product-catalogue-product" style="margin-top:0">
        @include('front_end.category_product.element.content-category',
            [
                'category'          => $category,
                'aryProduct'        => $aryProduct,
                '$listAllAttribute' => $listAllAttribute,
                'selected'          => $selectedAttribute ?? [],
                'type'              => $type ?? 0
            ])
    </section>
@endsection
@push('script')
    <script>
        localStorage.removeItem("filter_array_attribute");
        localStorage.removeItem("filter_category_id");
    </script>
@endpush
