<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use ForgetResponseCache;

    public static $cacheTags = ['products', 'videos'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'model_id',
        'title',
        'full_url',
        'video_id',
        'autoplay',
        'loop',
        'controls',
    ];
}
