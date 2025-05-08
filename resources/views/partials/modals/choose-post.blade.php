@php
    $randomId = $randomId ?? (($name ?? '').time().Str::random(3))
@endphp

<div class="form-group">
    @if(!isset($hide_label))
        <label>{{ $label }} @if(isset($required)) (<span class="text-danger">*</span>) @endif</label>
    @endif

    <ul id="values-{{ $randomId }}">
        @if (!empty($data))
            @foreach($data as $value)
                <li>
                    <input type="hidden" name="{{ $name }}@if(!isset($single))[]@endif" value="{{ $value['value'] }}">
                    {{ $value['label'] }}
                </li>
            @endforeach
        @endif
    </ul>

    <div class="input-group mb-3">
        <input id="count-{{ $randomId }}" type="text" class="form-control" disabled>
        <div class="input-group-append">
            <button id="open-choose-{{ $randomId }}" class="btn btn-success" type="button">
                {{ __('Choose :name', ['name' => $customText ?? Str::lower(Str::singular($label))]) }}
            </button>
        </div>
    </div>

    @error($name)
    <span class="error invalid-feedback" style="display: block;" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

@push('footer')
    <div class="modal fade" id="{{ $randomId }}Modal" tabindex="-1" role="dialog" aria-labelledby="{{ $randomId }}ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $randomId }}ModalLabel">{{ __('Choose :name', ['name' => $customText ?? $label]) }}</h5>
                </div>

                <div class="modal-body table-responsive">
                    {{--<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#chooseProductFilterModal{{ $randomId }}">--}}
                    {{--    {{ __('Filter') }}--}}
                    {{--</button>--}}

                    <div class="float-right mb-4">
                        <form id="search-form" onsubmit="search{{ $randomId }}(this); return false;">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input
                                    id="search-value-{{ $randomId }}"
                                    name="q"
                                    type="text"
                                    class="form-control float-right"
                                    placeholder="{{ __('Search') }}"
                                >

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    <a href="javascript:" style="display: none;" id="reset-search-{{ $randomId }}" class="btn btn-danger"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <table class="table table-bordered table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>
                                    @if (!isset($single))
                                        <input type="checkbox" id="{{ $randomId }}checkAll">
                                    @endif
                                </th>
                                <th>{{ __('Name') }}</th>
                            </tr>
                        </thead>
                        <tbody id="data-{{ $randomId }}"></tbody>
                    </table>

                    <div id="description-{{ $randomId }}" class="text-center text-muted">
                        {{ __('Loading...') }}
                    </div>

                    <nav class="float-right" id="paginate-{{ $randomId }}" style="display: none;">
                        <ul class="pagination">
                            <li class="page-item" id="previous-item-{{ $randomId }}">
                                <a class="page-link" id="previous-link-{{ $randomId }}" href="javascript:" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">{{ __('Previous') }}</span>
                                </a>
                            </li>

                            <li class="page-item" id="next-item-{{ $randomId }}">
                                <a class="page-link" id="next-link-{{ $randomId }}" href="javascript:" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">{{ __('Next') }}</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal{{ $randomId }}()">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary" onclick="{{ $callback ?? "saveSelected$randomId()" }}">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="selected-{{ $randomId }}"></div>

    <template id="{{ $randomId }}Template">
        <tr>
            <td style="width: 20px;">
                @if(!isset($single))
                    <input id="{{ $randomId }}-check-{id}" onchange="addToSelect{{ $randomId }}('{id}', '{title}')" type="checkbox" value="{id}" data-checked>
                @else
                    <input id="{{ $randomId }}-check-{id}" name="{{ $randomId }}-select" onchange="singleSelect{{ $randomId }}('{id}', '{title}')" type="radio" value="{id}" data-checked>
                @endif
            </td>

            <td><a href="javascript:" onclick="$('#{{ $randomId }}-check-{id}').trigger('click')">{show_name_full}</a></td>
            {{--<td>{price}</td>--}}
        </tr>
    </template>
@endpush

@push('footer')
    <div class="modal fade" id="chooseProductFilterModal{{ $randomId }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Filter') }}</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form role="form" id="choose-product-filter-form-{{ $randomId }}" class="modal-body">
                    @include('products.elements.filter-input')
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ __('Close') }}
                    </button>

                    <button type="button" class="btn btn-primary" onclick="chooseProductFilter{{ $randomId }}()">
                        {{ __('Filter') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        function getDataUrl{{ $randomId }}()
        {
            let dataUrl;

            @if (!empty($dataUrlFunction))
                dataUrl = {{ $dataUrlFunction }}();
            @else
                dataUrl = '{!! $dataUrl !!}';
            @endif

                return dataUrl;
        }

        $(document).on('show.bs.modal', '.modal', function () {
            let zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });

        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });

        function chooseProductFilter{{ $randomId }}() {
            loadData{{ $randomId }}(getDataUrl{{ $randomId }}(), $('#choose-product-filter-form-{{ $randomId }}').serialize());
        }

        function resetFilterForm{{ $randomId }}() {
            $('#choose-product-filter-form-{{ $randomId }}')[0].reset();
            $('#choose-product-filter-form-{{ $randomId }}').find('select').val('').trigger('change');
        }

        $('#{{ $randomId }}checkAll').change(function() {
            $('#data-{{ $randomId }} input').trigger( "click" );
        });

        $(document).ready(function() {
            $('#values-{{ $randomId }} li').each(function() {
                $(this).
                append(
                    '<a href="javascript:" class="text-muted ml-2" onclick="removeValue{{ $randomId }}(this)"><i class="fa fa-times"></i></a>');
            });

            $('#count-{{ $randomId }}').val($('#values-{{ $randomId }} li').length + ' {{ $customText ?? Str::lower($label) }}');
        });

        let modalEl{{ $randomId }} = $('#{{ $randomId }}Modal');

        modalEl{{ $randomId }}.modal({
            keyboard: false, backdrop: 'static', show: false,
        });

        $('#open-choose-{{ $randomId }}').on('click', function() {
            modalEl{{ $randomId }}.modal('show');
        });

        @if(!empty($openModal))
        function {{ $openModal }}(query) {
            $('body').prepend('<input type="hidden" id="choose-product-extend-query" value="' + query + '">');

            modalEl{{ $randomId }}.modal('show');
        }
        @endif

        modalEl{{ $randomId }}.on('show.bs.modal', function() {
            $('#values-{{ $randomId }} li').each(function() {
                let name = $(this).text();
                let id = $(this).find('input').val();

                $('#selected-{{ $randomId }}').
                append(
                    '<input class="selected-value-{{ $randomId }}" type="hidden" data-name="' + name + '" value="' +
                    id + '">');
            });

            loadData{{ $randomId }}(getDataUrl{{ $randomId }}());
        });

        modalEl{{ $randomId }}.on('hide.bs.modal', function() {
            $('#choose-product-extend-query').remove();
            resetFilterForm{{ $randomId }}();
        });

        $('#reset-search-{{ $randomId }}').on('click', function() {
            loadData{{ $randomId }}(getDataUrl{{ $randomId }}());
            $('#search-value-{{ $randomId }}').val('');
            $(this).hide();
        });

        function search{{ $randomId }}(form) {
            let dataUrl = getDataUrl{{ $randomId }}();

            if(dataUrl.indexOf("?") > 0){
                dataUrl += '&' + $(form).serialize();
            } else {
                dataUrl += '?' + $(form).serialize();
            }

            loadData{{ $randomId }}(dataUrl);

            $('#reset-search-{{ $randomId }}').show();

            return false;
        }

        function saveSelected{{ $randomId }}()
        {
            let listHtml = '';
            let count = 0;
            let el = $('#values-{{ $randomId }}');

            el.html('');

            @if (isset($required))
            if ($('.selected-value-{{ $randomId }}').length <= 0) {
                alert('{{ __('Please choose at least one product') }}');
                return false;
            }
            @endif

            $('.selected-value-{{ $randomId }}').each(function() {
                let id = $(this).val();
                let title = $(this).attr('data-name');

                listHtml += '<li>';
                listHtml += '<input type="hidden" name="{{ $name }}@if(!isset($single))[]@endif" value="' + id + '">' + title;
                listHtml += '<a href="javascript:" class="text-muted ml-2" onclick="removeValue{{ $randomId }}(this)"><i class="fa fa-times"></i></a>';
                listHtml += '</li>';
                count++;
            });

            el.append(listHtml);
            $('#selected-{{ $randomId }}').html('');
            $('#count-{{ $randomId }}').val(count + ' {{ $customText ?? Str::lower($label) }}');

            @if(!empty($afterSave))
                {{ $afterSave }}('{{ $randomId }}');
            @endif

            modalEl{{ $randomId }}.modal('hide');
        }

        function closeModal{{ $randomId }}()
        {
            $('#selected-{{ $randomId }}').html('');

            @if(!empty($afterClose))
                {{ $afterClose }}('{{ $randomId }}');
            @endif

            modalEl{{ $randomId }}.modal('hide');
        }

        function removeValue{{ $randomId }}(el)
        {
            $(el).parent().remove();
            $('#count-{{ $randomId }}').val($('#values-{{ $randomId }} li').length + ' {{ $customText ?? Str::lower($label) }}');
        }

        function addToSelect{{ $randomId }}(id, name, price)
        {
            let isExists = $('.selected-value-{{ $randomId }}[value=\'' + id + '\']');

            if (isExists.length > 0) {
                isExists.remove();
            } else {
                $('#selected-{{ $randomId }}').append('<input class="selected-value-{{ $randomId }}" type="hidden" data-name="' + name + '" value="' + id + '">');
            }
        }

        function singleSelect{{ $randomId }}(id, name, price)
        {
            let isExists = $('.selected-value-{{ $randomId }}');

            if (isExists.length > 0) {
                isExists.remove();
            }

            $('#selected-{{ $randomId }}').append('<input class="selected-value-{{ $randomId }}" type="hidden" data-name="' + name + ' - ' + price + '" value="' + id + '">');
        }

        function escapeHtml(unsafe) {
            //console.log(unsafe);
            return unsafe
                .replace("'", '')
                .replace("'", '')
                .replace('"', '')
                .replace('<', '')
                .replace('>', '');
        }

        function loadData{{ $randomId }}(url, query)
        {

            if (!url.includes('?')) {
                url += '?haha';
            }

            let selected = $('.selected-value-{{ $randomId }}').map(function() {return $(this).val();}).get();

            if ($('#choose-product-extend-query')) {
                url += '&' + $('#choose-product-extend-query').val();
            }

            url += '&orders=' + selected.join(',');

            if (query) {
                url += '&' + query;
            }

            // Reset
            $('#data-{{ $randomId }}').html('');
            $('#description-{{ $randomId }}').text('{{ __('Loading...') }}').show();
            $('#paginate-{{ $randomId }}').hide();
            $('#previous-link-{{ $randomId }}').removeAttr('onclick');
            $('#next-link-{{ $randomId }}').removeAttr('onclick');
            $('#previous-item-{{ $randomId }}').removeClass('disabled');
            $('#next-item-{{ $randomId }}').removeClass('disabled');
            $.get(url).done(function(data) {
                if (data.data.length > 0) {
                    $('#description-{{ $randomId }}').hide();

                    for (let i = 0; i < data.data.length; i++) {
                        var show_name_full = escapeHtml(data.data[i]['title']);
                        if(!data.data[i].parent_id){
                            show_name_full = '<strong style="color:red">' + escapeHtml(data.data[i]['title']) + '</strong>';
                        }

                        $('#data-{{ $randomId }}').append(
                            $('#{{ $randomId }}Template').html()
                                .replace(/{id}/g, data.data[i]['id'])
                                .replace(/{title}/g, escapeHtml(data.data[i]['title']))
                                .replace(/{show_name_full}/g, show_name_full)
                                //.replace(/{price}/g, formatter.format(data.data[i]['price']))
                                .replace(/data-checked/g, (selected.indexOf(data.data[i]['id'].toString()) !== -1 ? 'checked' : ''))
                        );


                        /*$('#data-{{ $randomId }}').
                         append('<tr><td style="width: 20px;"><input onchange="addToSelect{{ $randomId }}(' +
                         data.data[i]['id'] + ', \'' + data.data[i]['name'] + '\')" type="checkbox" value="' +
                         data.data[i]['id'] + '" ' +
                         (selected.indexOf(data.data[i]['id'].toString()) !== -1 ? 'checked' : '') +
                         '></td><td>' + data.data[i]['name'] + '</td><td>' +
                         formatter.format(data.data[i]['price']) + '</td></tr>');*/
                    }

                    // Pagination
                    if (data.prev_page_url || data.next_page_url) {
                        $('#paginate-{{ $randomId }}').show();
                    }

                    if (data.prev_page_url) {
                        $('#previous-link-{{ $randomId }}').
                        attr('onclick', 'loadData{{ $randomId }}(\'' + data.prev_page_url + '\')');
                    } else {
                        $('#previous-item-{{ $randomId }}').addClass('disabled');
                    }

                    if (data.next_page_url) {
                        $('#next-link-{{ $randomId }}').
                        attr('onclick', 'loadData{{ $randomId }}(\'' + data.next_page_url + '\')');
                    } else {
                        $('#next-item-{{ $randomId }}').addClass('disabled');
                    }
                } else {
                    $('#description-{{ $randomId }}').text('{{ __('Empty.') }}');
                }
            }).fail(function(error) {
                console.log(error);

                $('#description-{{ $randomId }}').
                text('{{ __('Error when loading data, close this modal and reopen to try again.') }}');
            });
        }
    </script>
@endpush
