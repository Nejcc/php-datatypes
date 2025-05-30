<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Traits;

use Nejcc\PhpDatatypes\Interfaces\BigIntegerInterface;

trait BigArithmeticOperationsTrait
{
    /**
     * @param BigIntegerInterface $other
     *
     * @return $this
     */
    public function add(BigIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'addValues'], 'add');
    }

    /**
     * @param BigIntegerInterface $other
     *
     * @return $this
     */
    public function subtract(BigIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'subtractValues'], 'subtract');
    }

    /**
     * @param BigIntegerInterface $other
     *
     * @return $this
     */
    public function multiply(BigIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'multiplyValues'], 'multiply');
    }

    /**
     * @param BigIntegerInterface $other
     *
     * @return $this
     */
    public function divide(BigIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'divideValues'], 'divide');
    }

    /**
     * @param BigIntegerInterface $other
     *
     * @return $this
     */
    public function mod(BigIntegerInterface $other): static
    {
        return $this->performOperation($other, [$this, 'modValues'], 'mod');
    }
    /**
     * @param BigIntegerInterface $other
     * @param callable $operation
     * @param string $operationName
     *
     * @return $this
     */
    abstract protected function performOperation(
        BigIntegerInterface $other,
        callable $operation,
        string $operationName
    ): static;
}
