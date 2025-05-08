@extends('layouts.app')

@section('page-title', __('List of posts'))

@section('content')
    <div class="row">
        <div class="col-md">

            @include('posts.search')

            <div class="card">

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th width="5%">{{ __('ID') }}</th>
                            <th width="20%">{{ __('Thumbnail') }}</th>
                            <th width="25%">{{ __('Info') }}</th>
                            <th class="text-nowrap" width="15%">{{ __('Sort') }}</th>
                            <th class="text-nowrap" width="15%">{{ __('Lượt xem') }}</th>
                            <th class="text-nowrap" width="10%">{{ __('Status') }}</th>
                            <th width="15%">{{ __('Created At') }}</th>
                            <th width="10%">{{ __('Action') }}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($posts as $row)
                            <tr>
                                <td class="text-nowrap">{{ $row->id }}</td>
                                <td class="text-nowrap">
                                    <img src="{{get_image_url($row->thumbnail)}}" style="height: 5rem;">
                                </td>
                                <td>
                                    <b>{{ $row->title }}</b>
                                    <br>
                                    @if(!empty($row->categories))
                                        {{__('Category')}}:
                                        @foreach ($row->categories as $item)
                                            @if($loop->index != 0)
                                                -
                                            @endif
                                            <span>{{ $item->title }}</span>
                                        @endforeach
                                        <br>
                                    @endif
                                    {{ __('Author') }}: {{ App\Models\User::find($row->author)->name ?? '' }}
                                    <br>

                                    Ngày tạo:
                                    <b>{{ $row->created_at }}</b>
                                    <br/>

                                    Ngày publish:
                                    <b>{{ $row->published_at ?? $row->created_at }}</b>
                                    <br/>


                                    <a
                                            target="_blank"
                                            href="{{ route('fe.post',["slug"=>$row->slug,'id'=>$row->id]) }}"
                                    > Link xem chi tiết
                                    </a>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input
                                                        style="max-width: 70px;"
                                                        type="text"
                                                        class="form-control quick-update"
                                                        value="{{ $row->sort }}"
                                                        data-type="sort"
                                                        data-id="{{ $row->id }}"
                                                        id="sort_{{ $row->id }}"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-nowrap">{{ $row->view_count }}</td>
                                <td class="text-nowrap">{{ __("post.status.".$postStatus[$row->status]) }}</td>
                                <td class="text-nowrap">{{ formatDateTimeShow($row->created_at) }}</td>
                                <td class="text-nowrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group clearfix margin-bottom-10">
                                                @can('posts.update')
                                                    <a
                                                            href="{{ route('posts.edit', ['post' => $row->id]) }}"
                                                            class="btn btn-warning btn-sm"
                                                    >
                                                        {{ __('Edit') }}
                                                    </a>
                                                @endcan
                                                @can('posts.destroy')
                                                    <a
                                                            href="javascript:"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="deleteResource('{{ route('posts.destroy', ['post' => $row->id]) }}', '{{ route('posts.index') }}')"
                                                    >
                                                        {{ __('Delete') }}
                                                    </a>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($posts->hasPages())
                    <div class="card-footer clearfix padding-bottom-0">
                        <div class="pagination-sm m-0 float-right">
                            {{ $posts->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('partials.cards.delete')
    <script>
        $(document).ready(function () {
            $('.quick-update').blur(function () {

                var type = $(this).data('type')
                var id = $(this).data('id')
                if (type == 'sort') {
                    var value = $(this).val()
                } else {
                    var value = $(this).is(':checked') ? 1 : 0
                }
                $.ajax({
                    url    : "{{route('posts.quick_update')}}",
                    type   : 'POST',
                    data   : ({
                        type : type,
                        value: value,
                        id   : id
                    }),
                    success: function (data) {
                        if (data.status == 1) {
                            Toast.fire({
                                type : 'success',
                                title: '{{__('Update data successfully.')}}'
                            })
                        } else {
                            Toast.fire({
                                type : 'error',
                                title: '{{__('Update error data.')}}'
                            })
                        }
                        removeOverlay()
                    }
                })
            })
        })
    </script>
@endpush
