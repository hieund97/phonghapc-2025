<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Botble\Media\Models\MediaFile;
use Illuminate\Database\Eloquent\Model;

class RealImage extends Model
{
    use ForgetResponseCache;

    public static $cacheTags = ['products', 'real_images'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_id',
        'model',
        'media_file_id',
        'title',
        'url',
    ];

    public function mediaFile()
    {
        return $this->belongsTo(MediaFile::class);
    }
}
