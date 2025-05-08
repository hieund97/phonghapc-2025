@extends('layouts.app')

@section('page-title', !empty($currentAttrCategory) ? __('Edit Attribute: :name', ['name' => $currentAttrCategory->title]) : __('Attribute'))

@section('content')
    <div class="row">
        @cannot('roles.update')
            @php $currentAttrCategory = null @endphp
        @endcannot

        @php
            $showForm = true;

            if (!request()->user()->can('attribue.store')) {
                $showForm = false;
            }

            if (!empty($currentAttrCategory)) {
                $showForm = request()->user()->can('attribue.update');
            }
        @endphp

        @if ($showForm)
            <div class="col-md">
                <form method="post" class="card card-primary card-outline card-outline-tabs"
                      action="{{ !empty($currentAttrCategory) ? route('attribute.update', ['attribute' => $currentAttrCategory->id]) : route('attribute.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @if (!empty($currentAttrCategory))
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
                                @include('attribute.elements.info')
                            </div>
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="float-right">
                            @if (!empty($currentAttrCategory))
                                <a href="{{ route('attribute.index') }}" class="btn btn-danger btn-sm">
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
        });
    </script>

    @include('partials.cards.delete')
@endpush
