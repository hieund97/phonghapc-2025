<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use ResponseCache;

trait ForgetResponseCache
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootForgetResponseCache(): void
    {
        $tags = Arr::wrap(static::$cacheTags);

        self::saved(function ($model) use ($tags) {
            ResponseCache::clear($tags);
        });

        self::deleted(function ($model) use ($tags) {
            ResponseCache::clear($tags);
        });
    }
}
