<script>
    $('.duallistbox').bootstrapDualListbox({
        filterTextClear: "{!! __('show all') !!}",
        filterPlaceHolder: "{!! __('Filter') !!}",
        moveSelectedLabel: "{{ __('Move selected') }}",
        moveAllLabel: "{!! __('Move all') !!}",
        removeSelectedLabel: "{!! __('Remove selected') !!}",
        removeAllLabel: "{!! __('Remove all') !!}",
        infoText: '{!! __("Showing all") !!} {0}',
        infoTextFiltered: '<span class="badge badge-warning">{!!__("Filtered") !!}</span> {0} {!! __("from") !!} {1}',
        infoTextEmpty: "{!! __('Empty list') !!}",
        selectorMinimalHeight:269
    });
</script>
