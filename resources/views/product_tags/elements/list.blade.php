<div class="col-md">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('List of product tags') }}</h3>

            <div class="card-tools">
                {{-- @include('partials.cards.search') --}}
                <a href="{{ route('product_tags.index') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i>
                    {{ __('Create') }}
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="just-padding">
                <div class="list-group list-group-root well">
                    @php
                            foreach ($productTags as $productTag) {
      
                                echo '<div href="#item-'.$productTag->id.'" class="productTag-list list-group-item" data-toggle="collapse">';
                                echo '<i class="fa fa-chevron-right"></i>'.$productTag->title;
                                echo '<span class="float-right">';
                                echo '<a class="prevent-expand btn btn-warning btn-sm" onclick="window.open(\''.route('fe.product.tag',['slug'=>$productTag->slug,'id'=>$productTag->id]).'\', \'_blank\');" href="'.route('fe.product.tag',['slug'=>$productTag->slug,'id'=>$productTag->id]).'">Xem chi tiết</a>'; 
                                if (request()->user()->can('product_tags.update')) {
                                    echo '<span class="prevent-expand ml-1 btn btn-warning btn-sm" onclick="$.pjax({url: \''.route('product_tags.index', ['id' => $productTag->id]).'\', container: \'#pjax-container\'});">'.__('Edit').'</span>';
                                }

                                if (request()->user()->can('product_tags.destroy')) {
                                    echo '<span class="prevent-expand ml-1 btn btn-danger btn-sm" onclick="deleteResource(\''.route('product_tags.destroy', ['product_tag' => $productTag->id]).'\', \''.route('product_tags.index').'\')">'.__('Delete').'</span>';
                                }

                                echo '</span>';
                                echo '</div>';

                            }                        
                    @endphp
                </div>
            </div>
        </div>

        @if ($productTags->hasPages())
            <div class="card-footer clearfix pb-0">
                <div class="pagination-sm m-0 float-right">
                    {{ $productTags->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>
</div>