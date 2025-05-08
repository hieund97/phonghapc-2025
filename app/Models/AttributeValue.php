<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kalnoy\Nestedset\NodeTrait;

class AttributeValue extends Model
{
    use Filterable, HasFactory;
    use NodeTrait;

    protected $table = 'attribute_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",
        "title",
        "slug",
        "canonical",
        "description",
        "parent_id",
        "order",
        "status",
        "image",
        "highlight",
        "attr_id"
    ];

    /**
     * Get the page's seo meta.
     *
     * @return MorphOne
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'model', 'model', 'model_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function childs(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function attrCate(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attr_id', 'id');
    }

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'attribute_relationships', 'product_id', 'attr_id');
    }

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'category_attribute_relationships', 'category_id', 'attr_id');
    }
}
