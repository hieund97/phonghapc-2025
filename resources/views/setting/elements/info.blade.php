@foreach($options as $key=>$row)
    @if($row->option_tab == $view)
        @if($row->option_type=='checkbox')
            <div class="form-group clearfix">
                <div class="icheck-primary d-inline">
                    <input
                            type="checkbox"
                            name="{{$row->option_name}}"
                            value="1"
                            id="{{$row->option_name}}"
                            @if($row->option_value==1) checked @endif>
                    <label for="{{$row->option_name}}">{{__($row->option_name)}}</label>
                </div>
            </div>
        @elseif($row->option_type=='upload')
            <div class="image-box">
                <label for="exampleInputEmail1">{{__($row->option_name)}}</label>

                <div class="form-group">
                    <div class="preview-image-wrapper img-fluid">
                        <img
                                class="preview_image"
                                src="{{ (!empty($row->option_value) ? get_image_url($row->option_value, '') : '/preview-icon.png') }}"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <div>
                                                    <span class="input-group-btn">
                                                        <a
                                                                data-result="image" data-action="select-image"
                                                                class="btn_gallery btn btn-primary text-white"
                                                        >
                                                            <i class="fa fa-picture-o"></i> {{__('Choose')}}
                                                        </a>
                                                    </span>
                        <input
                                name="{{$row->option_name}}" type="hidden"
                                class="image-data form-control"
                                value="{{ (!empty($row->option_value) ? $row->option_value : '') }}"
                        >
                    </div>
                </div>
            </div>
        @else
            <div class="form-group">
                <label for="exampleInputEmail1">{{__($row->option_name)}}</label>
                @if($row->option_type=='textarea')
                    <textarea
                            name="{{$row->option_name}}"
                            class="form-control"
                            rows="5"
                            placeholder="Enter ..."
                    >{{$row->option_value}}</textarea>
                @elseif($row->option_type == 'dropdown')
                    @if($view != 'common')
                        <select
                                name="{{ $view }}_status"
                                class="form-control select2bs4 @error('status') is-invalid @enderror"
                                required
                        >
                            @if($view == 'info')
                                <option
                                        value="open"
                                        @if($row->option_value === "open") selected @endif>
                                    Mở cửa website
                                </option>
                                <option
                                        value="close"
                                        @if($row->option_value == "close") selected @endif>
                                    Website bảo trì
                                </option>
                            @endif
                            @if($view == 'popup')
                                <option
                                        value="on"
                                        @if($row->option_value == "on") selected @endif>
                                    Bật
                                </option>
                                <option
                                        value="off"
                                        @if($row->option_value == "off") selected @endif>
                                    Tắt
                                </option>
                            @endif
                        </select>
                    @else
                        <select
                            name="{{ $row->option_name }}"
                            class="form-control select2bs4 @error('status') is-invalid @enderror"
                            required
                        >
                            <option
                                    value="on"
                                    @if($row->option_value == "on") selected @endif>
                                Bật
                            </option>
                            <option
                                    value="off"
                                    @if($row->option_value == "off") selected @endif>
                                Tắt
                            </option>
                        </select>
                    @endif
                @else
                    <input
                            type="text"
                            name="{{$row->option_name}}"
                            value="{{$row->option_value}}"
                            class="form-control"
                            placeholder="{{__($row->option_name)}}"
                    >
                @endif
            </div>
        @endif
    @endif
@endforeach
@push('scripts')
    @include('partials.js.rv_media',['buttonMoreImages'=>[]])
    @include('partials.editors.summernote',['editors'=>['popup','info_hotline_footer_1'],'buttons'=>[],'realButtons'=>[]])
    @include('partials.editors.summernote',['editors'=>['popup','info_hotline_footer_2'],'buttons'=>[],'realButtons'=>[]])
    @include('partials.editors.summernote',['editors'=>['popup','title_2'],'buttons'=>[],'realButtons'=>[]])
@endpush
