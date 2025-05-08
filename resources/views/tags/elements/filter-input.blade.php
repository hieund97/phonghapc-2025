<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{__('Name')}}</label>
            <input name="name" value="{{ request('name') }}" class="form-control" placeholder="{{__('Name')}}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Type') }}</label>
            <select name="type" class="form-control select2bs4">
                <option value="">{{ __('All') }}</option> 
                @foreach(config('admin.tag_type') as $item)     
                    <option value="{{ $item }}" @if(request('name')==$item) selected @endif>{{ __($item) }}</option>      
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


