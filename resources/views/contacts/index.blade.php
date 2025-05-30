@extends('layouts.app')

@section('page-title', __('List of contacts'))

@section('content')
    <div class="row">
        <div class="col-md">

            <div class="card">
                <div class="box ">
                    <div class="card-header">
                        <div class="card-tools">
                            <a href="{{ route('contacts.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                {{ __('Create') }}
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Info') }}</th>
                            <th class="text-nowrap">{{ __('Status') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($aryContact as $row)
                            <tr>
                                <td class="text-nowrap">{{ $row->id }}</td>
                                <td>
                                    <b>{{ $row->fullname  }}</b>
                                    <br>
                                    {{ $row->email }}
                                    <br>
                                    {{ $row->phone_number }}
                                </td>
                                <td class="text-nowrap">{{ __("contact.status.".$contactStatus[$row->status]) }}</td>
                                <td class="text-nowrap">{{ formatDateTimeShow($row->created_at) }}</td>
                                <td class="text-nowrap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group clearfix margin-bottom-10">
                                                @can('contacts.update')
                                                    <a
                                                            href="{{ route('contacts.edit', ['contact' => $row->id]) }}"
                                                            class="btn btn-warning btn-sm"
                                                    >
                                                        {{ __('Edit') }}
                                                    </a>
                                                @endcan
                                                @can('contacts.destroy')
                                                    <a
                                                            href="javascript:"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="deleteResource('{{ route('contacts.destroy', ['contact' => $row->id]) }}', '{{ route('contacts.index') }}')"
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
                @if ($aryContact->hasPages())
                    <div class="card-footer clearfix padding-bottom-0">
                        <div class="pagination-sm m-0 float-right">
                            {{ $aryContact->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('partials.cards.delete')
@endpush
