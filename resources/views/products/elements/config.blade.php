<div class="config-product">
    @if(!empty($product) && !empty($product->config) && checkHasConfig($product->config))
        @foreach($product->config as $index  => $config)
            <div id="config-{{$index}}">

                <div class="title-config mb-3" style="display:flex; justify-content:space-between;">
                    <h5>Cấu hình {{ $index }}</h5>
                    <button type="button" class="btn btn-sm btn-danger delete-config" data-index="{{ $index }}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">
                                {{ __('Product Config Name') }}
                            </label>

                            <input
                                    id="name"
                                    type="text"
                                    class="form-control"
                                    name="config_name[{{ $index }}]"
                                    placeholder="{{ __('Enter product name') }}"
                                    required
                                    value="{{ $config['name'] }}"
                            >
                        </div>
                    </div>
                </div>

                <div class="row" id="description-form-config">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="config_description">
                                {{ __('Description') }}
                            </label>
                            <textarea
                                    id="config_description_{{ $index }}"
                                    name="config_description[{{ $index }}]"
                                    class="form-control"
                                    rows="3"
                                    required
                            >
                                {{ $config['config_description'] ?? '' }}
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="price">
                                {{ __('Price') }}
                            </label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">VND</span>
                                </div>

                                <input
                                        id="price"
                                        type="text"
                                        class="form-control"
                                        name="config_price[{{ $index }}]"
                                        placeholder="{{ __('Enter product price') }}"
                                        required
                                        value="{{ $config['price'] }}"
                                        number-mask
                                >

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="sale_price">
                                {{ __('Sale Price') }}
                            </label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">VND</span>
                                </div>

                                <input
                                        id="sale_price"
                                        type="text"
                                        class="form-control"
                                        name="config_sale_price[{{ $index }}]"
                                        placeholder="{{ __('Enter product sale price') }}"
                                        number-mask
                                        value="{{ $config['sale_price'] ?? 0 }}"
                                >

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 image-box">
                        <div class="form-group">
                            <label for="feature_img">
                                {{ __('Image Config') }}
                            </label>
                            <div class="preview-image-wrapper img-fluid">
                                <img
                                        class="preview_image"
                                        src="{{ (!empty($config['config_img']) ? get_image_url($config['config_img'], '') : '/preview-icon.png') }}"
                                >
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                    <span class="input-group-btn">
                                        <a data-result="image" data-action="select-image"
                                           class="btn_gallery btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> {{__('Choose')}}
                                        </a>
                                        <a class="btn_remove_image btn btn-primary text-white"> <i
                                                    class="fa fa-trash-alt"></i></a>
                                    </span>
                                <input
                                        name="config_img[{{ $index }}]" type="hidden" maxlength="999"
                                        class="image-data form-control"
                                        value="{{ (!empty($config['config_img']) ? $config['config_img'] : null) }}"
                                >
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @if($index != 1)
                <script>
                    let keyEditor = '{{ $index }}'
                    CKEDITOR.replace('config_description_'+keyEditor);
                </script>
            @endif

        @endforeach
    @else
        <div id="config-1">

            <div class="title-config mb-3" style="display:flex; justify-content:space-between;">
                <h5>Cấu hình 1</h5>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">
                            {{ __('Product Config Name') }}
                        </label>

                        <input
                                id="name"
                                type="text"
                                class="form-control"
                                name="config_name[1]"
                                placeholder="{{ __('Enter product name') }}"
                        >
                    </div>
                </div>
            </div>

            <div class="row" id="description-form-config">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="config_description">
                            {{ __('Description') }}
                        </label>
                        <textarea
                                id="config_description_1"
                                name="config_description[1]"
                                class="form-control"
                                rows="3"
                                required
                        ></textarea>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="price">
                            {{ __('Price') }}
                        </label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">VND</span>
                            </div>

                            <input
                                    id="price"
                                    type="text"
                                    class="form-control"
                                    name="config_price[1]"
                                    placeholder="{{ __('Enter product price') }}"
                                    number-mask
                            >

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="sale_price">
                            {{ __('Sale Price') }}
                        </label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">VND</span>
                            </div>

                            <input
                                    id="sale_price"
                                    type="text"
                                    class="form-control currencyMask"
                                    name="config_sale_price[1]"
                                    placeholder="{{ __('Enter product sale price') }}"
                                    number-mask
                            >

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 image-box">
                    <div class="form-group">
                        <label for="feature_img">
                            {{ __('Image Config') }}
                        </label>
                        <div class="preview-image-wrapper img-fluid">
                            <img
                                    class="preview_image"
                                    src="/preview-icon.png"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                                    <span class="input-group-btn">
                                        <a data-result="image" data-action="select-image"
                                                class="btn_gallery btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> {{__('Choose')}}
                                        </a>
                                        <a class="btn_remove_image btn btn-primary text-white"> <i
                                                    class="fa fa-trash-alt"></i></a>
                                    </span>
                            <input
                                    name="config_img[1]" type="hidden" maxlength="999"
                                    class="image-data form-control"
                            >
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>


<input type="hidden" name="index_config" id="index_config"
       value="{{ !empty($product) && !empty($product->config) ? count($product->config) : 1  }}">
