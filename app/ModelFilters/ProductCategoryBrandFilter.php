<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ProductCategoryBrandFilter extends ModelFilter
{
    /**
     * Filter by product category.
     *
     * @param string|int $value
     *
     * @return \App\ModelFilters\ProductCategoryBrandFilter
     */
    public function productCategory($value): ProductCategoryBrandFilter
    {
        return $this->where('product_category_id', $value);
    }

    /**
     * Filter by brand.
     *
     * @param string|int $value
     *
     * @return \App\ModelFilters\ProductCategoryBrandFilter
     */
    public function brand($value): ProductCategoryBrandFilter
    {
        return $this->where('brand_id', $value);
    }
}
