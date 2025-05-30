<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct\Rules;

use Nejcc\PhpDatatypes\Composite\Struct\ValidationRule;

final class CompositeRule implements ValidationRule
{
    /**
     * @var ValidationRule[]
     */
    private array $rules;

    /**
     * Create a new composite validation rule
     *
     * @param ValidationRule ...$rules The rules to combine
     */
    public function __construct(ValidationRule ...$rules)
    {
        $this->rules = $rules;
    }

    public function validate(mixed $value, string $fieldName): bool
    {
        foreach ($this->rules as $rule) {
            $rule->validate($value, $fieldName);
        }

        return true;
    }

    /**
     * Create a new composite rule from an array of rules
     *
     * @param ValidationRule[] $rules
     *
     * @return self
     */
    public static function fromArray(array $rules): self
    {
        return new self(...$rules);
    }

    /**
     * Add a rule to the composite
     *
     * @param ValidationRule $rule
     *
     * @return self A new composite rule with the added rule
     */
    public function withRule(ValidationRule $rule): self
    {
        return new self(...array_merge($this->rules, [$rule]));
    }
}
