<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class OperationLog extends Model
{
    use SearchableTrait;

    public static $methods = [
        'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH',
        'LINK', 'UNLINK', 'COPY', 'HEAD', 'PURGE',
    ];

    protected $fillable = [
        'user_id',
        'path',
        'method',
        'ip',
        'input'
    ];

    /**
     * Log belongs to users.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'id' => 1,
            'user_id' => 2,
            'method' => 4,
            'path' => 3,
            'ip' => 5,
            'input' => 6,
            'created_at' => 7,
        ],
    ];
}
