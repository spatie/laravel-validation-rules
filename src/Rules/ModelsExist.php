<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;

class ModelsExist implements Rule
{
    /** @var string */
    protected $modelClassName;

    /** @var string */
    protected $attribute;

    public function __construct(string $modelClassName, string $attribute = 'id')
    {
        $this->modelClassName = $modelClassName;

        $this->attribute = $attribute;
    }

    public function passes($attribute, $value): bool
    {
        $value = array_filter($value);

        $modelIds = array_unique($value);

        $modelCount = $this->modelClassName::whereIn($this->attribute, $modelIds)->count();

        return count($modelIds) === $modelCount;
    }

    public function message(): string
    {
        return __('validation.model_ids');
    }
}
