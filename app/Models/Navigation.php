<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'link',
        'order',
        'group',
        'display_in',
    ];

    protected $casts = [
        'icon' => 'array',
    ];
}
