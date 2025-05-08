<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>{{__('Name')}}</label>
            <input name="name" value="{{ request('name') }}" class="form-control" placeholder="{{__('Name')}}">
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
            <label>{{__('Author')}}</label>
            <input autocomplete="off" name="author" value="{{ request('author') }}" class="form-control" placeholder="{{__('Author')}}">         
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('Status') }}</label>
            <select name="status" class="form-control select2bs4">
                <option value=""></option>
                @foreach(config('admin.product_status') as $value => $name)
                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                        {{ __("products.status.$name") }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Price') }}</label>

            <div class="input-group">
                <input type="number" name="price[from]" value="{{ request('price.from') }}" placeholder="{{ __('From') }}" class="form-control">
                <span class="input-group-append">-</span>
                <input type="number" name="price[to]" value="{{ request('price.to') }}" placeholder="{{ __('To') }}" class="form-control">
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('Created At') }}</label>
            <input autocomplete="off" type="text" name="created_at" value="{{ request('created_at') }}" class="form-control reservation">
        </div>
    </div>
    @if(!empty($used))
        <div class="col-md-3">
            <div class="form-group">
                <label>{{ __('Date Of Sale') }}</label>
                <input autocomplete="off" type="text" name="date_of_sale" value="{{ request('date_of_sale') }}" class="form-control reservation">
            </div>
        </div>
    @endif
    <div class="col-md-3">
        <div class="form-group">
            <label>{{ __('Is_Sale') }}</label>
            <select name="in_sale_time" class="form-control select2bs4">
                <option value=""></option>
                @foreach(config('admin.product_sale') as $value => $name)
                    <option value="{{ $value }}" {{ request('in_sale_time') == $value ? 'selected' : '' }}>
                        {{ __($name) }}
                    </option>
                @endforeach
            </select>
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


