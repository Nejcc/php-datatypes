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
     * Cache of parsed attribute instances keyed by "Class::property".
     *
     * Reflection-driven attribute parsing is the dominant cost on this hot
     * path (newInstance() per attribute, per call). Properties don't change
     * structure at runtime, so we instantiate once and reuse.
     *
     * @var array<string, list<object>>
     */
    private static array $cache = [];

    /**
     * Validate a property value against its attributes.
     */
    public static function validateProperty(
        mixed $value,
        ReflectionProperty $property
    ): void {
        $key = $property->class . '::' . $property->name;
        $instances = self::$cache[$key] ??= self::compileAttributes($property);

        foreach ($instances as $instance) {
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

    /**
     * @return list<object>
     */
    private static function compileAttributes(ReflectionProperty $property): array
    {
        $instances = [];
        foreach ($property->getAttributes() as $attribute) {
            $instances[] = $attribute->newInstance();
        }
        return $instances;
    }

    /**
     * Clear the attribute cache. Useful for long-running processes that
     * reload classes (rare) or for tests that want a clean slate.
     */
    public static function clearCache(): void
    {
        self::$cache = [];
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
