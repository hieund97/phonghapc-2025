<?php

namespace App\Models;

use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kalnoy\Nestedset\NodeTrait;

class Attribute extends Model
{
    use Filterable, HasFactory;
    //use NodeTrait;

    protected $table = 'attributes';

    public const STATUS = [
        1 => 'publish',
        2 => 'pending',
        3 => 'draft',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",
        "title",
        "slug",
        "model",
        "description",
        "order",
        "status",
        "image",
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where('status', '=', array_search('publish', self::STATUS));
        });
    }

    /**
     * Get the page's seo meta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'model', 'model', 'model_id');
    }

    public function attrValueTitle(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'attr_id', 'id')->orderBy('title', 'ASC');
    }

    public function attrValue(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'attr_id', 'id')->orderBy('order', 'ASC');
    }


}
