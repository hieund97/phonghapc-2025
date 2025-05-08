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
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id ="filter-box">
            <div class="card-body">
                <div class="row">      
                    @php 
                        $model    = request('model');
                        $model_id = request('model_id');
                    @endphp
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('Page')}}</label>
                            <select id="model" name="model" class="form-control">
                                @foreach(\App\Models\Seo::MODEL as $label)
                                    <option
                                        value="{{ $label }}"
                                        @if ($label == $model)
                                        selected
                                        @endif
                                    >
                                        {{ __($label) }}
                                    </option>
                                @endforeach
                            </select>         
                        </div>   
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('ID')}}</label>
                            <input name="id" value="{{ request('id') }}" class="form-control" placeholder="{{__('ID')}}">         
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('Title')}}</label>
                            <input name="title" value="{{ request('title') }}" class="form-control" placeholder="{{__('Title')}}">         
                        </div>
                    </div>
                    <div class="col-md-3">
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
@include('text_links.js')
