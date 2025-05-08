@extends('layouts.app')

@section('page-title', __('List of Navigation'))

@section('content')
<div class="row">
    <div class="col-md">

        @include('navigations.search')

        <div class="card">

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr style="text-align: center">
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{__('Group')}}</th>
                            <th>{{ __('Display') }}</th>
                            <th>{{ __('Sort') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($navigations as $navigation)
                        <tr style="text-align: center">
                            <td>{{ $navigation->id }}</td>
                            <td><a href="{{ $navigation->link }}">{{ $navigation->name }}</a></td>
                            <td>{{ __($navigation->group) }}</td>
                            <td>
                                {{ $navigation->display_in }}
                            </td>
                            <td style="width:50px;">
                                <input onchange="updateNav('{{ $navigation->id }}',this.value)" id="navigation" name="navigation"
                                class="form-control input-number text-center" value="{{ $navigation->order }}">
                            </td>
                            <td>
                                @can('navigations.update')
                                <a href="{{ route('navigations.edit', ['navigation' => $navigation->id]) }}"
                                    class="btn btn-warning btn-sm">
                                    {{ __('Edit') }}
                                </a>
                                @endcan
                                @can('navigations.destroy')
                                <a href="javascript:" class="btn btn-danger btn-sm"
                                    onclick="deleteResource('{{ route('navigations.destroy', ['navigation' => $navigation->id]) }}', '{{ route('navigations.index') }}')">
                                    {{ __('Delete') }}
                                </a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($navigations->hasPages())
                <div class="card-footer clearfix padding-bottom-0">
                    <div class="pagination-sm m-0 float-right">
                        {{ $navigations->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('partials.cards.delete')
<script>
    function updateNav(id,navigation)
    {
        $.post("/navigations/update/"+id+"/"+navigation,
           function (data)
           {
               if(data == "success")
               {
                   location.reload();
               }
               else
               {
                   alert("Cập nhật thất bại");
               }
           }
        )
    }
</script>
@endpush
