<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Slug') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Sort') }}</th>
                <th width=100>{{ __('Action') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ( $tags as $tag)
            @php 
                $name = json_decode($tag->name);
                $slug = json_decode($tag->slug);
            @endphp 
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $name->vi }}</td>
                    <td>{{ $slug->vi }}</td>
                    <td>{{ $tag->type }}</td>
                    <td>{{ $tag->order_column }}</td>
                    <td>
                        <a href="javascript:" class="btn btn-danger btn-sm" onclick="deleteResource('{{ route('tags.destroy', ['tag' => $tag->id]) }}', '{{ route('tags.index') }}')">
                            {{ __('Delete') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if ($tags->hasPages())
    <div class="card-footer clearfix padding-bottom-0">
        <div class="pagination-sm m-0 float-right">
            {{ $tags->links() }}
        </div>
    </div>
@endif
@push('scripts')

@endpush
