<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ItemRelate extends Model
{
    use HasFactory;
    public const MODEL = [
        Product::class,
        ProductCategory::class,
        Category::class,
        Page::class,
        Post::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'model_id',
        'title',
        'link',
        'image',
        'rel',
        'target',
        'sort',
    ];
    public function itemRelates(): MorphToMany
    {
        return $this->morphToMany(Post::class, 'model', 'model', 'model_id');
    }

}
