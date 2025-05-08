<form id="filter-card" class="card" style="display: none;">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="filter_type">{{ __('Type') }}</label>
                    <select name="type" id="filter_type" class="form-control select2bs4">
                        <option value=""></option>

                        <option value="{{ \App\Models\ProductCategory::class }}" @if (request('type') == \App\Models\ProductCategory::class) selected @endif>
                            {{ __(\App\Models\ProductCategory::class) }}
                        </option>

                        
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div id="category_select" class="form-group" style="display: none;">
                    <label for="filter_category">
                        {{ __('Category') }}
                    </label>

                    <select name="category" id="filter_category" class="form-control select2bs4">
                        <option value=""></option>

                        @include('partials.forms.product_category_options', ['selected' => request('category')])
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button class="btn btn-primary btn-sm float-right">
            {{ __('Filter') }}
        </button>

        <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm float-right mr-2">
            {{ __('Reset') }}
        </a>
    </div>
</form>

@push('scripts')
    <script>
        $('{{ $toggleBtn }}').click(function() {
            $('#filter-card').toggle();
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });

        function updateFilter(empty)
        {
            if (empty) {
                $('#filter_category').val('').trigger('change');
                $('#filter_collection').val('').trigger('change');
            }

            let type = $('#filter_type').val();

            if (type === 'App\\Models\\ProductCategory') {
                $('#collection_select').hide();
                $('#category_select').show();
            } else {
                $('#collection_select').hide();
                $('#category_select').hide();
            }
        }

        $('#filter_type').change(function() {
            updateFilter(true);
        });

        updateFilter();
    </script>
@endpush
