<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueMultipleColumns implements Rule
{
    public $request;
    public $model;
    public $withColumns;

    /**
     * Create a new rule instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $model
     * @param array                    $withColumns
     */
    public function __construct($request, $model, $withColumns)
    {
        $this->request = $request;
        $this->model = $model;
        $this->withColumns = $withColumns;
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
        $model = $this->model::where($attribute, $value);

        foreach ($this->withColumns as $column) {
            $model->where($column, $this->request->get($column));
        }

        return !$model->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('The :attribute must be unique in: :columns', ['columns' => implode(', ', $this->withColumns)]);
    }
}
