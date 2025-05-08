<?php

namespace App\ModelFilters;

use App\Models\Product;
use App\Models\ProductCategory;
use DB;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProductFilter
 *
 * @package App\ModelFilters
 *
 * @var Builder $this
 */
class ProductFilter extends ModelFilter
{
    /**
     * Filter by product category ids.
     *
     * @param array|string $value
     *
     * @return ProductFilter
     */
    public function productCategories($value): ProductFilter
    {
        if (is_string($value)) {
            $value = explode(',', $value);
        }


        //$ids = [];
        //$categories = ProductCategory::whereIn('id', $value)->get([
        //    'id',
        //    '_lft',
        //    '_rgt',
        //    'parent_id',
        //]);
        //
        //
        //foreach ($categories as $category) {
        //    $ids[] = $category->id;
        //    $ids = array_merge($ids, $category->pluck('id')->toArray());
        //}


        return $this->where(function (Builder $query) use ($value) {
            //$query->whereIn('product_category_id', $value);

            $query->orWhereHas('categories', function (Builder $query) use ($value) {
                $query->whereIn('id', $value);
            });
        });
    }

    /**
     * Filter products by status.
     *
     * @param integer $value
     *
     * @return ProductFilter
     */
    public function status($value): ProductFilter
    {
        return $this->where('status', $value);
    }

    /**
     * Filter by product category ids.
     *
     * @param array|string $value
     *
     * @return ProductFilter
     */
    public function productCategory($value)
    {
        return $this->productCategories($value);
    }

    /**
     * Filter products by brand ids.
     *
     * @param array|string $value
     *
     * @return ProductFilter
     */
    public function brands($value): ProductFilter
    {
        if (is_string($value)) {
            $value = explode(',', $value);
        }

        return $this->whereIn('brand_id', $value);
    }


    /**
     * Filter products by price range.
     *
     * @param array $value
     *
     * @return ProductFilter
     */
    public function price($value): ProductFilter
    {
        $column = DB::raw('(
            CASE
                WHEN `sale_price` IS NOT NULL AND `sale_price` != 0 AND ((`sale_from` IS NULL AND `sale_to` IS NULL) OR (`sale_from` <= NOW() AND `sale_to` >= NOW())) THEN `sale_price`
                ELSE `price`
            END
        )');

        if (!empty($value['from']) && is_numeric($value['from'])) {
            $this->where($column, '>=', $value['from']);
        }

        if (!empty($value['to']) && is_numeric($value['to'])) {
            $this->where($column, '<=', $value['to']);
        }

        // Filter từ front end
        $valueFilter = [];
        $oneMillion = 1000000;
        switch ($value) {
            case "duoi-2-trieu":
                $valueFilter['to'] = 2 * $oneMillion;
                break;
            case "tu-2-4-trieu":
                $valueFilter['from'] = 2 * $oneMillion;
                $valueFilter['to'] = 4 * $oneMillion;
                break;
            case "tu-4-7-trieu":
                $valueFilter['from'] = 4 * $oneMillion;
                $valueFilter['to'] = 7 * $oneMillion;
                break;
            case "tu-7-15-trieu":
                $valueFilter['from'] = 7 * $oneMillion;
                $valueFilter['to'] = 15 * $oneMillion;
                break;
            case "tren-15-trieu":
                $valueFilter['from'] = 15 * $oneMillion;
                break;
        }

        if (!empty($valueFilter['from']) && is_numeric($valueFilter['from'])) {
            $this->where($column, '>=', $valueFilter['from']);
        }

        if (!empty($valueFilter['to']) && is_numeric($valueFilter['to'])) {
            $this->where($column, '<=', $valueFilter['to']);
        }

        // Hết Filter từ front end

        return $this;
    }

    public function name($value)
    {
        return $this->whereLike('name', $value);
    }

    public function createdAt($value)
    {
        $range = dateRangePicker($value);

        if (count($range) != 2) {
            return $this;
        }

        return $this->whereDate('created_at', '>=', $range[0])
            ->whereDate('created_at', '<=', $range[1]);
    }

    public function dateOfSale($value)
    {
        $range = dateRangePicker($value);

        if (count($range) != 2) {
            return $this;
        }

        return $this->whereDate('date_of_sale', '>=', $range[0])
            ->whereDate('date_of_sale', '<=', $range[1]);
    }

    public function author($value)
    {
        return $this->whereLike('author',$value);
    }



    public function inSaleTime($value)
    {
        if ($value != 2 && $value != 1) {
            return $this;
        }
        if ($value == 2) {
            return $this->where(function (Builder $query) {
                $query->where('sale_price', '>', 0);
                $query->where(function (Builder $query) {
                    $query->where(function (Builder $query) {
                        $query->whereNull('sale_from');
                        $query->whereNull('sale_to');
                    });

                    $query->orWhere(function (Builder $query) {
                        $query->where('sale_from', '<=', now());
                        $query->where('sale_to', '>=', now());
                    });
                });
            });
        } else if ($value == 1) {
            return $this->where(function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where('sale_price', '=', 0);

                    $query->orWhere('sale_price', '=', null);
                });

                $query->orWhere(function (Builder $query) {
                    $query->where('sale_price', '>', 0);
                    $query->where(function (Builder $query) {
                        $query->where('sale_from', '>=', now());
                        $query->orWhere('sale_to', '<=', now());
                    });
                });
            });
        }
    }
}
