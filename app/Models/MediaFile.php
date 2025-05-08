<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MediaFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'mime_type',
        'size',
        'url',
        'path',
        'options',
        'folder_id',
        'user_id',
    ];

    /**
     * Get the folder that owns the file.
     */
    public function folder()
    {
        return $this->belongsTo(MediaFolder::class, 'id', 'folder_id');
    }

    public function getDiskAttribute()
    {
        return 'public';
    }

    public function getUrlAttribute($value)
    {
        return get_image_url($value);
    }
    public function reviews():BelongsToMany
    {
        return $this->belongsToMany(Review::class);
    }
}
