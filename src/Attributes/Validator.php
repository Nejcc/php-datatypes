<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Attributes;

use ReflectionProperty;
use OutOfRangeException;
use InvalidArgumentException;

/**
 * Validator helper class for attribute-based validation
 */
final class Validator
{
    /**
     * Validate a property value against its attributes
     */
    public static function validateProperty(
        mixed $value,
        ReflectionProperty $property
    ): void {
        foreach ($property->getAttributes() as $attribute) {
            $instance = $attribute->newInstance();
            match (true) {
                $instance instanceof Range => self::validateRange($value, $instance),
                $instance instanceof Email => self::validateEmail($value),
                $instance instanceof Regex => self::validateRegex($value, $instance),
                $instance instanceof NotNull => self::validateNotNull($value),
                $instance instanceof Length => self::validateLength($value, $instance),
                $instance instanceof Url => self::validateUrl($value),
                $instance instanceof Uuid => self::validateUuid($value),
                $instance instanceof IpAddress => self::validateIpAddress($value),
            };
        }
    }

    private static function validateRange(mixed $value, Range $range): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Value must be numeric for range validation');
        }

        $numValue = is_string($value) ? (float) $value : $value;
        
        if ($numValue < $range->min || $numValue > $range->max) {
            throw new OutOfRangeException(
                sprintf('Value must be between %s and %s', $range->min, $range->max)
            );
        }
    }

    private static function validateEmail(mixed $value): void
    {
        if (!is_string($value) || !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address');
        }
    }

    private static function validateRegex(mixed $value, Regex $regex): void
    {
        if (!is_string($value) || !preg_match($regex->pattern, $value)) {
            throw new InvalidArgumentException('Value does not match required pattern');
        }
    }

    private static function validateNotNull(mixed $value): void
    {
        if ($value === null) {
            throw new InvalidArgumentException('Value cannot be null');
        }
    }

    private static function validateLength(mixed $value, Length $length): void
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Value must be a string for length validation');
        }

        $strLength = strlen($value);
        
        if ($length->min !== null && $strLength < $length->min) {
            throw new InvalidArgumentException(
                sprintf('String length must be at least %d characters', $length->min)
            );
        }
        
        if ($length->max !== null && $strLength > $length->max) {
            throw new InvalidArgumentException(
                sprintf('String length must be at most %d characters', $length->max)
            );
        }
    }

    private static function validateUrl(mixed $value): void
    {
        if (!is_string($value) || !filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL');
        }
    }

    private static function validateUuid(mixed $value): void
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Value must be a string for UUID validation');
        }

        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';
        if (!preg_match($pattern, $value)) {
            throw new InvalidArgumentException('Invalid UUID format');
        }
    }

    private static function validateIpAddress(mixed $value): void
    {
        if (!is_string($value) || !filter_var($value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException('Invalid IP address');
        }
    }
}
