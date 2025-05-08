<div class="container pd-10">
    <div class="row">
        <div class="col-3 col-md-3 col-lg-3">
            @php
                $aryCategory = [];
                if(isset($isCategory) && $isCategory) {
                    if($category->parent_id == 0 && !empty($category->childrenEnable)) {
                        $aryCategory = $category->childrenEnable;
                    }
                    else {
                        $parent = $category->parent;
                        $aryCategory = $parent->childrenEnable;
                    }
                }


            @endphp
            @include('front_end.partials.filter',
                [
                    'aryCategory'       => $aryCategory,
                    'category'          => $category,
                    'aryProduct'        => $aryProduct,
                    'listAllAttribute'  => $listAllAttribute,
                    'isFilterCategory'  => $isFilterCategory ?? false,
                    'selectedAttribute' => $selectedAttribute ?? [],
                    'isCategory'        => $isCategory
                ])
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12 right-catalog-pr">
            @include('front_end.partials.list-product',
                [
                    'aryProduct'        => $aryProduct,
                    'category'          => $category,
                    'isFilterCategory'  => $isFilterCategory ?? false,
                    'type'              => $type ?? 0
                ])
        </div>
    </div>
</div>