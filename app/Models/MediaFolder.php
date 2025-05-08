<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaFolder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'user_id',
    ];

    /**
     * Get the files for the folder.
     */
    public function files()
    {
        return $this->hasMany(MediaFile::class, 'folder_id', 'id');
    }
}
