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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('User')}}</label>
                            <select  name="user" class="form-control select21">
                                    <option
                                        value=""
                                    >
                                        {{ __('All') }}
                                    </option>
                                @foreach($users as $row)
                                    <option
                                        value="{{ $row->id }}"
                                        @if ($row->id == request('user'))
                                        selected
                                        @endif
                                    >
                                        {{ __($row->name) }}
                                    </option>
                                @endforeach
                            </select>      
                        </div>
                        <div class="form-group">
                            <label>{{__('Ip')}}</label>
                            <input name="ip" value="{{ request('ip') }}" class="form-control" placeholder="{{__('IP')}}">         
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('Method')}}</label>
                            <select id="method" name="method" class="form-control">
                                    <option
                                        value=""
                                    >
                                        {{ __('All') }}
                                    </option>
                                @foreach($methods as $row)
                                    <option
                                        value="{{ $row }}"
                                        @if ($row == request('method'))
                                        selected
                                        @endif
                                    >
                                        {{ __($row) }}
                                    </option>
                                @endforeach
                            </select>       
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
                                <input type="text" name="created_at" value="{{ request('created_at') }}" class="form-control float-right" id="reservation">
                            </div>
                        <!-- /.input group -->
                        </div>      
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('Path')}}</label>
                            <input name="path" value="{{ request('path') }}" class="form-control" placeholder="{{__('Path')}}">         
                        </div>        
                    </div>
                </div>
            </div>
        <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i> {{__('Search')}} </button>
                <div class="btn btn-default btn-sm pull-left" id="btn_reset">
                    <a href="{{ url()->current() }}"><i class="fa fa-undo"> {{__('Reset')}}</i></a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')

    <script>
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2').select2();

            // Id filter
            var element = '#filter-box';
            // Ẩn hiện form tìm kiếm
            $("#btn_filter").click(function(){          
                if($(element).is(":hidden")){
                    $(element).show();
                } else {
                    $(element).hide();
                }      
            });
            $("#btn_reset").click(function(){   
            });
            //Chọn ngày tháng
            $('#reservation').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
            // Check rquest empty
            @if(count($requestAll) > 0)
                $(element).show();
            @else
                $(element).hide();
            @endif
        });
    </script>
@endpush