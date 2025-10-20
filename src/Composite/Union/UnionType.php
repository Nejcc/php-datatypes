<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Union;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\TypeMismatchException;

/**
 * UnionType - A type that can hold one of several possible types with pattern matching support
 */
final class UnionType
{
    /**
     * @var array<string, mixed> The values for each type key
     */
    private array $values = [];

    /**
     * @var array<string, string> The expected type for each key
     */
    private array $typeMap = [];

    /**
     * @var string|null The current active type key
     */
    private ?string $activeType = null;

    /**
     * A mapping of PHP shorthand types to their gettype() equivalents
     */
    private static array $phpTypeMap = [
        'int' => 'integer',
        'float' => 'double',
        'bool' => 'boolean',
    ];

    /**
     * Create a new UnionType instance
     *
     * @param array<string, string> $typeMap The expected type for each key (e.g. ['string' => 'string', 'int' => 'int'])
     * @param array<string, mixed> $initialValues Optional initial values for each key
     * @throws InvalidArgumentException If no types are provided
     */
    public function __construct(array $typeMap, array $initialValues = [])
    {
        if (empty($typeMap)) {
            throw new InvalidArgumentException('Union type must have at least one possible type');
        }
        $this->typeMap = $typeMap;
        foreach ($typeMap as $key => $expectedType) {
            $this->values[$key] = $initialValues[$key] ?? null;
        }
    }

    /**
     * Get the currently active type
     *
     * @return string
     * @throws InvalidArgumentException if no active type is set
     */
    public function getActiveType(): string
    {
        if ($this->activeType === null) {
            throw new InvalidArgumentException('No active type set');
        }
        return $this->activeType;
    }

    /**
     * Check if a type key is active
     *
     * @param string $key
     * @return bool
     */
    public function isType(string $key): bool
    {
        return $this->activeType === $key;
    }

    /**
     * Get the value of the current active type
     *
     * @return mixed
     * @throws TypeMismatchException
     */
    public function getValue(): mixed
    {
        if ($this->activeType === null) {
            throw new TypeMismatchException('No type is currently active');
        }
        return $this->values[$this->activeType];
    }

    /**
     * Set the value for a specific type key
     *
     * @param string $key
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    public function setValue(string $key, mixed $value): void
    {
        if (!isset($this->typeMap[$key])) {
            throw new InvalidArgumentException("Type key '$key' is not valid in this union");
        }
        $this->validateType($value, $this->typeMap[$key], $key);
        $this->values[$key] = $value;
        $this->activeType = $key;
    }

    /**
     * Get all possible type keys
     *
     * @return array<string>
     */
    public function getTypes(): array
    {
        return array_keys($this->typeMap);
    }

    /**
     * Add a new type to the union
     *
     * @param string $key
     * @param string $expectedType
     * @param mixed $initialValue
     * @throws InvalidArgumentException
     */
    public function addType(string $key, string $expectedType, mixed $initialValue = null): void
    {
        if (isset($this->typeMap[$key])) {
            throw new InvalidArgumentException("Type key '$key' already exists in this union");
        }
        $this->validateType($initialValue, $expectedType, $key);
        $this->typeMap[$key] = $expectedType;
        $this->values[$key] = $initialValue;
    }

    /**
     * Pattern match on the active type
     *
     * @param array<string, callable> $patterns
     * @return mixed
     * @throws TypeMismatchException
     */
    public function match(array $patterns): mixed
    {
        if ($this->activeType === null) {
            throw new TypeMismatchException('No type is currently active');
        }
        if (!isset($patterns[$this->activeType])) {
            throw new TypeMismatchException("No pattern defined for type '{$this->activeType}'");
        }
        return $patterns[$this->activeType]($this->values[$this->activeType]);
    }

    /**
     * Pattern match with a default case
     *
     * @param array<string, callable> $patterns
     * @param callable $default
     * @return mixed
     */
    public function matchWithDefault(array $patterns, callable $default): mixed
    {
        if ($this->activeType === null) {
            return $default();
        }
        if (!isset($patterns[$this->activeType])) {
            return $default();
        }
        return $patterns[$this->activeType]($this->values[$this->activeType]);
    }

