<?php

namespace App\CacheProfiles;

use Illuminate\Http\Request;

class CacheAllSuccessfulGetRequests extends \Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests
{
    public function shouldCacheRequest(Request $request): bool
    {
        return config('responsecache.enabled') && $request->isMethod('get');
    }
}
