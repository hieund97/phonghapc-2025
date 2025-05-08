@extends('layouts.app')
@section('page-title', ('List banner'))
@section('content')


    @include('banners.forms.order', ['toggleBtn' => '#order-btn'])
    @include('banners.filter', ['toggleBtn' => '#filter-btn'])

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
               
                <a href="{{ route('banners.create') }}" class="btn btn-success btn-sm">
                    {{ __('Add') }}
                </a>

                <button id="filter-btn" class="btn btn-primary btn-sm">
                    {{ __('Filter') }}
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Reference') }}</th>
                        <th>{{ __('Quantity of banners') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($references as $item)
                        <tr>
                            <td>{{ __($item->model) }}</td>
                            <td><b>{{ __($item->reference->title ?? 'Home') }}</b></td>
                            <td>{{ number_format($item->quantity) }}</td>
                            <td>
                                <a href="{{ route('banners.create', ['type' => $item->model, 'id' => $item->model_id]) }}" class="btn btn-warning btn-sm">
                                    {{ __('Edit') }}
                                </a>

                                <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('banners.delete_model', ['model' => $item->model, 'model_id' => $item->model_id]) }}', '{{ route('banners.index') }}')">
                                    {{ __('Delete') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($references->hasPages())
            <div class="card-footer clearfix padding-bottom-0">
                <div class="pagination-sm m-0 float-right">
                    {{ $references->appends(['q' => request('q')])->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

@push('footer')
    @include('media::partials.media')
@endpush

@push('styles')
    <style>
        .banner-dp {
            text-align: center;
        }

        .banner-dp img {
            max-width: 100%;
        }
    </style>
@endpush

@push('scripts')
    @include('partials.cards.delete')

    <script>
        $('input[data-bootstrap-switch]').each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

        $('#toggle_home_banner').on('switchChange.bootstrapSwitch', function(e, state) {
            $('#home_banner_loading').show();

            updateHomeBanner({status: (state ? 1 : 0)})
        });

        $('.btn_gallery').rvMedia({
            onSelectFiles: function(files, element) {

                $('#home_banner_loading').show();

                updateHomeBanner({type: element.data('type'), image: files[0].full_url}, function() {
                    $('#banner-' + element.data('type')).attr('src', files[0].full_url);
                })
            },
        });

        $('.btn_edit_home_banner_link').click(function() {
            let el = $(this);
            let link = prompt('{{ __('Enter link for banner') }}', el.data('current'));

            if (link != null) {
                updateHomeBanner({type: el.data('type'), link: link}, function() {
                    el.data('current', link);
                });
            }
        });
    </script>
@endpush
