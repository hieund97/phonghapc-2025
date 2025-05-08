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
class AttributeFilter extends ModelFilter
{
    /**
     * Filter products by status.
     *
     * @param integer $value
     *
     * @return AttributeFilter
     */
    public function status($value): AttributeFilter
    {
        return $this->where('status', $value);
    }

    public function title($value)
    {
        return $this->whereLike('title', $value);
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
}
