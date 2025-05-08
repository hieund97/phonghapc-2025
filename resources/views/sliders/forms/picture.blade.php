<div class="row">
    <div class="col-md-12">
        <label for="thumbnail">{{ __('Thumbnail') }}</label><span class="text-danger">(*)</span>

        <div class="input-group">
            @php
                $pictures = !empty(old('picture')) ? old('picture'): (!empty($product) ? json_encode($product->productMedias) : [])
            @endphp
            <input id="gallery-data" class="form-control" name="picture" type="hidden"
                   value="{{ !empty($pictures) ? $pictures:'' }}">
            <div class="ld-img-preview list-photos-gallery" id="list_pictures">
                <div class="row" id="list-photos-items">
                    @if (!empty($pictures))
                        @foreach(json_decode($pictures) as $picture)
                            <div class="col-md-2 col-sm-3 col-4 photo-gallery-item" data-id="{{ $loop->index }}"
                                 data-img="{{ $picture->url }}" data-description="{{ $picture->title }}"
                                 data-file-id="{{ $picture->media_file_id }}" data-sort="{{ $picture->sort }}"
                                 data-link="{{ $picture->link }}">
                                <div class="gallery_image_wrapper">
                                    <img src="{{ get_image_url($picture->url) }}"/>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
            <span class="input-group-btn">
                <a id="btn_picture" class="btn btn-primary text-white" data-list="list_pictures"
                   data-item="list-photos-items" data-gallery="gallery-data">
                    <i class="fa fa-picture-o"></i> {{__('Choose')}}
                </a>
            </span>

            @error('picture')
            <span class="error invalid-feedback" style="display: block;" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
