<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('List of products') }}</h3>

        <div class="card-tools">
            <a href="{{ route('products.delete.list') }}" class="btn btn-warning btn-sm">
                {{ __('Trash') }}
            </a>

            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exportExcelModal">
                {{ __('Export Excel') }}
            </button>

            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> {{ __('Create') }}
            </a>

            <button type="button" id="btn_filter" class="btn btn-primary btn-sm">
                <i class="fa fa-filter"></i> {{ __('Filter') }}
            </button>
        </div>
    </div>

    @include('products.elements.table')
</div>

@push('footer')
    <div class="modal fade" id="exportExcelModal" tabindex="-1" role="dialog" aria-labelledby="exportExcelModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('products.export') }}" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportExcelModalTitle">Chọn cột</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @foreach(collect(\App\Exports\ProductsExport::$availableColumns)->chunk(4) as $chunk)
                        <div class="row">
                            @foreach($chunk as $column => $name)
                                <div class="col-md-3">
                                    <div class="checkbox icheck-primary">
                                        <input
                                                type="checkbox"
                                                name="columns[]"
                                                value="{{ $column }}"
                                                id="ex-col-{{ $column }}"
                                                @if (in_array($column, \App\Exports\ProductsExport::$defaultColumns)) checked @endif
                                        >

                                        <label for="ex-col-{{ $column }}">{{ $name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Export') }}</button>
                </div>
            </form>
        </div>
    </div>
@endpush

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
    @include('partials.cards.delete')
@endpush
