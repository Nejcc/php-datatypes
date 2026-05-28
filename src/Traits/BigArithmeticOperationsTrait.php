<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Traits;

use Nejcc\PhpDatatypes\Interfaces\BigIntegerInterface;

trait BigArithmeticOperationsTrait
{
    #[\NoDiscard('add() returns a new immutable instance; the original is unchanged so discarding the result is always a bug')]
    public function add(BigIntegerInterface $other): static
    {
        $result = bcadd($this->value, (string)$other->getValue(), 0);
        if (bccomp($result, (string)static::MAX_VALUE) > 0) {
            throw new \OverflowException('Result is out of bounds.');
        }
        if (bccomp($result, (string)static::MIN_VALUE) < 0) {
            throw new \UnderflowException('Result is out of bounds.');
        }
        return new static($result, true);
    }

    #[\NoDiscard('subtract() returns a new immutable instance; the original is unchanged so discarding the result is always a bug')]
    public function subtract(BigIntegerInterface $other): static
    {
        $result = bcsub($this->value, (string)$other->getValue(), 0);
        if (bccomp($result, (string)static::MAX_VALUE) > 0) {
            throw new \OverflowException('Result is out of bounds.');
        }
        if (bccomp($result, (string)static::MIN_VALUE) < 0) {
            throw new \UnderflowException('Result is out of bounds.');
        }
        return new static($result, true);
    }

    #[\NoDiscard('multiply() returns a new immutable instance; the original is unchanged so discarding the result is always a bug')]
    public function multiply(BigIntegerInterface $other): static
    {
        $result = bcmul($this->value, (string)$other->getValue(), 0);
        if (bccomp($result, (string)static::MAX_VALUE) > 0) {
            throw new \OverflowException('Result is out of bounds.');
        }
        if (bccomp($result, (string)static::MIN_VALUE) < 0) {
            throw new \UnderflowException('Result is out of bounds.');
        }
        return new static($result, true);
    }

    #[\NoDiscard('divide() returns a new immutable instance; the original is unchanged so discarding the result is always a bug')]
    public function divide(BigIntegerInterface $other): static
    {
        $b = (string)$other->getValue();
        if ($b === '0') {
            throw new \DivisionByZeroError('Division by zero.');
        }
        if (bcmod($this->value, $b) !== '0') {
            throw new \UnexpectedValueException('Division result is not an integer.');
        }
        $result = bcdiv($this->value, $b, 0);
        if (bccomp($result, (string)static::MAX_VALUE) > 0) {
            throw new \OverflowException('Result is out of bounds.');
        }
        if (bccomp($result, (string)static::MIN_VALUE) < 0) {
            throw new \UnderflowException('Result is out of bounds.');
        }
        return new static($result, true);
    }

    #[\NoDiscard('mod() returns a new immutable instance; the original is unchanged so discarding the result is always a bug')]
    public function mod(BigIntegerInterface $other): static
    {
        $b = (string)$other->getValue();
        if ($b === '0') {
            throw new \DivisionByZeroError('Division by zero.');
        }
        $result = bcmod($this->value, $b);
        if (bccomp($result, (string)static::MAX_VALUE) > 0) {
            throw new \OverflowException('Result is out of bounds.');
        }
        if (bccomp($result, (string)static::MIN_VALUE) < 0) {
            throw new \UnderflowException('Result is out of bounds.');
        }
        return new static($result, true);
    }

}
