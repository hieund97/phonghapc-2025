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
            <div class="card-tools d-flex align-content-between justify-content-center">
                <a href="#" class="btn btn-info btn-sm mr-2 d-none" id="exportExcel" onclick="onSubmitFormTextlink();">
                    {{ __('Export Excel') }}
                </a>
                <form method="post" action="{{route('text_links.export')}}" id="formExportExcel">
                    @csrf
                    <input type="hidden" name="link" value="{{!empty(request()->get('link'))?request()->get('link'):''}}">
                    <input type="hidden" name="text" value="{{!empty(request()->get('text'))?request()->get('text'):''}}">
                    <input type="hidden" name="type" value="{{!empty(request()->get('type'))?request()->get('type'):''}}">
                    <input type="hidden" name="model" value="{{!empty(request()->get('model'))?request()->get('model'):''}}">
                    <input type="hidden" name="model_id" value="{{!empty(request()->get('model_id'))?request()->get('model_id'):''}}">
                    <input type="hidden" name="created_at" value="{{!empty(request()->get('created_at'))?request()->get('created_at'):''}}">
                </form>
                <a href="{{ route('text_links.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i>
                    {{ __('Create') }}
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="filter-box">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('Link')}}</label>
                            <input name="link" value="{{ request('link') }}" class="form-control" placeholder="{{__('Link')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('Text')}}</label>
                            <input name="text" value="{{ request('text') }}" class="form-control" placeholder="{{__('Text')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('Type')}}</label>
                            <select id="type" name="type" class="form-control">
                                <option
                                    value=""
                                >
                                    {{ __('All') }}
                                </option>
                                @foreach(config('admin.textlink_type') as $type => $label)
                                    <option
                                        value="{{ $type }}"
                                        @if ($type == request('type'))
                                        selected
                                        @endif
                                    >
                                        {{ __($label) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @php
                        $model    = request('model');
                        $model_id = request('model_id');
                    @endphp
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('Page')}}</label>
                            <select id="model" name="model" class="form-control">
                                <option
                                    value=""
                                >
                                    {{ __('All') }}
                                </option>
                                @foreach(\App\Models\TextLink::MODEL as $label)
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__('Category')}}</label>
                            <select
                                id="model_id"
                                name="model_id"
                                class="form-control select2bs4"
                            >
                                <option value="">{{ __('Select') }}</option>
                                @if($model=='App\Models\ProductCategory')
                                    @include('partials.forms.product_category_options', ['selected' => $model_id])
                                @elseif($model=='App\Models\Category')
                                    @include('partials.forms.category_options', ['selected' => $model_id])
                                @endif
                            </select>
                        </div>

                    </div>
                    <div class="col-md-4">
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
@push('scripts')
    <script>
        function onSubmitFormTextlink(){
            $('#formExportExcel').submit();
        }
    </script>
@endpush
