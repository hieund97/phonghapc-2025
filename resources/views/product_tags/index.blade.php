@extends('layouts.app')

@section('page-title', !empty($currentProductTag) ? __('Edit Product tag: :name', ['name' => $currentProductTag->title]) : __('Product tag'))

@section('content')
    <div class="row">
        @cannot('product_tags.update')
            @php $currentProductTag = null @endphp
        @endcannot

        @php
            $showForm = true;

            if (!request()->user()->can('product_tags.store')) {
                $showForm = false;
            }

            if (!empty($currentProductTag)) {
                $showForm = request()->user()->can('product_tags.update');
            }
        @endphp

        @if ($showForm)
            <div class="col-md">
                <form method="post" class="card card-primary card-outline card-outline-tabs" action="{{ !empty($currentProductTag) ? route('product_tags.update', ['product_tag' => $currentProductTag->id]) : route('product_tags.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($currentProductTag)) @method('PUT') @endif

                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="category-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="category-tabs-info-tab" data-toggle="pill" href="#category-tabs-info" role="tab" aria-controls="category-tabs-info" aria-selected="true">{{ __('Info') }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="category-tabs-content">
                            <div class="tab-pane fade show active" id="category-tabs-info" role="tabpanel" aria-labelledby="category-tabs-info-tab">
                                @include('product_tags.elements.info')
                            </div>
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="float-right">
                            @if (!empty($currentProductTag))
                                <a href="{{ route('product_tags.index') }}" class="btn btn-danger btn-sm">
                                    {{ __('Cancel') }}
                                </a>
                            @endif

                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        @include('product_tags.elements.list')
    </div>
@endsection

@push('scripts')
    <script>
        function expandCollapse(el)
        {
            var parent = $(el).parent();

            parent.collapse('show');

            if (parent.parent().hasClass('collapse')) {
                expandCollapse('#' + parent.attr('id'));
            }
        }

        expandCollapse('.cl-active');

        $('.expaned').on('click', function() {
            $('.fa', this).toggleClass('fa-chevron-right').toggleClass('fa-chevron-down');
        });

        $('.prevent-expand').on('click', function(e) {
            e.preventDefault();
            return false;
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });  
    </script>

    @include('partials.cards.delete')
@endpush
