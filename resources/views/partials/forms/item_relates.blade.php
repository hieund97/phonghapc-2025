<label>{{ __('Related_products') }}</label>

{{-- <div class="row">
    <table class="table table-bordered table-striped" id="user_table">
        <thead>
            <tr>
                <div class="col-md-2">
                    <th><label>{{ __('Title') }}</label></th>
                </div>
                <div class="col-md-2">
                    <th><label>{{ __('Title') }}</label></th>
                </div>
                <div class="col-md-2">
                    <th><label>{{ __('Title') }}</label></th>
                </div>
                <div class="col-md-2">
                    <th><label>{{ __('Title') }}</label></th>
                </div>
                <div class="col-md-2">
                    <th><label>{{ __('Title') }}</label></th>
                </div>
            </tr>
        </thead>

    </table>


</div> --}}
<table class="table table-bordered table-striped" id="user_table">
    <thead>
        <tr>
            <th width="20%">{{ __('Title') }}</th>
            <th width="20%">{{ __('Link') }}</th>
            <th width="20%">{{ __('Image') }}</th>
            <th width="10%">{{ __('Rel') }}</th>
            <th width="20%">{{ __('Target') }}</th>
            <th width="10%">{{ __('Sort') }}</th>
        </tr>
    </thead>
    <tbody>

    </tbody>

</table>

<script>
    $(document).ready(function() {

        var count = 1;

        dynamic_field(count);

        function dynamic_field(number) {
            html = '<tr>';
            html += '<td><input type="text" name="item_relate['+number+'][title]" class="form-control" /></td>';
            html += '<td><input type="text" name="item_relate['+number+'][link]" class="form-control" /></td>';
            html += '<td><input type="text" name="item_relate['+number+'][image]" class="form-control" /></td>';
            html += '<td><input type="text" name="item_relate['+number+'][rel]" class="form-control" /></td>';
            html += '<td><input type="text" name="item_relate['+number+'][target]" class="form-control" /></td>';
            html += '<td><input type="text" name="item_relate['+number+'][sort]" class="form-control" /></td>';
            if (number > 1) {
                html +=
                    '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
                $('tbody').append(html);
            } else {
                html +=
                    '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td></tr>';
                $('tbody').html(html);
            }
        }

        $(document).on('click', '#add', function() {
            count++;
            dynamic_field(count);
        });

        $(document).on('click', '.remove', function() {
            count--;
            $(this).closest("tr").remove();
        });



    });

</script>
