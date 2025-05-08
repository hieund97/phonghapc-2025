<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name">
                {{ __('Product Name') }} (
                <span class="text-danger">*</span>
                )
            </label>

            <input
                    id="name"
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    placeholder="{{ __('Enter product name') }}"
                    value="{{ old('name') ?: (!empty($product) ? $product->name : '') }}"
                    required
            >

            @error('name')
            <span class="error invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="slug">
                {{ __('Slug') }} (
                <span class="text-danger">*</span>
                )
            </label>

            <input
                    id="slug"
                    type="text"
                    class="form-control @error('slug') is-invalid @enderror"
                    name="slug"
                    value="{{ old('slug') ?: (!empty($product) ? $product->slug : '') }}"
                    required
            >

            @error('slug')
            <span class="error invalid-feedback d-block" role="alert">
                                    <strong>{!! $message !!}</strong>
                                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="price">
                {{ __('Price') }} (
                <span class="text-danger">*</span>
                )
            </label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">VND</span>
                </div>

                <input
                        id="price"
                        type="text"
                        class="form-control @error('price') is-invalid @enderror"
                        name="price"
                        placeholder="{{ __('Enter product price') }}"
                        value="{{ old('price') ?: (!empty($product) ? $product->price : '') }}"
                        required
                        number-mask
                >

            </div>

            @error('price')
            <span class="error invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card collapsed-card">
            <div class="card-header" data-card-widget="collapse">
                <h3 class="card-title">{{ __('Sale') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="sale_price">{{ __('Sale Price') }}</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">VND</span>
                                </div>

                                <input
                                        id="sale_price"
                                        type="text"
                                        class="form-control @error('sale_price') is-invalid @enderror"
                                        name="sale_price"
                                        placeholder="{{ __('Enter sale price') }}"
                                        value="{{ old('sale_price') ?: (!empty($product) ? $product->sale_price : '') }}"
                                        number-mask
                                >

                                <div class="input-group-append">
                                    <button
                                            id="btn-advanced-sale-price" class="btn btn-info"
                                            type="button" data-toggle="collapse"
                                            data-target="#collapseAdvancedSalePrice"
                                            aria-expanded="true"
                                            aria-controls="collapseAdvancedSalePrice"
                                    >
                                        @if (!empty(old('sale_time')) || empty($product) || (!empty($product) && !empty($product->sale_from) && !empty($product->sale_to)))
                                            {{ __('With Time') }}
                                            <i class="fas fa-chevron-up fa-sm fa-fw"></i>
                                        @else
                                            {{ __('No Sale Time') }}
                                            <i class="fas fa-chevron-down fa-sm fa-fw"></i>
                                        @endif
                                    </button>
                                </div>
                            </div>

                            @error('sale_price')
                            <span class="error invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div
                        class="collapse @if (!empty(old('sale_time')) || empty($product) || (!empty($product) && !empty($product->sale_from) && !empty($product->sale_to))) show @endif"
                        id="collapseAdvancedSalePrice"
                >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                @php
                                    use Illuminate\Support\Arr;$saleErrors = Arr::flatten(Arr::except($errors->get('sale_*'), 'sale_price'))
                                @endphp

                                <label for="sale_time">{{ __('Sale Time') }}</label>

                                <input
                                        id="sale_time"
                                        type="text"
                                        class="datetimerange form-control @if(!empty($saleErrors)) is-invalid @endif"
                                        name="sale_time"
                                        autocomplete="off"
                                        value="{{ old('sale_time') ?: (!empty($product) && !empty($product->sale_from) && !empty($product->sale_to) ? $product->sale_from.' - '.$product->sale_to : '') }}"
                                >

                                @if(!empty($saleErrors))
                                    <span class="error invalid-feedback d-block" role="alert">
                                                            @foreach($saleErrors as $message)
                                            <strong>{{ $message }}</strong>
                                            <br>
                                        @endforeach
                                                        </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input
                                            type="checkbox"
                                            id="hide_sale_time"
                                            name="hide_sale_time"
                                            value="1"
                                            @if(old('hide_sale_time') || (!empty($product) && $product->hide_sale_time)) checked @endif>
                                    <label for="hide_sale_time">
                                        {{ __('Hide sale time?') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md">
        <div class="form-group">
            <label for="serial">
                {{ __('Product Serial') }}{{-- (<span class="text-danger">*</span>)--}}
            </label>

            <input
                    id="serial"
                    type="text"
                    class="form-control @error('serial') is-invalid @enderror"
                    name="serial"
                    placeholder="{{ __('Enter product serial') }}"
                    value="{{ old('serial') ?: (!empty($product) ? $product->serial : '') }}"
            >

            @error('serial')
            <span class="error invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
    </div>

    <div class="col-md">
        <div class="form-group">
            <label for="skus">
                {{ __('Sku') }}
            </label>

            <input
                    id="serial"
                    type="text"
                    class="form-control @error('skus') is-invalid @enderror"
                    name="skus"
                    placeholder="{{ __('Enter product sku') }}"
                    value="{{ old('skus') ?: (!empty($product) ? $product->skus : '') }}"
            >

            @error('skus')
            <span class="error invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>{{ __('Tags') }}</label>
            <select
                    class="form-control select2bs4 @error('product_tags') is-invalid @enderror"
                    id="categories"
                    name="product_tags[]"
                    multiple
            >
                <option value="">{{ __('Select Tag') }}</option>
                @include('partials.forms.product_tag_options', ['selected' => old('product_tags', !empty($product) && $product->productTags->isNotEmpty() ? $product->productTags->pluck('id')->toArray() : [])])
            </select>
            @error('product_tags')
            <span class="error invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
    </div>
</div>

@include('products.forms.picture',['product'=> !empty($product) ? $product : []])
@error('attr')
<span class="error invalid-feedback d-block" role="alert">
    <strong>Trường thuộc tính không được để trống</strong>
</span>
@enderror