    /**
     * String representation
     *
     * @return string
     */
    public function __toString(): string
    {
        if ($this->activeType === null) {
            return 'UnionType<uninitialized>';
        }
        return "UnionType<{$this->activeType}>";
    }

    /**
     * Validate a value against an expected type
     *
     * @param mixed $value
     * @param string $expectedType
     * @param string $key
     * @throws InvalidArgumentException
     */
    private function validateType(mixed $value, string $expectedType, string $key): void
    {
        if ($value === null) {
            return;
        }
        // Handle class instances
        if (class_exists($expectedType) && $value instanceof $expectedType) {
            return;
        }
        // Handle arrays
        if ($expectedType === 'array' && is_array($value)) {
            return;
        }
        // Handle objects
        if ($expectedType === 'object' && is_object($value)) {
            return;
        }
        // Handle primitive types
        $actualType = $this->canonicalTypeName($value);
        $expectedTypeName = $this->canonicalTypeName($expectedType);
        if ($actualType !== $expectedTypeName) {
            throw new InvalidArgumentException(
                "Invalid type for key '$key': expected '$expectedTypeName', got '$actualType'"
            );
        }
    }

    /**
     * Canonical PHP type name for error messages
     *
     * @param mixed|string $valueOrType
     * @return string
     */
    private function canonicalTypeName($valueOrType): string
    {
        if (is_object($valueOrType)) {
            return get_class($valueOrType);
        }
        if (is_string($valueOrType) && class_exists($valueOrType)) {
            return $valueOrType;
        }
        // If this is a type name, return the mapped type
        if (is_string($valueOrType) && in_array($valueOrType, ['int', 'integer', 'float', 'double', 'bool', 'boolean', 'string', 'array', 'object', 'null'])) {
            return self::$phpTypeMap[$valueOrType] ?? $valueOrType;
        }
        // Otherwise, return the type of the value
        $type = gettype($valueOrType);
        return self::$phpTypeMap[$type] ?? $type;
    }

    /**
     * Safely cast the current value to the specified type
     *
     * @param string $type
     * @return mixed
     * @throws TypeMismatchException
     */
    public function castTo(string $type): mixed
    {
        if ($this->activeType === null) {
            throw new TypeMismatchException('No type is currently active');
        }
        if ($this->typeMap[$this->activeType] !== $type && $this->activeType !== $type) {
            throw new TypeMismatchException("Cannot cast active type '{$this->activeType}' to '{$type}'");
        }
        return $this->values[$this->activeType];
    }

    /**
     * Check if this union equals another union
     *
     * @param UnionType $other
     * @return bool
     */
    public function equals(UnionType $other): bool
    {
        if ($this->activeType === null || $other->activeType === null) {
            return false;
        }
        return $this->activeType === $other->activeType && $this->values[$this->activeType] === $other->values[$other->activeType];
    }

    /**
     * Convert the union to a JSON string
     *
     * @return string
     */
    public function toJson(): string
    {
        $data = [
            'activeType' => $this->activeType,
            'value' => $this->activeType !== null ? $this->values[$this->activeType] : null
        ];
        return json_encode($data);
    }

    /**
     * Create a UnionType instance from a JSON string
     *
     * @param string $json
     * @return UnionType
     * @throws InvalidArgumentException
     */
    public static function fromJson(string $json): UnionType
    {
        $data = json_decode($json, true);
        if (!is_array($data) || !isset($data['activeType']) || !isset($data['value'])) {
            throw new InvalidArgumentException('Invalid JSON format for UnionType');
        }
        $union = new UnionType([$data['activeType'] => $data['activeType']]);
        if ($data['activeType'] !== null) {
            $union->setValue($data['activeType'], $data['value']);
        }
        return $union;
    }

