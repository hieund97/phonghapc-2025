<?php

namespace App\Rules;

use DB;
use Illuminate\Contracts\Validation\Rule;

class ArrayPrimary implements Rule
{
    public $table;
    public $primary;

    /**
     * Create a new rule instance.
     *
     * @param string $table
     * @param string $primary
     */
    public function __construct(string $table, string $primary = 'id')
    {
        $this->table = $table;
        $this->primary = $primary;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $data = DB::table($this->table)->whereIn($this->primary, $value)->count();

        return $data == count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('The :attribute is invalid.');
    }
}
