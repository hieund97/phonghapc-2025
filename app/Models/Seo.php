<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seo extends Model
{
    use Filterable,HasFactory;

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
        'description',
        'keyword',
        'canonical',
        'image',
        'robots',
        'schema',
        'index',
        'nofollow',
        'noimageindex',
        'noindex',
        'noarchive',
        'nosnippet',
        'follow',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'index' => 'boolean',
        'nofollow' => 'boolean',
        'noimageindex' => 'boolean',
        'noindex' => 'boolean',
        'noarchive' => 'boolean',
        'nosnippet' => 'boolean',
        'follow' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $robots = '';
            foreach(config('admin.robots_meta') as $key => $row) {
                if($model->$key) {
                    $robots .= $key.','; 
                }
            }
            $robots = rtrim(trim($robots),',');
            $model->robots = $robots;
        });
        static::updating(function ($model) {
            $robots = '';
            foreach(config('admin.robots_meta') as $key => $row) {
                if($model->$key) {
                    $robots .= $key.','; 
                }
            }
            $robots = rtrim(trim($robots),',');
            $model->robots = $robots;
        });


    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'model_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'model_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'model_id');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'model_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'model_id');
    }

    public function productTag(): BelongsTo
    {
        return $this->belongsTo(ProductTag::class, 'model_id');
    }

    public function postTag(): BelongsTo
    {
        return $this->belongsTo(PostTag::class, 'model_id');
    }
}
