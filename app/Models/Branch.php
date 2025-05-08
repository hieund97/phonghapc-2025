<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Branch extends Model
{
    use SearchableTrait, ForgetResponseCache;

    public static $cacheTags = 'branches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'thumbnail',
        'address',
        'district',
        'province',
        'hotline',
        'sort',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'title' => 1,
            'address' => 2,
        ],
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function (Builder $query) {
            $query->orderByDesc('sort');
        });
    }
}
