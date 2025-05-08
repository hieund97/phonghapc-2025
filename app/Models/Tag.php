<?php

namespace App\Models;
use App\Traits\HasLogs;
use DB;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Tags\HasTags;
use Yadakhov\InsertOnDuplicateKey;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use EloquentFilter\TagFilter;

class Tag extends Model
{
       use Filterable, SearchableTrait, Searchable, InsertOnDuplicateKey, HasTags, HasLogs;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'order_column',
    ];



    public const TYPE = [301, 302, 307];
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
