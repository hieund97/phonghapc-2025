<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('List of tag') }}</h3>

        <div class="card-tools">
            <button type="button" id="btn_filter" class="btn btn-primary btn-sm">
                <i class="fa fa-filter"></i> {{ __('Filter') }}
            </button>
        </div>
    </div>

    @include('tags.elements.table')
</div>

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
