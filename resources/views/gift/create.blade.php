@extends('layouts.app')

@section('page-title', !empty($gift) ? __('Edit Gift: :name', ['name' => $gift->title]) : __('Gift'))

@section('content')
    <div class="row">
        @cannot('roles.update')
            @php $gift = null @endphp
        @endcannot

        @php
            $showForm = true;

            if (!request()->user()->can('product_categories.store')) {
                $showForm = false;
            }

            if (!empty($gift)) {
                $showForm = request()->user()->can('product_categories.update');
            }
        @endphp

        @if ($showForm)
            <div class="col-md">
                <form method="post" class="card card-primary card-outline card-outline-tabs"
                      action="{{ !empty($gift) ? route('gift.update', ['gift' => $gift->id]) : route('gift.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @if (!empty($gift))
                        @method('PUT')
                    @endif

                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="attribute-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="attribute-tabs-info-tab" data-toggle="pill"
                                   href="#attribute-tabs-info" role="tab" aria-controls="category-tabs-info"
                                   aria-selected="true">{{ __('Info') }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="attribute-tabs-content">
                            <div class="tab-pane fade show active" id="attribute-tabs-info" role="tabpanel"
                                 aria-labelledby="category-tabs-info-tab">
                                @include('gift.elements.info')
                            </div>
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="float-right">
                            @if (!empty($gift))
                                <a href="{{ route('gift.index') }}" class="btn btn-danger btn-sm">
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
    </div>
@endsection

@push('scripts')
    <script>
        function expandCollapse(el) {
            var parent = $(el).parent();

            parent.collapse('show');

            if (parent.parent().hasClass('collapse')) {
                expandCollapse('#' + parent.attr('id'));
            }
        }

        expandCollapse('.cl-active');

        $('.expaned').on('click', function () {
            $('.fa', this).toggleClass('fa-chevron-right').toggleClass('fa-chevron-down');
        });

        $('.prevent-expand').on('click', function (e) {
            e.preventDefault();
            return false;
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: "Chọn danh mục",
        });
    </script>

    @include('partials.cards.delete')
@endpush
