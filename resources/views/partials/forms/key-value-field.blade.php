@php
    $randomId = ($name ?? '') . time() . Str::random(3)
@endphp

<div class="form-group">
    <label>{{ $label }}</label>

    <ul id="list-values-{{ $randomId }}">
        @foreach($data as $index => $datum)
            <li>
                @php
                    $title = []
                @endphp

                @foreach($datum as $key => $value)
                    @php
                        $title[] = $value
                    @endphp

                    <input type="hidden" data-index="{{ $index }}" data-name="{{ $name }},{{ $key }}" name="{{ $name }}[{{ $index }}][{{ $key }}]" value="{{ $value }}">
                @endforeach

                {{ implode(' - ', $title) }}

                <a href="javascript:" class="text-muted" onclick="removeItem{{ $randomId }}(this)"><i class="fas fa-times fa-fw"></i></a>
            </li>
        @endforeach
    </ul>

    <div class="row">
        @foreach($keys as $key => $placeholder)
            <div class="col-md-5">
                <input type="text" class="form-control" id="input-{{ $key }}-{{ $randomId }}" placeholder="{{ $placeholder }}">
            </div>
        @endforeach

        <div class="col-md-2">
            <button type="button" id="add-item-{{ $randomId }}" class="btn btn-success">
                {{ __('Add') }}
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $.pluck = function (arr, key) {
            return $.map(arr, function (e) {
                return e[key];
            })
        }

        let keys = @json(collect($keys)->keys())

        $('#add-item-{{ $randomId }}').click(function () {
            let title = [];
            let content = '';
            let increment = $('#list-values-{{ $randomId }}').find('input[data-index]').map((index, item) => parseInt($(item).data('index'))).sort((a, b) => b - a)[0];

            if (typeof increment != 'number') {
                increment = 0;
            } else {
                increment++;
            }

            $.each(keys, function (index, key) {
                title.push($('#input-' + key + '-{{ $randomId }}').val());
                content += '<input type="hidden" data-index="' + increment + '" data-name="{{ $name }},' + key + '" name="{{ $name }}[' + increment + '][' + key + ']" value="' + $('#input-' + key + '-{{ $randomId }}').val() + '">';

                $('#input-' + key + '-{{ $randomId }}').val('');
            });

            let removeBtn = '<a href="javascript:" class="text-muted" onclick="removeItem{{ $randomId }}(this)"><i class="fas fa-times fa-fw"></i></a>';

            $('#list-values-{{ $randomId }}').append('<li>' + content + title.join(' - ') + removeBtn + '</li>')
        });

        function removeItem{{ $randomId }}(el) {
            $(el).parent().remove();
        }
    </script>
@endpush
