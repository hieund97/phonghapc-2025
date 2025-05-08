<div class="row" id="order-card" style="display: none;">
    <div class="col-md-12">
        <form action="{{ route('banners.priority') }}" method="post" class="card">
            @csrf

            <div class="card-body">
                <table class="table table-hover table-sm">
                    <tbody id="order-table">
                        
                    </tbody>
                </table>

                <div id="order-data"></div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary btn-sm">{{ __('Save') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
    <script>
        $('{{ $toggleBtn }}').on('click', function () {
            $('#order-card').toggle();
        })

        $('#order-table').sortable({
            onSort: function () {
                let order = $('#order-table').sortable('toArray').reverse();

                $('#order-data').html('');

                $.each(order, function (index, id) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'data[' + index + '][id]',
                        value: id
                    }).appendTo('#order-data');

                    $('<input>').attr({
                        type: 'hidden',
                        name: 'data[' + index + '][priority]',
                        value: index
                    }).appendTo('#order-data');
                });
            }
        });
    </script>
@endpush
