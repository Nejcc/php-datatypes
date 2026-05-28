<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Traits;

use Nejcc\PhpDatatypes\Interfaces\NativeIntegerInterface;

trait NativeArithmeticOperationsTrait
{
    #[\NoDiscard('add() returns a new immutable instance; the original is unchanged so discarding the result is always a bug')]
    public function add(NativeIntegerInterface $other): static
    {
        $result = $this->value + $other->getValue();
        if ($result > static::MAX_VALUE) {
            throw new \OverflowException('Result is out of bounds.');
        }
        if ($result < static::MIN_VALUE) {
            throw new \UnderflowException('Result is out of bounds.');
        }
        return new static($result, true);
    }

    #[\NoDiscard('subtract() returns a new immutable instance; the original is unchanged so discarding the result is always a bug')]
    public function subtract(NativeIntegerInterface $other): static
    {
        $result = $this->value - $other->getValue();
        if ($result > static::MAX_VALUE) {
            throw new \OverflowException('Result is out of bounds.');
        }
        if ($result < static::MIN_VALUE) {
            throw new \UnderflowException('Result is out of bounds.');
        }
        return new static($result, true);
    }

    #[\NoDiscard('multiply() returns a new immutable instance; the original is unchanged so discarding the result is always a bug')]
    public function multiply(NativeIntegerInterface $other): static
    {
        $result = $this->value * $other->getValue();
        if ($result > static::MAX_VALUE) {
            throw new \OverflowException('Result is out of bounds.');
        }
        if ($result < static::MIN_VALUE) {
            throw new \UnderflowException('Result is out of bounds.');
        }
        return new static($result, true);
    }

    #[\NoDiscard('divide() returns a new immutable instance; the original is unchanged so discarding the result is always a bug')]
    public function divide(NativeIntegerInterface $other): static
    {
        $b = $other->getValue();
        if ($b === 0) {
            throw new \DivisionByZeroError('Division by zero.');
        }
        $a = $this->value;
        if ($a % $b !== 0) {
            throw new \UnexpectedValueException('Division result is not an integer.');
        }
        $result = intdiv($a, $b);
        if ($result > static::MAX_VALUE) {
            throw new \OverflowException('Result is out of bounds.');
        }
        if ($result < static::MIN_VALUE) {
            throw new \UnderflowException('Result is out of bounds.');
        }
        return new static($result, true);
    }

    #[\NoDiscard('mod() returns a new immutable instance; the original is unchanged so discarding the result is always a bug')]
    public function mod(NativeIntegerInterface $other): static
    {
        $b = $other->getValue();
        if ($b === 0) {
            throw new \DivisionByZeroError('Division by zero.');
        }
        $result = $this->value % $b;
        if ($result > static::MAX_VALUE) {
            throw new \OverflowException('Result is out of bounds.');
        }
        if ($result < static::MIN_VALUE) {
            throw new \UnderflowException('Result is out of bounds.');
        }
        return new static($result, true);
    }

}