<button type="button" id="add_config" class="btn btn-sm btn-primary">
    <i class="fa fa-plus" aria-hidden="true"></i> &nbsp;Thêm cấu hình
</button>
@push('scripts')
    <script>
        $(function () {
            CKEDITOR.replace('config_description_1');
            $('#add_config').on('click', function () {
                addConfig();
            })

            $(document).on('click', '.delete-config', function () {
                let thisIndex = $(this).data('index');
                deleleConfig(thisIndex);
            })
        });

        function addConfig() {
            let index = $('#index_config').val();
            let indexIncrease = parseInt(index) + 1;
            let html = getHtml(indexIncrease);
            $('#index_config').val(indexIncrease);
            $('.config-product').append(html);
            CKEDITOR.replace('config_description_'+indexIncrease);
            addRvMedia()
        }

        function deleleConfig(currentIndex) {
            let maxIndex = $('#index_config').val();
            $('#config-' + currentIndex).remove();

            // let indexDecrease =  parseInt(maxIndex) - 1;
            // $('#index_config').val(indexDecrease);
        }

        function getHtml(index) {
            return `<hr>
                     <div id="config-${index}">
                        <div class="title-config mb-3" style="display:flex; justify-content:space-between;">
                            <h5>Cấu hình ${index}</h5>
                            <button type="button" class="btn btn-sm btn-danger delete-config" data-index="${index}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">
                                        Tên cấu hình
                                    </label>

                                    <input
                                            id="name"
                                            type="text"
                                            class="form-control"
                                                name="config_name[${index}]"
                                            placeholder="Nhập tên sản phẩm"
                                            required
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row" id="description-form-config">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="config_description">
                                                    Mô tả cấu hình
                                    </label>
                                    <textarea
                                            id="config_description_${index}"
                                            name="config_description[${index}]"
                                            class="form-control"
                                            rows="3"
                                            required
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="price">Giá</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">VND</span>
                                    </div>

                                    <input
                                            id="price"
                                            type="text"
                                            class="form-control currencyMask" name="config_price[${index}]"
                                            placeholder="Nhập giá sản phẩm" required number-mask>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sale_price">
                                        Giá khuyến mại
                                    </label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">VND</span>
                                        </div>

                                        <input
                                            id="sale_price"
                                            type="text"
                                            class="form-control currencyMask"
                                            name="config_sale_price[${index}]"
                                            placeholder="Nhập giá khuyến mại"
                                                        number-mask
                                            >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 image-box">
                                <div class="form-group">
                                    <label for="feature_img">
                                        Ảnh cấu hình
                                    </label>
                                    <div class="preview-image-wrapper img-fluid">
                                        <img
                                                class="preview_image"
                                                src="/preview-icon.png"
                                        >
                                    </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <span class="input-group-btn">
                                        <a data-result="image" data-action="select-image"
                                                class="btn_gallery btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Chọn
                                        </a>
                                        <a class="btn_remove_image btn btn-primary text-white"> <i class="fa fa-trash-alt"></i></a>
                                    </span>
                                    <input
                                            name="config_img[${index}]" type="hidden" maxlength="999"
                                            class="image-data form-control"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        function addRvMedia(){
            $(document).find(".btn_gallery").rvMedia({
                multiple: !1,
                onSelectFiles: function(e, t) {
                    switch (t.data("action")) {
                        case "media-insert-ckeditor":
                            $.each(e, function(e, a) {
                                var n = a.full_url;
                                "youtube" === a.type ? (n = n.replace("watch?v=", "embed/"),
                                    CKEDITOR.instances[t.data("result")].insertHtml('<iframe width="420" height="315" src="' + n + '" frameborder="0" allowfullscreen></iframe>')) : "image" === a.type ? CKEDITOR.instances[t.data("result")].insertHtml('<img src="' + n + '" alt="' + a.name + '" />') : CKEDITOR.instances[t.data("result")].insertHtml('<a href="' + n + '">' + a.name + "</a>")
                            });
                            break;
                        case "media-insert-tinymce":
                            $.each(e, function(e, t) {
                                var a = t.full_url
                                    , n = "";
                                n = "youtube" === t.type ? '<iframe width="420" height="315" src="' + (a = a.replace("watch?v=", "embed/")) + '" frameborder="0" allowfullscreen></iframe>' : "image" === t.type ? '<img src="' + a + '" alt="' + t.name + '" />' : '<a href="' + a + '">' + t.name + "</a>",
                                    tinymce.activeEditor.execCommand("mceInsertContent", !1, n)
                            });
                            break;
                        case "select-image":
                            var a = _.first(e);
                            t.closest(".image-box").find(".image-data").val(a.full_url),
                                t.closest(".image-box").find(".preview_image_full").attr("src", a.full_url),
                                t.closest(".image-box").find(".preview_image").attr("src", a.thumb),
                                t.closest(".image-box").find(".preview-image-wrapper").show();
                            break;
                        case "attachment":
                            var n = _.first(e);
                            t.closest(".attachment-wrapper").find(".attachment-url").val(n.url),
                                $(".attachment-details").html('<a href="' + n.full_url + '" target="_blank">' + n.full_url + "</a>")
                    }
                }
            });
        }
    </script>
@endpush

