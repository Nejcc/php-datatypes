<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

use Nejcc\PhpDatatypes\Interfaces\BigIntegerInterface;
use Nejcc\PhpDatatypes\Interfaces\NativeIntegerInterface;
use Nejcc\PhpDatatypes\Traits\ArithmeticOperationsTrait;
use Nejcc\PhpDatatypes\Traits\IntegerComparisonTrait;

/**
 * Abstract class for big integer types using arbitrary-precision arithmetic.
 *
 * @package Nejcc\PhpDatatypes\Integers
 */
abstract class AbstractBigInteger implements BigIntegerInterface, NativeIntegerInterface
{
    use ArithmeticOperationsTrait;
    use IntegerComparisonTrait;

    protected readonly string $value;

    public const MIN_VALUE = null;
    public const MAX_VALUE = null;

    public function __construct(int|string $value)
    {
        $this->setValue($value);
    }

    protected function setValue(int|string $value): void
    {
        $valueStr = (string)$value;

        if (bccomp($valueStr, (string)static::MIN_VALUE) < 0 || bccomp($valueStr, (string)static::MAX_VALUE) > 0) {
            throw new \OutOfRangeException(sprintf(
                'Value must be between %s and %s.',
                static::MIN_VALUE,
                static::MAX_VALUE
            ));
        }

        $this->value = $valueStr;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    // Implement comparison method
    public function compare(NativeIntegerInterface|BigIntegerInterface $other): int
    {
        return bccomp($this->value, (string)$other->getValue());
    }

    // Implement operation methods required by the trait
    protected function performOperation(
        BigIntegerInterface|NativeIntegerInterface $other,
        callable $operation,
        string $operationName
    ): static {
        $result = $operation($this->value, (string)$other->getValue());

        if (bccomp($result, (string)static::MIN_VALUE) < 0 || bccomp($result, (string)static::MAX_VALUE) > 0) {
            $exceptionClass = bccomp($result, (string)static::MAX_VALUE) > 0 ? \OverflowException::class : \UnderflowException::class;
            throw new $exceptionClass('Result is out of bounds.');
        }

        return new static($result);
    }

    protected function addValues(string $a, string $b): string
    {
        return bcadd($a, $b, 0);
    }

    protected function subtractValues(string $a, string $b): string
    {
        return bcsub($a, $b, 0);
    }

    protected function multiplyValues(string $a, string $b): string
    {
        return bcmul($a, $b, 0);
    }

    protected function divideValues(string $a, string $b): string
    {
        if ($b === '0') {
            throw new \DivisionByZeroError('Division by zero.');
        }

        $result = bcdiv($a, $b, 0);

        if (str_contains($result, '.')) {
            throw new \UnexpectedValueException('Division result is not an integer.');
        }

        return $result;
    }

    protected function modValues(string $a, string $b): string
    {
        if ($b === '0') {
            throw new \DivisionByZeroError('Division by zero.');
        }

        return bcmod($a, $b);
    }
}
