<?php

namespace App\Models;

use App\Traits\ForgetResponseCache;
use Botble\Media\Models\MediaFile;
use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
    use ForgetResponseCache;

    public static $cacheTags = ['products', 'product_medias'];

    protected $table = 'product_media';

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
        'width',
        'height',
        'sort',
        'link',
    ];

    public function mediaFile()
    {
        return $this->belongsTo(MediaFile::class);
    }
}
