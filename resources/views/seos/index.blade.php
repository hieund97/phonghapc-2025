@extends('layouts.app')

@section('page-title', __('List of seos'))

@section('content')
<div class="row">
        <div class="col-md">

            @include('seos.search')

            <div class="card">

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('Thumbnail') }}</th>
                                <th>{{ __('Info') }}</th>
                                <th>{{ __('Meta Description') }}</th>
                                <th>{{ __('Updated At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($seos as $row)
                                <tr>
                                    <td class="text-nowrap"> @if($row->image) <img src="{{$row->image}}" style="max-width: 168px;max-height: 41px;"> @endif</td>
                                    <td class="text-nowrap">
                                        <strong> {{ __('Page') }} : </strong> {{ __($row->model) }}<br>
                                        <strong> {{ __(ucfirst($name)) }} : </strong> {{ (!empty($row->$with) && !empty($row->$with->$name))?$row->$with->$name:''}}<br>
                                        <strong> {{ __('Meta Title') }} : </strong>{{$row->title }}<br>
                                        <strong> {{ __('Meta Keyword') }} : </strong>{{ $row->keyword }}<br>
                                        <strong> {{ __('Meta Canonical') }} : </strong>{{ $row->canonical }}<br>
                                        @foreach(config('admin.robots_meta') as $key => $value)
                                            <strong> {{ __($value) }} : </strong>{{ $row->$key }}<br>
                                        @endforeach
                                    </td>

                                    <td>{{ $row->description }}</td>
                                    <td>{{ formatDateTimeShow($row->updated_at) }}</td>
                                    <td class="text-nowrap">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group clearfix margin-bottom-10">
                                                    @can('seos.update')
                                                        <a href="{{ route('seos.edit', ['seo' => $row->id]) }}" class="btn btn-warning btn-sm">
                                                            {{ __('Edit') }}
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

                @if ($seos->hasPages())
                    <div class="card-footer clearfix padding-bottom-0" >
                        <div class="pagination-sm m-0 float-right">
                            {{ $seos->appends(request()->query())->links() }}
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
                    url: "{{route('seos.quick_update')}}",
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
