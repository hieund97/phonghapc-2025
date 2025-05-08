$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
});

$(document).ready(function() {

    $('.nav-sidebar li:not(.has-treeview) > a').on('click', function() {
        $('.nav-sidebar a').removeClass('active');
        $(this).addClass('active');
        $(this).parent().closest('ul').parent().closest('li').find('a').first().addClass('active');
    });

    // Sortable
    $('.ui-sortable-handle').css('cursor', 'move');
});

function showOverlay(element) {
    $(element).append('<div class="overlay overlay dark"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
}

function removeOverlay() {
    $('.overlay').remove();
}