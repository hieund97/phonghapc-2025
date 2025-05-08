<?php

namespace App\Models;

use Nicolaslopezj\Searchable\SearchableTrait;

class Role extends \Spatie\Permission\Models\Role
{
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'id' => 1,
            'name' => 10,
            'guard_name' => 5,
        ],
    ];
}
