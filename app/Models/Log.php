<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'action',
        'loggable_type',
        'loggable_id',
        'loggable_content',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'loggable_content' => 'array',
    ];

    /**
     * Get the owning loggable model.
     */
    public function loggable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user that owns the log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
