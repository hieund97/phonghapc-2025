<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>{{__('Name')}}</label>
            <input name="title" value="{{ request('title') }}" class="form-control" placeholder="{{__('Name')}}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>{{ __('Created At') }}</label>
            <input autocomplete="off" type="text" name="created_at" value="{{ request('created_at') }}" class="form-control reservation">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>{{ __('Status') }}</label>
            <select name="status" class="form-control select2bs4">
                <option value=""></option>
                @foreach(\App\Models\Gift::STATUS as $value => $name)
                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                        {{ __("gift.status.$name") }}
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


