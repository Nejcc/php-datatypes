<?php
declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Scalar;

class Char
{
    /**
     * The character value.
     *
     * @var string
     */
    private string $value;

    /**
     * Create a new Char instance.
     *
     * @param  string  $value
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (strlen($value) !== 1) {
            throw new \InvalidArgumentException('Char must be a single character.');
        }

        $this->value = $value;
    }

    /**
     * Get the character value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Convert the character to its uppercase representation.
     *
     * @return Char
     */
    public function toUpperCase(): Char
    {
        return new self(strtoupper($this->value));
    }

    /**
     * Convert the character to its lowercase representation.
     *
     * @return Char
     */
    public function toLowerCase(): Char
    {
        return new self(strtolower($this->value));
    }

    /**
     * Determine if the character is a letter.
     *
     * @return bool
     */
    public function isLetter(): bool
    {
        return ctype_alpha($this->value);
    }

    /**
     * Determine if the character is a digit.
     *
     * @return bool
     */
    public function isDigit(): bool
    {
        return ctype_digit($this->value);
    }

    /**
     * Determine if the character is an uppercase letter.
     *
     * @return bool
     */
    public function isUpperCase(): bool
    {
        return ctype_upper($this->value);
    }

    /**
     * Determine if the character is a lowercase letter.
     *
     * @return bool
     */
    public function isLowerCase(): bool
    {
        return ctype_lower($this->value);
    }

    /**
     * Compare the current character with another Char instance.
     *
     * @param  Char  $char
     * @return bool
     */
    public function equals(Char $char): bool
    {
        return $this->value === $char->getValue();
    }

    /**
     * Convert the character to its ASCII code.
     *
     * @return int
     */
    public function toAscii(): int
    {
        return ord($this->value);
    }

    /**
     * Convert the ASCII code to a Char.
     *
     * @param  int  $ascii
     * @return Char
     */
    public static function fromAscii(int $ascii): Char
    {
        if ($ascii < 0 || $ascii > 255) {
            throw new \InvalidArgumentException('ASCII value must be between 0 and 255.');
        }

        return new self(chr($ascii));
    }

    /**
     * Convert the character to a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
