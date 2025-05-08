<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nicolaslopezj\Searchable\SearchableTrait;

class PostTag extends Model
{
    use SearchableTrait;

    use HasFactory;

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
        'title',
        'slug',
        'description',
        'thumbnail',
        'banner',
        'status',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'title' => 10,
            'slug' => 1,
            'description' => 5,
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

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}
