<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;

class ModelIds implements Rule
{
    /** @var string */
    protected $modelClassName;

    /** @var string */
    protected $column;

    public function __construct(string $modelClassName, string $column = 'id')
    {
        $this->modelClassName = $modelClassName;
        $this->column = $column;
    }

    public function passes($attribute, $value)
    {
        $value = array_filter($value);

        $modelIds = array_unique($value);

        $modelCount = $this->modelClassName::whereIn($this->column, $modelIds)->count();

        return count($modelIds) === $modelCount;
    }

    public function message()
    {
        return __('validationRules.model_ids');
    }
}
