<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Traits;

use Nejcc\PhpDatatypes\Interfaces\NativeIntegerInterface;

trait ArithmeticOperationsTrait
{
    abstract protected function performOperation(
        NativeIntegerInterface $other,
        callable $operation,
        string $operationName
    ): static;

    public function add(NativeIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'addValues'], 'add');
    }

    public function subtract(NativeIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'subtractValues'], 'subtract');
    }

    public function multiply(NativeIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'multiplyValues'], 'multiply');
    }

    public function divide(NativeIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'divideValues'], 'divide');
    }

    public function mod(NativeIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'modValues'], 'mod');
    }

    // The methods addValues, subtractValues, etc., will be implemented in the abstract classes
}
