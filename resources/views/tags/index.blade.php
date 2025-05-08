@extends('layouts.app')

@section('page-title', __('Tag Manager'))

@section('content')
    <div class="row" id="filter-box" style="display: none;">
        <div class="col-12">
            @include('tags.elements.filter')
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @include('tags.elements.list')
        </div>
    </div>
@endsection

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
