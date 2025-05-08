@php 
$featured = [2=>'Không',1=>"Có"];
$experience = [2=>'Không',1=>"Có"];
@endphp 
<div class="card">
    <div class="box ">
        <div class="card-header">
            <div class="btn-group">
                <button class="btn btn-primary btn-sm" id="btn_filter">
                    <i class="fa fa-filter"></i>
                    <span>{{__('Filter')}}</span>
                </button>
            </div>
            <div class="card-tools">
                <button type="button" class="btn btn-info btn-sm" id="exportExcel" data-toggle="modal" data-target="#exportExcelModal">
                    {{ __('Export Excel') }}
                </button>
                <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i>
                    {{ __('Create') }}
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id ="filter-box">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('Title')}}</label>
                            <input name="title" value="{{ request('title') }}" class="form-control" placeholder="{{__('Title')}}">         
                        </div>
                        <div class="form-group">
                            <label>{{__('Category')}}</label>
                            <select
                                id="category_id"
                                name="category_id"
                                class="form-control select2bs4 @error('category_id') is-invalid @enderror"
                            >
                                <option value="">{{ __('Select') }}</option>
                                @include('partials.forms.category_options', ['selected' => request('category_id')])
                            </select>               
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{__('Created At')}}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input autocomplete="off" type="text" name="created_at" value="{{ request('created_at') }}" class="form-control float-right" id="reservation">
                            </div>
                        <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>{{__('Status')}}</label>
                            <select id="status" name="status" class="form-control">
                                <option
                                        value=""
                                >
                                    {{ __('All') }}
                                </option>
                                @foreach(\App\Models\Post::STATUS as $status => $label)
                                    <option
                                            value="{{ $status }}"
                                            @if ($status == request('status'))
                                                selected
                                            @endif
                                    >
                                        {{ __("post.status.$label") }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i> {{__('Apply')}} </button>
                <div class="btn btn-default btn-sm pull-left" id="btn_reset">
                    <a href="{{ url()->current() }}"><i class="fa fa-undo"> {{__('Reset')}}</i></a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '#exportExcel', function() {
        
        $('#filter-box').attr('action', "{{ route('posts.export') }}");
        $("#filter-box").submit();
        $('#filter-box').attr('action', "");
        
    });
</script>
@endpush



@include('partials.js.filter')
