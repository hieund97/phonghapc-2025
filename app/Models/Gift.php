<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Gift extends Model
{
    use Filterable, HasFactory;

    protected $table = 'gifts';

    public const STATUS = [
        1 => 'publish',
        2 => 'cancel',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",
        "name",
        "status",
        "content",
    ];

    protected static function booted () {
        static::deleting(function ($gift) {
            $gift->category()->detach();
        });
    }

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'category_gift_relationships', 'gift_id', 'category_id');
    }
}
