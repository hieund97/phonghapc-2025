<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProductCategory extends Model
{
    use SearchableTrait, NodeTrait, ForgetResponseCache;

    public static $cacheTags = ['product_categories', 'products'];

    public static $hiddenByStatus = [2];

    public static $STATUS = [
        1 => 'Active',
        2 => 'Inactive',
    ];

    public static $TYPE = [
        1 => 'New Product',
        2 => 'Accessory',
        3 => 'Used Product',
    ];

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'thumbnail',
        'icon',
        'description',
        'ordering',
        'is_menu_top',
        'is_menu_home',
        'is_menu_bottom',
        'level',
        'status',
        'show_on_mobile',
        'show_on_promotion',
        'is_build',
        'is_feature',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'title'       => 10,
            'description' => 5,
            'slug'        => 1,
        ],
    ];

    /**
     * Get the page's seo meta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'model', 'model', 'model_id');
    }

    /**
     * The filter brands that belong to the product category.
     */
    public function filterBrands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class)
                    ->using(ProductCategoryBrand::class)
                    ->withPivot([
                        'slug',
                        'title',
                        'description',
                        'created_at',
                        'updated_at',
                    ])
        ;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function manyProducts($column = 'id', $sort = 'DESC')
    {
        return $this->belongsToMany(Product::class, 'product_category')->orderBy($column, $sort);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class, 'model_id')->where('model', static::class);
    }


    public function menuTopChilds()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id_menu_top', 'id');
    }

    public function menuHomeChilds()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id_menu_home', 'id');
    }

    public function menuBottomChilds()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id_menu_bottom', 'id');
    }

    public function menuPromotionChilds()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id_menu_promotion', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function childrenEnable()
    {
        return $this->hasMany(static::class, 'parent_id')->whereNotIn('status' , static::$hiddenByStatus)->orderBy('ordering', 'ASC');;
    }

    public function childrenOrder()
    {
        return $this->hasMany(static::class, 'parent_id')->orderBy('ordering', 'ASC');
    }
    public function productOrders()
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function homeTextLinks()
    {
        return $this->hasMany(TextLink::class, 'model_id')->where('model', static::class)->where('is_home', true);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_product_category');
    }

    public function attribute(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'category_attribute_relationships', 'category_id', 'attr_id')->orderBy('order', 'ASC');
    }

    public function gift(): BelongsToMany
    {
        return $this->belongsToMany(Gift::class, 'category_gift_relationships', 'category_id', 'gift_id');
    }
}
