@extends('layouts.app')

@section('page-title', __('List of pages'))

@section('content')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    @can('pages.store')
                        <div class="card-tools">
                            <a href="{{ route('pages.create') }}" class="btn btn-sm btn-success">
                                <i class="fas fa-fw fa-plus"></i> {{ __('Add') }}
                            </a>
                        </div>
                    @endcan
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap text-center">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Content') }}</th>
                                <th>{{ __('Link') }}</th>
                                <th>{{ __('Updated At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td>{{ $page->id }}</td>
                                    <td>{{ $page->title }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" onclick="showPreview({{ $page->id }})">
                                            {{ __('Preview') }}
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{ route("fe.page.show",['slug'=>$page->slug,'id'=>$page->id])}}" target="_blank" title="{{ $page->slug }}">
                                            {{ Str::limit($page->slug, 30) }}
                                            <i class="fas fa-fw fa-external-link-alt"></i> </a>
                                    </td>
                                    <td>{{ formatDateTimeShow($page->updated_at) }}</td>
                                    <td>
                                        @can('pages.update')
                                            <a href="{{ route('pages.edit', ['page' => $page->id]) }}" class="btn btn-warning btn-sm">
                                                {{ __('Edit') }}
                                            </a>
                                        @endcan

                                        @can('pages.destroy')
                                            <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('pages.destroy', ['page' => $page->id]) }}', '{{ route('pages.index') }}')">
                                                {{ __('Delete') }}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($pages->hasPages())
                    <div class="card-footer clearfix padding-bottom-0">
                        <div class="pagination-sm m-0 float-right">
                            {{ $pages->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <div class="modal fade" id="previewContentModal" tabindex="-1" role="dialog" aria-labelledby="previewContentModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewContentModalTitle">
                        {{ __('Preview') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="preview-content">
                    <div class="text-center text-bold">
                        Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    @include('partials.cards.delete')

    <script>
        $('#previewContentModal').on('hide.bs.modal', function () {
            $('#preview-content').html('<div class="text-center text-bold">Loading...</div>');
        });

        function showPreview(id) {
            $('#previewContentModal').modal('show');

            $.get('{{ route('pages.index') }}/' + id + '/preview').then(function (response) {
                $('#preview-content').html(response);
            }).catch(function (error) {
                console.log(error);
                $('#preview-content')
                    .html('Có lỗi xảy ra, vui lòng copy đoạn mã sau và gửi cho kỹ thuật!<br /><textarea class="form-control" rows="10">' + JSON.stringify(error) + '</textarea>');
            });
        }
    </script>
@endpush
