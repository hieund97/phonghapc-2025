@extends('layouts.app')

@section('page-title', !empty($currentCategory) ? __('Edit Category: :name', ['name' => $currentCategory->title]) : __('Category'))

@section('content')
    <div class="row">
        @cannot('roles.update')
            @php $currentCategory = null @endphp
        @endcannot

        @php
            $showForm = true;

            if (!request()->user()->can('product_categories.store')) {
                $showForm = false;
            }

            if (!empty($currentCategory)) {
                $showForm = request()->user()->can('product_categories.update');
            }
        @endphp

        @if ($showForm)
            <div class="col-md">
                <form method="post" class="card card-primary card-outline card-outline-tabs"
                      action="{{ !empty($currentCategory) ? route('product_categories.update', ['product_category' => $currentCategory->id]) : route('product_categories.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @if (!empty($currentCategory))
                        @method('PUT')
                    @endif

                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="category-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="category-tabs-info-tab" data-toggle="pill"
                                   href="#category-tabs-info" role="tab" aria-controls="category-tabs-info"
                                   aria-selected="true">{{ __('Info') }}</a>
                            </li>

                            <!-- Thuộc tính -->
                            <li class="nav-item">
                                <a class="nav-link" id="category-tabs-attribute-tab" data-toggle="pill"
                                   href="#category-tabs-attribute" role="tab" aria-controls="category-tabs-attribute"
                                   aria-selected="true">{{ __('Attribute') }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="category-tabs-content">
                            <div class="tab-pane fade show active" id="category-tabs-info" role="tabpanel"
                                 aria-labelledby="category-tabs-info-tab">
                                @include('product_categories.elements.info')
                            </div>

                            <div class="tab-pane fade" id="category-tabs-attribute" role="tabpanel"
                                 aria-labelledby="category-tabs-attribute-tab">
                                <div class="row">
                                    @foreach($arrAttribute as $attribute)
                                        <div class="attribute-list col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-lanel">{{ $attribute->title }}</label>
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="checkbox" style="padding:0;">
                                                        @foreach($attribute->attrValueTitle as $attrValue)
                                                            <label class="tpInputLabel" style="width:180px;">
                                                                <input name="attribute[{{ $attribute->id }}][]"
                                                                       type="checkbox" class="tpInputCheckbox"
                                                                       value="{{ $attrValue->id }}"

                                                                       @if(isset($currentCategory) && !empty($currentCategory->attribute))
                                                                           @foreach($currentCategory->attribute as $key => $value)
                                                                               @php
                                                                                    if(empty($value->attrCate)) {
                                                                                        continue;
                                                                                    }
                                                                               @endphp
                                                                                   @if($value->id == $attrValue->id && $value->attrCate->id === $attribute->id)
                                                                                       checked
                                                                                   @endif
                                                                            @endforeach
                                                                        @endif
                                                                >
                                                                <span class="font-weight-normal">{{ $attrValue->title }}</span>
                                                                <input type="text" class="attr-value-order"
                                                                       data-id="{{ $attrValue->id }}" style="width:20px; height:20px"
                                                                       value="{{ $attrValue->order }}">
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="float-right">
                            @if (!empty($currentCategory))
                                <a href="{{ route('product_categories.index') }}" class="btn btn-danger btn-sm">
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

        @include('product_categories.elements.list')
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.attr-value-order').on('change', function () {
                let id = $(this).data('id');
                let order = $(this).val();

                $.ajax({
                    url    : '{{ route('product_categories.order_attr_value') }}',
                    type   : 'POST',
                    data   : {
                        _token: '{{ csrf_token() }}',
                        id    : id,
                        order : order,
                    },
                    success: function (data) {
                        if (data.status == 1) {
                            Toast.fire({
                                type : 'success',
                                title: '{{__('Update data successfully.')}}',
                            })
                        } else {
                            Toast.fire({
                                type : 'error',
                                title: '{{__('Update error data.')}}',
                            })
                        }
                        removeOverlay()
                    }
                })
            })
        })

        $(document).on('change', '.cate-child-order', function (){
            let id = $(this).data('id')
            let order = $(this).val();

            $.ajax({
                url: '{{ route('product_categories.update_order_sub_cate') }}',
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    order: order,
                },
                success: function (data){
                    if (data.status == 1) {
                        Toast.fire({
                            type : 'success',
                            title: '{{__('Update data successfully.')}}'
                        })
                    } else {
                        Toast.fire({
                            type : 'error',
                            title: '{{__('Update error data.')}}'
                        })
                    }
                    removeOverlay()
                }
            })
        })

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
