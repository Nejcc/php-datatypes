<?php
declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar;

class Byte
{
    /**
     * The byte value between 0 and 255.
     *
     * @var int
     */
    private int $value;

    /**
     * Create a new byte instance.
     *
     * @param  int  $value
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(int $value)
    {
        $this->setValue($value);
    }

    /**
     * Set the byte value ensuring it is between 0 and 255.
     *
     * @param  int  $value
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function setValue(int $value): void
    {
        if ($value < 0 || $value > 255) {
            throw new \InvalidArgumentException('Byte value must be between 0 and 255.');
        }

        $this->value = $value;
    }

    /**
     * Get the byte value.
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Perform a bitwise AND operation on this byte and another.
     *
     * @param  Byte  $byte
     * @return Byte
     */
    public function and(Byte $byte): Byte
    {
        return new self($this->value & $byte->getValue());
    }

    /**
     * Perform a bitwise OR operation on this byte and another.
     *
     * @param  Byte  $byte
     * @return Byte
     */
    public function or(Byte $byte): Byte
    {
        return new self($this->value | $byte->getValue());
    }

    /**
     * Perform a bitwise XOR operation on this byte and another.
     *
     * @param  Byte  $byte
     * @return Byte
     */
    public function xor(Byte $byte): Byte
    {
        return new self($this->value ^ $byte->getValue());
    }

    /**
     * Perform a bitwise NOT operation on this byte.
     *
     * @return Byte
     */
    public function not(): Byte
    {
        return new self(~$this->value & 0xFF); // Ensures the result stays within 8 bits
    }

    /**
     * Shift the bits of this byte to the left.
     *
     * @param  int  $positions
     * @return Byte
     */
    public function shiftLeft(int $positions): Byte
    {
        return new self(($this->value << $positions) & 0xFF); // Prevent overflow
    }

    /**
     * Shift the bits of this byte to the right.
     *
     * @param  int  $positions
     * @return Byte
     */
    public function shiftRight(int $positions): Byte
    {
        return new self($this->value >> $positions);
    }

    /**
     * Determine if this byte is equal to another byte.
     *
     * @param  Byte  $byte
     * @return bool
     */
    public function equals(Byte $byte): bool
    {
        return $this->value === $byte->getValue();
    }

    /**
     * Determine if this byte is greater than another byte.
     *
     * @param  Byte  $byte
     * @return bool
     */
    public function isGreaterThan(Byte $byte): bool
    {
        return $this->value > $byte->getValue();
    }

    /**
     * Determine if this byte is less than another byte.
     *
     * @param  Byte  $byte
     * @return bool
     */
    public function isLessThan(Byte $byte): bool
    {
        return $this->value < $byte->getValue();
    }

    /**
     * Get the binary string representation of the byte.
     *
     * @return string
     */
    public function toBinary(): string
    {
        return sprintf('%08b', $this->value);
    }

    /**
     * Get the hexadecimal string representation of the byte.
     *
     * @return string
     */
    public function toHex(): string
    {
        return sprintf('%02X', $this->value);
    }

    /**
     * Convert the byte value to a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * Create a byte instance from a binary string.
     *
     * @param  string  $binary
     * @return Byte
     */
    public static function fromBinary(string $binary): Byte
    {
        return new self(bindec($binary));
    }

    /**
     * Create a byte instance from a hexadecimal string.
     *
     * @param  string  $hex
     * @return Byte
     */
    public static function fromHex(string $hex): Byte
    {
        return new self(hexdec($hex));
    }

    /**
     * Add an integer to the byte value, wrapping around at 255.
     *
     * @param  int  $number
     * @return Byte
     */
    public function add(int $number): Byte
    {
        return new self(($this->value + $number) & 0xFF); // Wrap around at 255
    }

    /**
     * Subtract an integer from the byte value, wrapping around at 0.
     *
     * @param  int  $number
     * @return Byte
     */
    public function subtract(int $number): Byte
    {
        return new self(($this->value - $number) & 0xFF); // Wrap around at 0
    }
}
