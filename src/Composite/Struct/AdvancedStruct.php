<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;

class AdvancedStruct
{
    protected array $data = [];
    protected array $schema = [];

    public function __construct(array $schema, array $values = [])
    {
        $this->schema = $schema;
        foreach ($schema as $field => $def) {
            $type = $def['type'] ?? 'mixed';
            $nullable = $def['nullable'] ?? false;
            $default = $def['default'] ?? null;
            $rules = $def['rules'] ?? [];

            // Resolve value: explicit field, then alias, then default.
            if (isset($values[$field])) {
                $value = $values[$field];
            } elseif (array_key_exists($field, $values)) {
                $value = null;
            } elseif (isset($def['alias']) && array_key_exists($def['alias'], $values)) {
                $value = $values[$def['alias']];
            } else {
                $value = $default;
                if ($value === null && !$nullable && $default === null) {
                    throw new InvalidArgumentException("Field '$field' is required and has no value");
                }
            }

            if ($value !== null) {
                if ($type !== 'mixed' && !self::isValidType($value, $type)) {
                    throw new InvalidArgumentException("Field '$field' must be of type $type");
                }
                if ($rules !== []) {
                    foreach ($rules as $rule) {
                        if (is_callable($rule) && !$rule($value)) {
                            throw new ValidationException("Validation failed for field '$field'");
                        }
                    }
                }
            }
            $this->data[$field] = $value;
        }
    }

    protected function validateField(string $field, $value, $type, array $rules, bool $nullable): void
    {
        if ($value === null && $nullable) {
            return;
        }
        if ($type !== 'mixed' && !self::isValidType($value, $type)) {
            throw new InvalidArgumentException("Field '$field' must be of type $type");
        }
        if ($rules !== []) {
            foreach ($rules as $rule) {
                if (is_callable($rule) && !$rule($value)) {
                    throw new ValidationException("Validation failed for field '$field'");
                }
            }
        }
    }

    protected static function isValidType(mixed $value, string $type): bool
    {
        return match ($type) {
            'int', 'integer'   => is_int($value),
            'float', 'double'  => is_float($value),
            'string'           => is_string($value),
            'bool', 'boolean'  => is_bool($value),
            'array'            => is_array($value),
            'object'           => is_object($value),
            default            => class_exists($type) ? $value instanceof $type : true,
        };
    }

    public function get(string $field)
    {
        return $this->data[$field] ?? null;
    }

    public function toArray(bool $useAliases = false): array
    {
        $result = [];
        foreach ($this->schema as $field => $def) {
            $alias = $def['alias'] ?? $field;
            $value = $this->data[$field];
            if ($value instanceof self) {
                $value = $value->toArray($useAliases);
            }
            $result[$useAliases ? $alias : $field] = $value;
        }
        return $result;
    }

    public static function fromArray(array $schema, array $data): self
    {
        return new self($schema, $data);
    }

    public function toJson(bool $useAliases = false): string
    {
        return json_encode($this->toArray($useAliases));
    }

    public static function fromJson(array $schema, string $json): self
    {
        $data = json_decode($json, true);
        return new self($schema, $data);
    }

    public function toXml(bool $useAliases = false): string
    {
        $arr = $this->toArray($useAliases);
        $xml = new \SimpleXMLElement('<struct></struct>');
        foreach ($arr as $k => $v) {
            $xml->addChild($k, htmlspecialchars((string)$v));
        }
        return $xml->asXML();
    }

    public static function fromXml(array $schema, string $xml): self
    {
        $data = @simplexml_load_string($xml);
        $arr = [];
        if ($data !== false) {
            foreach ($data as $k => $v) {
                $arr[$k] = (string)$v;
            }
        }
        return new self($schema, $arr);
    }
} 