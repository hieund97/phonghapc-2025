@extends('layouts.app')

@section('page-title', __('Deleted products') . (!empty($used) ? ' ' . __('used') : ''))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Deleted products') }}</h3>

                    <div class="card-tools">
                    </div>
                </div>

                @include('products.elements.table',['typeDelete'=>'delete'])
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        .image-column {
            width: 80px;
            height: 80px;
            float: left;
            margin-bottom: 5px;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            // Id filter
            const elementFilter = '#filter-box';
            // Ẩn hiện form tìm kiếm
            $('#btn_filter').click(function() {
                $(elementFilter).toggle();
            });

            @if (!empty(request()->has('submit')))
            $(elementFilter).show();
            @else
            $(elementFilter).hide();
            @endif
        });
    </script>
@endpush
