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

                <a href="{{ route('item_relates.create',['model'=>$model,'model_id'=>$modelId]) }}" class="btn btn-success btn-sm">
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('Author')}}</label>
                            <input autocomplete="off" name="author" value="{{ request('author') }}" class="form-control" placeholder="{{__('Author')}}">         
                        </div>
                        <!-- Date range -->
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
                    </div>
                    <div class="col-md-4">
                       
                        
                        <div class="form-group">
                            <label>{{__('Is featured?')}}</label>
                            <select id="is_featured" name="is_featured" class="form-control">
                                    <option
                                        value=""
                                    >
                                        {{ __('All') }}
                                    </option>
                                @foreach($featured as $key=>$row)
                                    <option
                                        value="{{ $key }}"
                                        @if ($key == request('is_featured'))
                                        selected
                                        @endif
                                    >
                                        {{ $row }}
                                    </option>
                                @endforeach
                            </select>         
                        </div> 
                        
                        <div class="form-group">
                            <label>{{__('Is Experience?')}}</label>
                            <select id="is_experience" name="is_experience" class="form-control">
                                    <option
                                        value=""
                                    >
                                        {{ __('All') }}
                                    </option>
                                @foreach($experience as $key=>$row)
                                    <option
                                        value="{{ $key }}"
                                        @if ($key == request('is_experience'))
                                        selected
                                        @endif
                                    >
                                        {{ $row }}
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
