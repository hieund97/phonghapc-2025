<?php

namespace Botble\Media\Models;

use App\Models\MediaFileResize;
use App\Models\ProductMedia;
use Botble\Media\Services\UploadsManager;
use DB;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaFile extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'media_files';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'mime_type',
        'type',
        'size',
        'url',
        'options',
        'folder_id',
        'user_id',
    ];

    public function mediaFileResizes()
    {
        return $this->hasMany(MediaFileResize::class, 'media_file_id', 'id');
    }

    /**
     * Get the auto increment value of this table.
     *
     * @return int
     */
    public static function getIncrementValue(): int
    {
        $statement = DB::select("show table status like '" . (new static())->getTable() . "'");

        return $statement[0]->Auto_increment;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Sang Nguyen
     */
    public function folder()
    {
        return $this->belongsTo(MediaFolder::class, 'id', 'folder_id');
    }

    /**
     * @return string
     * @author Sang Nguyen
     */
    public function getTypeAttribute()
    {
        $type = 'document';
        if ($this->attributes['mime_type'] == 'youtube') {
            return 'video';
        }

        foreach (config('media.mime_types') as $key => $value) {
            if (in_array($this->attributes['mime_type'], $value)) {
                $type = $key;
                break;
            }
        }

        return $type;
    }

    /**
     * @return string
     * @author Sang Nguyen
     */
    public function getHumanSizeAttribute()
    {
        return human_file_size($this->attributes['size']);
    }

    /**
     * @return string
     * @author Sang Nguyen
     */
    public function getIconAttribute()
    {
        /**
         * @var Model $this
         */
        switch ($this->type) {
            case 'image':
                $icon = 'fa fa-file-image';
                break;
            case 'video':
                $icon = 'fa fa-file-video';
                break;
            case 'pdf':
                $icon = 'fa fa-file-pdf';
                break;
            case 'excel':
                $icon = 'fa fa-file-excel';
                break;
            case 'youtube':
                $icon = 'fa fa-youtube';
                break;
            default:
                $icon = 'fa fa-file-text';
                break;
        }
        return $icon;
    }

    /**
     * @param $value
     * @return mixed
     * @author Sang Nguyen
     */
    public function getOptionsAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    /**
     * @author Sang Nguyen
     * @param $value
     */
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function productMedias()
    {
        return $this->hasMany(ProductMedia::class);
    }

    /**
     * @author Sang Nguyen
     */
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($file) {
            /**
             * @var MediaFile $file
             */
            if ($file->isForceDeleting()) {
                $uploadManager = new UploadsManager;
                $path = str_replace(config('media.driver.' . config('filesystems.default') . '.path'), '', $file->url);
                $uploadManager->deleteFile($path);

                $file->mediaFileResizes()->forceDelete();
            } else {
                $file->mediaFileResizes()->delete();
            }

            $file->productMedias()->delete();
        });
    }
}
