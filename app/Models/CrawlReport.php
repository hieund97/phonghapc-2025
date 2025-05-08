<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrawlReport extends Model
{
    use Filterable, HasFactory;
    //use NodeTrait;

    protected $table = 'crawl_reports';

    public const STATUS = [
        2 => 'Không trùng giá',
        1 => 'Trùng giá',
    ];

    public const FOLLOW = [
        1 => 'Theo dõi',
        0 => 'Không theo dõi',
    ];

    public const TYPE = [
        1 => 'HaCom',
        2 => 'An Phát',
        3 => 'Nguyễn Công',
        5 => 'Hoàng Hà PC',
        4 => 'Điện Máy Xanh'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",
        "url",
        "info_product_url",
        "type",
        "product_id",
        "last_update",
        "status",
        "follow",
    ];

    /**
     * Get the product record associated with the crawl data.
     */
    public function product()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
