<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>{{__('URL')}}</label>
            <input name="url" value="{{ request('title') }}" class="form-control" placeholder="{{__('url')}}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>{{__('Name Product')}}</label>
            <input name="product" value="{{ request('product') }}" class="form-control" placeholder="{{__('Name Product')}}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>{{ __('Follow product') }}</label>
            <select name="follow" class="form-control select2bs4">
                <option value=""></option>
                @foreach(App\Models\CrawlReport::FOLLOW as $value => $name)
                    <option value="{{ $value }}" {{ request('follow') === $value ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('Status') }}</label>
            <select name="status" class="form-control select2bs4">
                <option value=""></option>
                @foreach(App\Models\CrawlReport::STATUS as $value => $name)
                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>{{__('Category')}}</label>
            <select name="product_category[]" class="form-control select2bs4" multiple>
                @include('partials.forms.product_category_options', ['selected' => request('product_category')])
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('Type') }}</label>
            <select name="type" class="form-control select2bs4">
                <option value=""></option>
                @foreach(App\Models\CrawlReport::TYPE as $value => $name)
                    <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('Updated At') }}</label>
            <input autocomplete="off" type="text" name="updated_at" value="{{ request('updated_at') }}" class="form-control reservation">
        </div>
    </div>
</div>


@push('styles')
    <link rel="stylesheet" href="{{ asset('theme/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4',
            });

            //Chọn ngày tháng
            $('.reservation').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
            $('.reservation').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('.reservation').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });


        });
    </script>
@endpush


