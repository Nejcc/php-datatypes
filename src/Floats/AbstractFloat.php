<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Floats;

abstract class AbstractFloat implements FloatInterface
{
    protected float|string $value;

    public function __construct(float|string $value)
    {
        $this->value = $value;
    }

    public function getValue(): float|string
    {
        return $this->value;
    }

    public function equals(FloatInterface $other): bool
    {
        return bccomp((string)$this->value, (string)$other->getValue(), $this->getScale()) === 0;
    }

    public function compare(FloatInterface $other): int
    {
        return bccomp((string)$this->value, (string)$other->getValue(), $this->getScale());
    }

    abstract protected function getScale(): int;

    // Abstract methods for arithmetic operations
    abstract public function add(FloatInterface $other): static;

    abstract public function subtract(FloatInterface $other): static;

    abstract public function multiply(FloatInterface $other): static;

    abstract public function divide(FloatInterface $other): static;
}
