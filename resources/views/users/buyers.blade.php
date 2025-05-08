@extends('layouts.app')

@section('page-title', __('List of users'))

@section('content')
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('List of users') }}</h3>

                    <div class="card-tools">
                        @include('partials.cards.search')
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Orders Count') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ number_format($user->orders->count()) }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        @can('users.update')
                                            <a href="{{ route('users.edit', ['user' => $user->id, 'route_name' => 'buyers']) }}" class="btn btn-warning btn-sm">
                                                {{ __('Edit') }}
                                            </a>
                                        @endcan

                                        @can('users.destroy')
                                            <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('users.destroy', ['user' => $user->id]) }}', '{{ route('users.index') }}')">
                                                {{ __('Delete') }}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>

                                @if ($user->socials->isNotEmpty())
                                    <tr>
                                        <td></td>
                                        @foreach($user->socials as $social)
                                            <td>
                                                <div>
                                                    <span class="text-md text-bold">{{ ucfirst($social->provider) }}</span>
                                                    <ul>
                                                        <li>
                                                            - {{ __('ID') }}: <b>{{ $social->provider_id }}</b>
                                                            @if ($social->provider == 'facebook')
                                                                <a href="{{ url('https://facebook.com/' . $social->provider_id) }}" target="_blank">
                                                                    <i class="fas fa-fw fa-external-link-alt"></i>
                                                                </a>
                                                            @endif
                                                        </li>

                                                        <li>
                                                            - {{ __('Name') }}: <b>{{ $social->name }}</b>
                                                            <img src="{{ $social->avatar }}" style="width: 30px; height: 30px; border-radius: 50%;" alt="">
                                                        </li>

                                                        <li>- {{ __('Email') }}: <b>{{ $social->email }}</b></li>
                                                        <li>- {{ __('Nickname') }}: <b>{{ $social->nickname }}</b></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        @endforeach

                                        @for ($i = 0; $i < (5 - $user->socials->count()); $i++)
                                           <td></td>
                                        @endfor
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="card-footer clearfix padding-bottom-0">
                        <div class="pagination-sm m-0 float-right">
                            {{ $users->appends(['q' => request('q')])->links() }}
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
