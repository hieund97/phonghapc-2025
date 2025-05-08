<div class="row mt-4">
    <div class="col-md-12">
        <label for="real_images">{{ __('Real Images') }}</label>

        <div class="input-group">
            @php
                $realImages = !empty(old('real_images')) ? old('real_images'): (!empty($product) ? json_encode($product->realImages) : [])
            @endphp
            <input class="form-control" id="real_images" name="real_images" type="hidden" value="{{ !empty($realImages) ? $realImages:'' }}">
            <div class="ld-img-preview list-photos-gallery" id="list_real_images">
                <div class="row" id="list_real_images_items">
                    @if (!empty($realImages))
                        @foreach(json_decode($realImages) as $row)
                        <div class="col-md-2 col-sm-3 col-4 photo-gallery-item" data-id="{{ $loop->index }}" data-img="{{ $row->url }}" data-description="{{ $row->title }}" data-file-id="{{ $row->media_file_id }}">
                            <div class="gallery_image_wrapper"><img width="150px;" src="{{ $row->url }}" />
                            </div></div>
                        @endforeach
                    @endif
                </div>
            </div>
            <span class="input-group-btn">
                <a id="btn_real_images" class="btn btn-primary text-white" data-list="list_real_images" data-item="list_real_images_items" data-gallery = "real_images" >
                    <i class="fa fa-picture-o"></i> {{__('Choose')}}
                </a>
            </span>

            @error('real_images')
            <span class="error invalid-feedback" style="display: block;" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
