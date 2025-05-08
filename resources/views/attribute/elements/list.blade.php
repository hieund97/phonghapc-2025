<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('List of attribute') }}</h3>

        <div class="card-tools">
            <a href="{{ route('attribute.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> {{ __('Create') }}
            </a>
            <button type="button" id="btn_filter" class="btn btn-primary btn-sm">
                <i class="fa fa-filter"></i> {{ __('Filter') }}
            </button>
        </div>
    </div>

    @include('attribute.elements.table')
</div>

@push('scripts')
    @include('partials.cards.delete')
@endpush
