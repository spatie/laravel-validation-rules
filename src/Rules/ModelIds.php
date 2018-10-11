<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;

class ModelIds implements Rule
{
    /** @var string */
    protected $modelClassName;

    public function __construct(string $modelClassName)
    {
        $this->modelClassName = $modelClassName;
    }

    public function passes($attribute, $value)
    {
        $value = array_filter($value);

        $modelIds = array_unique($value);

        $modelCount = $this->modelClassName::whereIn('id', $modelIds)->count();

        return count($modelIds) === $modelCount;
    }

    public function message()
    {
        return __('validationRules.model_ids');
    }
}
