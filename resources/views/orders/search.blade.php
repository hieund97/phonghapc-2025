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
                <a href="{{ route('orders.create') }}" class="btn btn-success btn-sm">
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('ID')}}</label>
                            <input name="id" value="{{ request('id') }}" class="form-control" placeholder="{{__('ID')}}">         
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('Customer Name')}}</label>
                            <input name="customer_name" value="{{ request('customer_name') }}" class="form-control" placeholder="{{__('Customer Name')}}">         
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('Status')}}</label>
                            <select id="status" name="status" class="form-control">
                                    <option
                                        value=""
                                    >
                                        {{ __('All') }}
                                    </option>
                                @foreach($orderStatus as $key=>$row)
                                    <option
                                        value="{{ $key }}"
                                        @if ($key == request('status'))
                                        selected
                                        @endif
                                    >
                                        {{ __($row) }}
                                    </option>
                                @endforeach
                            </select>         
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
                                <input type="text" name="created_at" value="{{ request('created_at') }}" class="form-control float-right" id="reservation">
                            </div>
                        <!-- /.input group -->
                        </div> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="order_id">Mã đơn hàng</label>
                            <input id="order_id" class="form-control" type="text" name="order_id" value="{{ request('order_Id') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="provider_order_id">Mã giao dịch</label>
                            <input id="provider_order_id" class="form-control" type="text" name="provider_order_id" value="{{ request('provider_order_id') }}">
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
