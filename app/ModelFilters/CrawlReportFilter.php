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
class CrawlReportFilter extends ModelFilter
{
    /**
     * Filter products by status.
     *
     * @param integer $value
     *
     * @return CrawlReportFilter
     */
    public function status($value): CrawlReportFilter
    {
        return $this->where('status', $value);
    }

    public function type($value): CrawlReportFilter
    {
        return $this->where('type', $value);
    }

    public function follow($value): CrawlReportFilter
    {
        return $this->where('follow', $value);
    }

    public function url($value)
    {
        return $this->whereLike('url', $value);
    }

    public function updatedAt($value)
    {
        $range = dateRangePicker($value);

        if (count($range) != 2) {
            return $this;
        }

        return $this->whereDate('updated_at', '>=', $range[0])
            ->whereDate('updated_at', '<=', $range[1]);
    }

    /**
     * Filter by product
     *
     * @param array|string $value
     *
     * @return CrawlReportFilter
     */
    public function product($value)
    {
        return $this->where(function (Builder $query) use ($value) {

            $query->whereHas('product', function (Builder $query) use ($value) {
                $query->where('name', 'like', '%'.$value.'%');
            });
        });
    }
}
