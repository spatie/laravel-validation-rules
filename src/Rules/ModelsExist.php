<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;

class ModelsExist implements Rule
{
    /** @var string */
    protected $modelClassName;

    /** @var string */
    protected $modelAttribute;

    /** @var string */
    protected $attribute;

    /** @var array */
    protected $modelIds;

    public function __construct(string $modelClassName, string $attribute = 'id')
    {
        $this->modelClassName = $modelClassName;

        $this->modelAttribute = $attribute;
    }

    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        $value = array_filter($value);

        $this->modelIds = array_unique($value);

        $modelCount = $this->modelClassName::whereIn($this->modelAttribute, $this->modelIds)->count();

        return count($this->modelIds) === $modelCount;
    }

    public function message(): string
    {
        $modelIds = implode(', ', $this->modelIds);

        $classBasename = class_basename($this->modelClassName);

        return __('validationRules::messages.model_ids', [
            'attribute' => $this->attribute,
            'model' => $classBasename,
            'modelAttribute' => $this->modelAttribute,
            'modelIds' => $modelIds,
        ]);
    }
}
