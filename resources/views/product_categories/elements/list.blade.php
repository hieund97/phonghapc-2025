<div class="col-md">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('List of categories') }}</h3>

            <div class="card-tools d-flex">
                <a href="{{ route('product_categories.index') }}" class="btn btn-success btn-sm mr-2">
                    <i class="fa fa-plus"></i>
                    {{ __('Create') }}
                </a>
                @include('partials.cards.search')
            </div>
        </div>

        <div class="card-body p-0">
            <div class="just-padding">
                <div class="list-group list-group-root well">
                    @php
                        $traverse = function ($categories) use (&$traverse, $currentCategory) {
                            foreach ($categories as $category) {
                                if($category->status == 1) {
                                    $statusLabel = 'Kích hoạt';
                                    $statusClass = 'success';
                                }
                                else {
                                    $statusLabel = 'Không kích hoạt';
                                    $statusClass = 'danger';
                                }
                                $expaned = $category->childrenOrder->isNotEmpty() ? 'expaned' : '';
                                $style ='style="padding-left:'.(($category->level-1)*25).'px"' ;
                                echo '<div href="#item-'.$category->id.'" '.$style.'  class="category-list list-group-item '.$expaned.(!empty($currentCategory) && $category->id == $currentCategory->id ? ' cl-active' : '').'" data-toggle="collapse">';
                                echo '<i class="fa fa-chevron-right"></i>'.$category->title;
                                echo '<span class="float-right">';
                                echo '<span class="badge badge-'.$statusClass.'" style="margin-right:1em;">'.$statusLabel.'</span>';
                                if ($category->parent){
                                    echo '<input type="text" style="width: 25px; margin-right: 10px" class="cate-child-order" data-id="'.$category->id.'" value="'.$category->ordering.'"></input>';
                                }
                                echo '<a class="prevent-expand btn btn-warning btn-sm" onclick="window.open(\''.route('fe.product.category',['slug'=>$category->slug,'id'=>$category->id]).'\', \'_blank\');" href="'.route('fe.product.category',['slug'=>$category->slug,'id'=>$category->id]).'">Xem chi tiết</a>';
                                if (request()->user()->can('product_categories.update')) {
                                    echo '<span class="prevent-expand ml-1 btn btn-warning btn-sm" onclick="$.pjax({url: \''.route('product_categories.index', ['id' => $category->id]).'\', container: \'#pjax-container\'});">'.__('Edit').'</span>';
                                }

                                if (request()->user()->can('product_categories.destroy')) {
                                    echo '<span class="prevent-expand ml-1 btn btn-danger btn-sm" onclick="deleteResource(\''.route('product_categories.destroy', ['product_category' => $category->id]).'\', \''.route('product_categories.index').'\')">'.__('Delete').'</span>';
                                }

                                echo '</span>';
                                echo '</div>';

                                if ($category->children->isNotEmpty()) {
                                    echo '<div class="list-group collapse" id="item-'.$category->id.'">';
                                    $traverse($category->children);
                                    echo '</div>';
                                }
                            }
                        };

                        $traverse($categories)
                    @endphp
                </div>
            </div>
        </div>

        @if ($categories->hasPages())
            <div class="card-footer clearfix pb-0">
                <div class="pagination-sm m-0 float-right">
                    {{ $categories->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>
</div>