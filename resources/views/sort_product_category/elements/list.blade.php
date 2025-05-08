<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        @if($flag == 2)
            <tr>
                <th width="5%">{{ __('STT') }}</th>
                <th width="20%">{{ __('Info') }}</th>
                <th width="5%" class="text-nowrap">{{ __('Sort') }}</th>
                <th width="70%"></th>
            </tr>
        @else
            <tr>
                <th width="20%">{{ __('STT') }}</th>
                <th width="40%">{{ __('Info') }}</th>
                <th width="40%" class="text-nowrap">{{ __('Sort') }}</th>
            </tr>
        @endif

        </thead>
        <tbody>
        @foreach($categories as $category)
            @php
                switch ($flag) {
                    case 1:
                        $order = $category->ordering_menu_top;
                        break;
                    case 2:
                        $order = $category->ordering_menu_home;
                        break;
                    case 3:
                        $order = $category->ordering_menu_build;
                        break;
                }
            @endphp
            <tr>
                <td>{{ $loop->index + 1}}</td>
                <td style="white-space: normal;">
                    <b>{{ $category->title }}</b>
                </td>
                <td>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input
                                        style="max-width: 70px;"
                                        type="text"
                                        class="form-control quick-update"
                                        value="{{ $order }}"
                                        data-type="{{ $flag }}"
                                        data-id="{{ $category->id }}"
                                        id="sort_{{ $category->id }}"
                                />
                            </div>
                        </div>
                    </div>
                </td>
                @if($flag == 2)
                    <td>
                        <a class="btn btn-primary show-product-btn" data-toggle="collapse" data-id="{{ $category->id }}"
                           href="#category-{{ $category->id }}" role="button"
                           aria-expanded="false" aria-controls="collapseExample">{{ __('Products') }}</a>
                        <div class="collapse" id="category-{{ $category->id }}"></div>
                        <div style="text-align:center">
                            <button type="button" class="btn-primary hidden btn btn-show-more"
                                    id="btn-show-more-{{ $category->id }}"
                                    data-id="{{ $category->id }}">Xem thêm
                            </button>
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
