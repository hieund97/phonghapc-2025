@php
    $isCheckShow = 0;
    if(!empty($is_show) && $is_show==1){
        $isCheckShow = 1;
    }
@endphp
<div class="card card-default @if(count($errors) == 0 && $isCheckShow!=1) collapsed-card @endif">
    <div class="card-header">
        <h3 class="card-title">{{__('SEO')}}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="meta_title">{{ __('Meta Title') }}</label>
                    <input
                        type="text"
                        class="form-control @error('seo.title') is-invalid @enderror"
                        name="seo[title]" id="meta_title"
                        value="{{ old('seo.title') ?: (!empty($model->seo) ? $model->seo->title : null) }}"
                    >
                    @error('seo.title')
                    <span
                        class="error invalid-feedback" style="display: block"
                        role="alert"
                    >
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="seo_description">{{ __('Meta Description') }}</label>
                    <textarea
                        name="seo[description]"
                        id="seo_description"
                        class="form-control @error('seo.description') is-invalid @enderror"
                        rows="5"
                    >{{ old('seo.description') ?: (!empty($model->seo) ? $model->seo->description : null) }}</textarea>

                    @error('seo.description')
                    <span class="error invalid-feedback" style="display: block" role="alert">
                        <strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="seo_keyword">{{ __('Meta Keyword') }}</label>
                    <input
                        type="text"
                        class="form-control @error('seo.keyword') is-invalid @enderror"
                        name="seo[keyword]"
                        id="seo_keyword"
                        value="{{ old('seo.keyword') ?: (!empty($model->seo) ? $model->seo->keyword : null) }}"
                    >
                    @error('seo.keyword')
                    <span class="error invalid-feedback" style="display: block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="seo_canonical">{{ __('Meta Canonical') }}</label>
                    <input
                        type="text"
                        class="form-control @error('seo.canonical') is-invalid @enderror"
                        name="seo[canonical]"
                        id="seo_canonical"
                        value="{{ old('seo.canonical') ?: (!empty($model->seo) ? $model->seo->canonical : null) }}"
                    >
                    @error('seo.canonical')
                    <span class="error invalid-feedback" style="display: block" role="alert">
                        <strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group image-box">
                    <label for="meta_image">{{ __('Meta Image') }}</label>

                    <div class="form-group">
                        <div class="preview-image-wrapper img-fluid">
                            <img
                                class="preview_image"
                                src="{{ old('seo.image') ?: (!empty($model->seo->image) ? get_image_url($model->seo->image, '') : '/preview-icon.png') }}"
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
                                name="seo[image]" type="hidden"
                                class="image-data form-control @error('seo.image') is-invalid @enderror"
                                value="{{ old('seo.image') ?: (!empty($model->seo->image) ? $model->seo->image : '') }}"
                            >
                        </div>
                        @error('seo.image')
                        <span
                            class="error invalid-feedback" style="display: block"
                            role="alert"
                        >
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="seo_schema">{{ __('Schema') }}</label>
                    <textarea
                        name="seo[schema]"
                        id="seo_schema"
                        class="form-control @error('seo.schema') is-invalid @enderror"
                        rows="5"
                    >{{ old('seo.schema') ?: (!empty($model->seo) ? $model->seo->schema : null) }}</textarea>
                    @error('seo.schema')
                    <span class="error invalid-feedback" style="display: block" role="alert">
                        <strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            @foreach(config('admin.robots_meta') as $key => $row)
             <div class="col-md-3">
                <div class="form-group clearfix">
                    <input name="seo[{{$key}}]" value="0" type="hidden">
                    <div class="icheck-primary d-inline">
                        <input
                            type="checkbox"
                             name="seo[{{$key}}]"
                             id="seo_{{$key}}"
                             value="1"
                            @if(old('seo.'.$key) || (!empty($model->seo) && $model->seo->$key)) checked @endif>
                        <label for="seo_{{$key}}">
                            {{ __($row) }}
                        </label>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- /.row -->
    </div>
</div>
