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
            $alias = $def['alias'] ?? $field;
            $type = $def['type'] ?? 'mixed';
            $nullable = $def['nullable'] ?? false;
            $default = $def['default'] ?? null;
            $rules = $def['rules'] ?? [];
            $value = $values[$field] ?? $values[$alias] ?? $default;
            if ($value === null && !$nullable && $default === null && !array_key_exists($field, $values)) {
                throw new InvalidArgumentException("Field '$field' is required and has no value");
            }
            if ($value !== null) {
                $this->validateField($field, $value, $type, $rules, $nullable);
            }
            $this->data[$field] = $value;
        }
    }

    protected function validateField(string $field, $value, $type, array $rules, bool $nullable): void
    {
        if ($value === null && $nullable) {
            return;
        }
        // Type check
        if ($type !== 'mixed' && !$this->isValidType($value, $type)) {
            throw new InvalidArgumentException("Field '$field' must be of type $type");
        }
        // Rules
        foreach ($rules as $rule) {
            if (is_callable($rule)) {
                if (!$rule($value)) {
                    throw new ValidationException("Validation failed for field '$field'");
                }
            }
        }
    }

    protected function isValidType($value, $type): bool
    {
        if ($type === 'int' || $type === 'integer') return is_int($value);
        if ($type === 'float' || $type === 'double') return is_float($value);
        if ($type === 'string') return is_string($value);
        if ($type === 'bool' || $type === 'boolean') return is_bool($value);
        if ($type === 'array') return is_array($value);
        if ($type === 'object') return is_object($value);
        if (class_exists($type)) return $value instanceof $type;
        return true;
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