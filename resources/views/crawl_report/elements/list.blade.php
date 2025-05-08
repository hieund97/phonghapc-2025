<div class="card">
    <div class="card-header">
        <div class="card-tools">
            <a href="{{ route('crawl-report.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> {{ __('Create') }}
            </a>
            <button type="button" id="btn_filter" class="btn btn-primary btn-sm">
                <i class="fa fa-filter"></i> {{ __('Filter') }}
            </button>
        </div>
    </div>

    @include('crawl_report.elements.table')
</div>

@push('scripts')
    @include('partials.cards.delete')
@endpush
