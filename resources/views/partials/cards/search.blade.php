<form id="search-form" method="get">
    <div class="input-group input-group-sm my-0" style="width: {{ $width ?? '150px' }};">
        <input
            id="search-value"
            type="text"
            name="q"
            class="form-control float-right"
            placeholder="{{ __('Search') }}"
            value="{{ request('q') }}"
        >

        <div class="input-group-append">
            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>

            @if (!empty(request('q')))
                <a href="{{ url()->current() }}" class="btn btn-danger"><i class="fas fa-times"></i></a>
            @endif
        </div>
    </div>
</form>
