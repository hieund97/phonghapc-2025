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
                <a href="{{ route('reviews.create') }}" class="btn btn-success btn-sm">
                    {{ __('Add') }}
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
                            <label>{{__('Content')}}</label>
                            <input name="body" value="{{ request('body') }}" class="form-control" placeholder="{{__('Content')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('Status')}}</label>
                            <select
                                id="approved"
                                name="approved"
                                class="form-control select2bs4 @error('approved') is-invalid @enderror"
                            >
                                <option value="">{{ __('All') }}</option>
                                <option value="true">{{ __('Approved') }}</option>
                                <option value="false">{{ __('Disapproved') }}</option>
                                
                            </select>               
                        </div>   
                            
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('Created At')}}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="created_at" value="{{ request('created_at') }}" class="form-control float-right" id="reservation">
                            </div>
                        <!-- /.input group -->
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

@include('partials.js.filter')
