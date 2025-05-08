<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\File;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['path'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        $dir = storage_path('app/pages');

        static::saving(function (Page $page) use ($dir) {
            File::ensureDirectoryExists($dir, 0777);

            if (File::exists($old = $dir . '/' . $page->getOriginal('slug') . '.html')) {
                File::delete($old);
            }

            File::put($dir . '/' . ($path = $page->slug . '.html'), $page->attributes['content']);

            unset($page->attributes['content']);

            $page->path = $path;
        });

        static::deleted(function (Page $page) use ($dir) {
            File::delete($dir . '/' . $page->path);
        });
    }

    /**
     * Get the page's content.
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getContentAttribute(): string
    {
        if (!empty($this->path)) {
            return File::get(storage_path('app/pages/' . $this->path));
        }

        return '';
    }

    /**
     * Get the page's seo meta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'model', 'model', 'model_id');
    }
}
