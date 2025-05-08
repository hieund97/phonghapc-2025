<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use ForgetResponseCache;

    public static $cacheTags = 'settings';
}
