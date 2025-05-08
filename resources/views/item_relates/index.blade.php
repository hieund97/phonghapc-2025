
@extends('layouts.app')

@section('page-title', __('Items_relates'))
@section('content')
<div class="row">
    <div class="col-md">
        @include('item_relates.search')
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Thumbnail')}}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Link') }}</th>
                            <th>{{ __('Sort') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($itemRelates as $row)
                            <tr>
                                <td>{{$row->id}}</td>



                                    <td class="text-nowrap"><img src="{{$row->image}}" style="height: 5rem;"></td>

                                <td>{{$row->title}}</td>
                                <td>{{$row->link}}</td>
                                <td>{{$row->sort}}</td>
                                <td>{{$row->created_at}}</td>
                                <td>
                                    @can('item_relates.update')
                                    <a href="{{ route('item_relates.edit', ['item_relate'=>$row->id,'model'=>$model,'model_id'=>$modelId]) }}" class="btn btn-warning btn-sm">
                                        {{ __('Edit') }}
                                    </a>
                                    @endcan
                                    @can('item_relates.destroy')
                                        <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('item_relates.destroy', ['item_relate' => $row->id]) }}', '{{ route('item_relates.index') }}')">
                                            {{ __('Delete') }}
                                        </a>
                                    @endcan
                                </td>

                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>
@endsection
@push('scripts')
    @include('partials.cards.delete')

@endpush
