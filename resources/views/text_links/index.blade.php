@extends('layouts.app')

@section('page-title', __('List of text links'))

@section('content')
<div class="row">
        <div class="col-md">

            @include('text_links.search')

            <div class="card">

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Thumbnail') }}</th>
                                <th>{{ __('Info') }}</th>
                                <th>{{ __('Link') }}</th>
                                <th>{{ __('Text') }}</th>
                                <th>{{ __('Sort') }}</th>  
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($textLinks as $row)
                                <tr>
                                    <td class="text-nowrap">{{ $row->id }}</td>
                                    <td class="text-nowrap"> @if($row->thumbnail) <img src="{{$row->thumbnail}}" style="max-width: 168px;max-height: 41px;"> @endif</td>
                                    <td class="text-nowrap">
                                        <strong> {{ __('Type') }} : </strong> {{ __(config('admin.textlink_type')[$row->type]) }}<br>
                                        <strong> {{ __('Page') }} : </strong> {{ __($row->model) }}<br>
                                        <strong> {{__('Category')}} : </strong>
                                            @if($row->model=='App\Models\ProductCategory')
                                            {{ (!empty($row->productCategory->title))?$row->productCategory->title :'' }}
                                            @elseif($row->model=='App\Models\Category')
                                            {{ (!empty($row->category->title))?$row->category->title :'' }}
                                            @elseif($row->model=='App\Models\ProductTag')
                                            {{ (!empty($row->productTag->title))?$row->productTag->title :'' }}
                                            @elseif($row->model=='App\Models\PostTag')
                                            {{ (!empty($row->postTag->title))?$row->postTag->title :'' }}
                                            @endif
                                    </td>
                                    <td>{{ $row->link }}</td>
                                    <td class="text-nowrap">{{ $row->text }}</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input
                                                    style="max-width: 70px;min-width: 40px;"
                                                    type="text"
                                                    class="form-control quick-update"
                                                    value="{{ $row->sort }}"
                                                    data-type="sort"
                                                    data-id="{{ $row->id }}" 
                                                    id="sort_{{ $row->id }}"          
                                                />
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-nowrap">{{ formatDateTimeShow($row->created_at) }}</td>
                                    <td class="text-nowrap">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group clearfix margin-bottom-10">
                                                    @can('text_links.update')
                                                        <a href="{{ route('text_links.edit', ['text_link' => $row->id]) }}" class="btn btn-warning btn-sm">
                                                            {{ __('Edit') }}
                                                        </a>
                                                    @endcan
                                                    @can('text_links.destroy')
                                                        <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('text_links.destroy', ['text_link' => $row->id]) }}', '{{ route('text_links.index') }}')">
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

                @if ($textLinks->hasPages())
                    <div class="card-footer clearfix padding-bottom-0" >
                        <div class="pagination-sm m-0 float-right">
                            {{ $textLinks->appends(request()->query())->links() }}
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
        $( document ).ready(function() {
            $('.quick-update').blur(function(){

                var  type            = $(this).data('type');
                var  id              = $(this).data('id');
                if (type == 'sort') {
                    var value = $(this).val();
                } else {
                    var value = $(this).is(':checked') ? 1 : 0;
                }
                $.ajax({
                    url: "{{route('text_links.quick_update')}}",
                    type: "POST",
                    data:({
                        type:type,
                        value:value,
                        id:id
                    }),
                    success: function(data){
                        if(data.status == 1) {
                            Toast.fire({
                                type: 'success',
                                title: '{{__('Update data successfully.')}}'
                            });
                        }
                        else {
                            Toast.fire({
                                type: 'error',
                                title: '{{__('Update error data.')}}'
                            });
                        }
                        removeOverlay();
                    }
                });
            });
        });
    </script>
@endpush
