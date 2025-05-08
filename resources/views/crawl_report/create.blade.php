@extends('layouts.app')

@section('page-title', !empty($currentCrawlData) ? __('Edit Crawl Data') : __('Crawl Data'))

@section('content')
    <div class="row">
        @cannot('roles.update')
            @php $currentCrawlData = null @endphp
        @endcannot

        @php
            $showForm = true;

            if (!request()->user()->can('crawl_report.store')) {
                $showForm = false;
            }

            if (!empty($currentCrawlData)) {
                $showForm = request()->user()->can('crawl_report.update');
            }
        @endphp

        @if ($showForm)
            <div class="col-md">
                <form method="post" class="card card-primary card-outline card-outline-tabs"
                      action="{{ !empty($currentCrawlData) ? route('crawl-report.update', ['crawl_report' => $currentCrawlData->id]) : route('crawl-report.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @if (!empty($currentCrawlData))
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
                                @include('crawl_report.elements.info')
                            </div>
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="float-right">
                            @if (!empty($currentCrawlData))
                                <a href="{{ route('crawl-report.index') }}" class="btn btn-danger btn-sm">
                                    {{ __('Cancel') }}
                                </a>
                            @endif


                            <button type="button" id="quick_update_price"
                                    style="{{ empty($currentCrawlData) || $currentCrawlData->status == 1 ? 'display:none' : ''  }}"
                                    class="btn btn-info btn-sm">
                                {{ __('Quick update price') }}
                            </button>

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

        $('#quick_update_price').on('click', function () {
            let product_id = $('#product_update_id').val();
            let price = $('#product_new_price').val();
            let crawl_id = '{{ $currentCrawlData->id ?? null }}';
            Swal.fire({
                title: 'Bạn có chắc chắn muốn điều chỉnh giá?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dd3333',
                confirmButtonText: "Cập nhật",
                cancelButtonText: 'Huỷ',
            }).then((result) => {
                if (result.value) {
                    updatePriceByCrawlPrice(product_id, price, crawl_id, true);
                }
            });
        })
    </script>

    @include('partials.cards.delete')
@endpush
