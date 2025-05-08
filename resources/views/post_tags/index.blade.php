@extends('layouts.app')

@section('page-title', !empty($currentPostTag) ? __('Edit Post tag: :name', ['name' => $currentPostTag->title]) : __('Post tag'))

@section('content')
    <div class="row">
        @cannot('post_tags.update')
            @php $currentPostTag = null @endphp
        @endcannot

        @php
            $showForm = true;

            if (!request()->user()->can('post_tags.store')) {
                $showForm = false;
            }

            if (!empty($currentPostTag)) {
                $showForm = request()->user()->can('post_tags.update');
            }
        @endphp

        @if ($showForm)
            <div class="col-md">
                <form method="post" class="card card-primary card-outline card-outline-tabs" action="{{ !empty($currentPostTag) ? route('post_tags.update', ['post_tag' => $currentPostTag->id]) : route('post_tags.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($currentPostTag)) @method('PUT') @endif

                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="category-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="category-tabs-info-tab" data-toggle="pill" href="#category-tabs-info" role="tab" aria-controls="category-tabs-info" aria-selected="true">{{ __('Info') }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="category-tabs-content">
                            <div class="tab-pane fade show active" id="category-tabs-info" role="tabpanel" aria-labelledby="category-tabs-info-tab">
                                @include('post_tags.elements.info')
                            </div>
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="float-right">
                            @if (!empty($currentPostTag))
                                <a href="{{ route('post_tags.index') }}" class="btn btn-danger btn-sm">
                                    {{ __('Cancel') }}
                                </a>
                            @endif

                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        @include('post_tags.elements.list')
    </div>
@endsection

@push('scripts')
    <script>
        function expandCollapse(el)
        {
            var parent = $(el).parent();

            parent.collapse('show');

            if (parent.parent().hasClass('collapse')) {
                expandCollapse('#' + parent.attr('id'));
            }
        }

        expandCollapse('.cl-active');

        $('.expaned').on('click', function() {
            $('.fa', this).toggleClass('fa-chevron-right').toggleClass('fa-chevron-down');
        });

        $('.prevent-expand').on('click', function(e) {
            e.preventDefault();
            return false;
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4',
        });  
    </script>

    @include('partials.cards.delete')
@endpush
