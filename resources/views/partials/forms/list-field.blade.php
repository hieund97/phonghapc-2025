@php
    $randomId = ($name ?? '').time().Str::random(3)
@endphp

<div class="form-group">
    <label>{{ $label }}</label>

    <ul id="list-values-{{ $randomId }}">
        @if (!empty($data))
            @foreach($data as $datum)
                <li>
                    <input type="hidden" name="{{ $name }}[]" value="{{ $datum }}">
                    {{ $datum }}
                    <a href="javascript:" class="text-muted ml-2" onclick="removeValue{{ $randomId }}(this)">
                        <i class="fa fa-times"></i>
                    </a>
                </li>
            @endforeach
        @endif
    </ul>

    <div class="input-group mb-3">
        <input id="input-value-{{ $randomId }}" type="text" class="form-control" placeholder="{{ $placeHolder ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn-success" type="button" onclick="addValue{{ $randomId }}()">
                {{ __('Add') }}
            </button>

            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#quickFillModal{{ $randomId }}">
                <i class="fas fa-bolt fa-fw"></i>
            </button>
        </div>
    </div>

    <div id="error-input-{{ $randomId }}"></div>

    @if (!empty($helpText))
        <small class="form-text text-muted">
            {{ $helpText }}
        </small>
    @endif

    @error($name)
    <span class="error invalid-feedback" style="display: block;" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

@push('footer')
    <div class="modal fade" id="quickFillModal{{ $randomId }}" tabindex="-1" role="dialog" aria-labelledby="quickFillModal{{ $randomId }}Title" aria-hidden="true">
        <form id="quickFillForm{{ $randomId }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quickFillModal{{ $randomId }}Title">{{ __('Quick Fill') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="quickFillInput{{ $randomId }}"></label>
                            <textarea id="quickFillInput{{ $randomId }}" name="quickFillInput{{ $randomId }}" class="form-control" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endpush

@push('scripts')
    <script>
        $('#quickFillModal{{ $randomId }}').on('hidden.bs.modal', function () {
            $('#quickFillInput{{ $randomId }}').val('');
        });

        $('#quickFillForm{{ $randomId }}').submit(function (e) {
            e.preventDefault();

            $('#quickFillInput{{ $randomId }}').val().split(/\r?\n/).filter(item => /\S/.test(item)).map(function (item) {
                $('#input-value-{{ $randomId }}').val(item);
                addValue{{ $randomId }}();
                $('#quickFillModal{{ $randomId }}').modal('hide');
            });
        });

        function addValue{{ $randomId }}() {
            let el = $('#input-value-{{ $randomId }}');
            let error = $('#error-input-{{ $randomId }}');
            let html = '';
            let value = el.val();
            let data = $('input[name="{{ $name }}[]"]').map(function () {
                return $(this).val();
            }).get();

            // init 
            error.html('');
            el.removeClass('is-invalid');

            // Validation
            if (!value || value === '' || value === null) {
                error.html('<span class="error invalid-feedback" style="display: block;" role="alert"><strong>{{ __('This field is required.') }}</strong></span>');
                el.addClass('is-invalid');
                return false;
            }

            if (data.indexOf(value) !== -1) {
                error.html('<span class="error invalid-feedback" style="display: block;" role="alert"><strong>{{ __('This value has already been taken.') }}</strong></span>');
                el.addClass('is-invalid');
                return false;
            }

            @if (!empty($validateFunction))
            if (!{{ $validateFunction }}(value)) {
                return false;
            }
            @endif

                html += '<li>';
            html += '<input type="hidden" name="{{ $name }}[]" value="' + value + '">';
            html += value;
            html += '<a href="javascript:" class="text-muted ml-2" onclick="removeValue{{ $randomId }}(this)"><i class="fa fa-times"></i></a>';
            html += '</li>';

            $('#list-values-{{ $randomId }}').append(html);
            el.val('');
        }

        function removeValue{{ $randomId }}(el) {
            $(el).parent().remove();
        }
    </script>
@endpush