    /**
     * Convert the union to an XML string, with optional namespace support
     *
     * @param string|null $namespaceUri
     * @param string|null $prefix
     * @return string
     */
    public function toXml(?string $namespaceUri = null, ?string $prefix = null): string
    {
        if ($namespaceUri && $prefix) {
            $rootName = $prefix . ':union';
            $xml = new \SimpleXMLElement("<{$rootName} xmlns:{$prefix}='{$namespaceUri}'></{$rootName}>");
            $xml->addAttribute('activeType', $this->activeType ?? '');
            if ($this->activeType !== null) {
                $xml->addChild($prefix . ':value', (string)$this->values[$this->activeType], $namespaceUri);
            }
        } else if ($namespaceUri) {
            $xml = new \SimpleXMLElement("<union xmlns='{$namespaceUri}'></union>");
            $xml->addAttribute('activeType', $this->activeType ?? '');
            if ($this->activeType !== null) {
                $xml->addChild('value', (string)$this->values[$this->activeType], $namespaceUri);
            }
        } else {
            $xml = new \SimpleXMLElement('<union></union>');
            $xml->addAttribute('activeType', $this->activeType ?? '');
            if ($this->activeType !== null) {
                $xml->addChild('value', (string)$this->values[$this->activeType]);
            }
        }
        return $xml->asXML();
    }

    /**
     * Create a UnionType instance from an XML string
     *
     * @param string $xml
     * @return UnionType
     * @throws InvalidArgumentException
     */
    public static function fromXml(string $xml): UnionType
    {
        $data = @simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOERROR | LIBXML_NOWARNING);
        if ($data === false || !($data instanceof \SimpleXMLElement) || $data->getName() !== 'union' || !isset($data['activeType'])) {
            throw new InvalidArgumentException('Invalid XML format for UnionType');
        }
        $activeType = (string)$data['activeType'];
        if ($activeType === '') {
            $activeType = null;
        }
        $union = new UnionType([$activeType => $activeType]);
        if ($activeType !== null) {
            // Try to get the namespace URI from the root element
            $namespaces = $data->getNamespaces(true);
            $value = '';
            if (!empty($namespaces)) {
                foreach ($namespaces as $prefix => $uri) {
                    $children = $data->children($uri);
                    if (isset($children->value)) {
                        $value = (string)$children->value;
                        break;
                    }
                }
            }
            if ($value === '') {
                // Fallback to non-namespaced value
                $value = (string)($data->value ?? $data->children()->value ?? '');
                if ($value === '' && count($data->children()) > 0) {
                    foreach ($data->children() as $child) {
                        if ($child->getName() === 'value') {
                            $value = (string)$child;
                            break;
                        }
                    }
                }
            }
            $union->setValue($activeType, $value);
        }
        return $union;
    }

    /**
     * Validate an XML string against an XSD schema
     *
     * @param string $xml
     * @param string $xsd
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function validateXmlSchema(string $xml, string $xsd): bool
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        if (!$dom->loadXML($xml)) {
            throw new InvalidArgumentException('Invalid XML provided for schema validation');
        }
        $result = $dom->schemaValidateSource($xsd);
        if (!$result) {
            $errors = libxml_get_errors();
            libxml_clear_errors();
            $errorMsg = isset($errors[0]) ? $errors[0]->message : 'Unknown schema validation error';
            throw new InvalidArgumentException('XML does not validate against schema: ' . $errorMsg);
        }
        return true;
    }

    /**
     * Convert the union to a binary string using PHP's serialize
     *
     * @return string
     */
    public function toBinary(): string
    {
        $data = [
            'activeType' => $this->activeType,
            'value' => $this->activeType !== null ? $this->values[$this->activeType] : null
        ];
        return serialize($data);
    }

    /**
     * Create a UnionType instance from a binary string
     *
     * @param string $binary
     * @return UnionType
     * @throws InvalidArgumentException
     */
    public static function fromBinary(string $binary): UnionType
    {
        $data = @unserialize($binary);
        if ($data === false || !is_array($data) || !isset($data['activeType']) || !isset($data['value'])) {
            throw new InvalidArgumentException('Invalid binary format for UnionType');
        }
        $union = new UnionType([$data['activeType'] => $data['activeType']]);
        if ($data['activeType'] !== null) {
            $union->setValue($data['activeType'], $data['value']);
        }
        return $union;
    }
} 