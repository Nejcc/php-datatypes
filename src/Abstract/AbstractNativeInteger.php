<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Abstract;

use Nejcc\PhpDatatypes\Interfaces\NativeIntegerInterface;
use Nejcc\PhpDatatypes\Traits\ArithmeticOperationsTrait;
use Nejcc\PhpDatatypes\Traits\IntegerComparisonTrait;

/**
 * Abstract class for native integer types.
 *
 * @package Nejcc\PhpDatatypes\Integers
 */
abstract class AbstractNativeInteger implements NativeIntegerInterface
{
    use ArithmeticOperationsTrait;
    use IntegerComparisonTrait;

    protected readonly int $value;

    public const MIN_VALUE = null;
    public const MAX_VALUE = null;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->setValue($value);
    }

    /**
     * @param int $value
     * @return void
     */
    protected function setValue(int $value): void
    {
        if ($value < static::MIN_VALUE || $value > static::MAX_VALUE) {
            throw new \OutOfRangeException(sprintf(
                'Value must be between %d and %d.',
                static::MIN_VALUE,
                static::MAX_VALUE
            ));
        }

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param NativeIntegerInterface $other
     * @return int
     */
    public function compare(NativeIntegerInterface $other): int
    {
        return $this->value <=> $other->getValue();
    }

    /**
     * @param NativeIntegerInterface $other
     * @param callable $operation
     * @param string $operationName
     * @return $this
     */
    protected function performOperation(
        NativeIntegerInterface $other,
        callable $operation,
        string $operationName
    ): static {
        $result = $operation($this->value, $other->getValue());

        if ($result < static::MIN_VALUE || $result > static::MAX_VALUE) {
            $exceptionClass = $result > static::MAX_VALUE ? \OverflowException::class : \UnderflowException::class;
            throw new $exceptionClass('Result is out of bounds.');
        }

        return new static($result);
    }

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    protected function addValues(int $a, int $b): int
    {
        return $a + $b;
    }

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    protected function subtractValues(int $a, int $b): int
    {
        return $a - $b;
    }

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    protected function multiplyValues(int $a, int $b): int
    {
        return $a * $b;
    }

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    protected function divideValues(int $a, int $b): int
    {
        if ($b === 0) {
            throw new \DivisionByZeroError('Division by zero.');
        }

        if ($a % $b !== 0) {
            throw new \UnexpectedValueException('Division result is not an integer.');
        }

        return intdiv($a, $b);
    }

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    protected function modValues(int $a, int $b): int
    {
        if ($b === 0) {
            throw new \DivisionByZeroError('Division by zero.');
        }

        return $a % $b;
    }
}
