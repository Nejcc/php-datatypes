<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Traits;

use Nejcc\PhpDatatypes\Interfaces\NativeIntegerInterface;

trait NativeArithmeticOperationsTrait
{
    /**
     * @param NativeIntegerInterface $other
     * @param callable $operation
     * @param string $operationName
     * @return $this
     */
    abstract protected function performOperation(
        NativeIntegerInterface $other,
        callable $operation,
        string $operationName
    ): static;

    /**
     * @param NativeIntegerInterface $other
     * @return $this
     */
    public function add(NativeIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'addValues'], 'add');
    }

    /**
     * @param NativeIntegerInterface $other
     * @return $this
     */
    public function subtract(NativeIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'subtractValues'], 'subtract');
    }

    /**
     * @param NativeIntegerInterface $other
     * @return $this
     */
    public function multiply(NativeIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'multiplyValues'], 'multiply');
    }

    /**
     * @param NativeIntegerInterface $other
     * @return $this
     */
    public function divide(NativeIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'divideValues'], 'divide');
    }

    /**
     * @param NativeIntegerInterface $other
     * @return $this
     */
    public function mod(NativeIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'modValues'], 'mod');
    }
}
