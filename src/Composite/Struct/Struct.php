<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;

class Struct
{
    protected array $data = [];
    protected array $schema = [];

    public function __construct(array $schema, array $values = [])
    {
        // Backward compatibility: convert old format ['id' => 'int', ...] to new format
        $first = reset($schema);
        if (is_string($first)) {
            $newSchema = [];
            foreach ($schema as $field => $type) {
                $newSchema[$field] = ['type' => $type, 'nullable' => true];
            }
            $schema = $newSchema;
        }
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
        if (!array_key_exists($field, $this->schema)) {
            throw new InvalidArgumentException("Field '$field' does not exist in the struct.");
        }
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
                $type = $schema[$k]['type'] ?? 'mixed';
                $value = (string)$v;
                // Cast to appropriate type
                if ($type === 'int' || $type === 'integer') {
                    $value = (int)$value;
                } elseif ($type === 'float' || $type === 'double') {
                    $value = (float)$value;
                } elseif ($type === 'bool' || $type === 'boolean') {
                    $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                }
                $arr[$k] = $value;
            }
        }
        return new self($schema, $arr);
    }

    public function set(string $field, $value): void
    {
        if (!array_key_exists($field, $this->schema)) {
            throw new InvalidArgumentException("Field '$field' does not exist in the struct.");
        }
        $def = $this->schema[$field];
        $type = $def['type'] ?? 'mixed';
        $nullable = $def['nullable'] ?? false;
        $rules = $def['rules'] ?? [];
        if ($value === null && !$nullable) {
            throw new InvalidArgumentException("Field '$field' cannot be null");
        }
        $this->validateField($field, $value, $type, $rules, $nullable);
        $this->data[$field] = $value;
    }

    public function __set($field, $value): void
    {
        $this->set($field, $value);
    }

    public function __get($field)
    {
        return $this->get($field);
    }

    public function getFields(): array
    {
        $fields = [];
        foreach ($this->schema as $field => $def) {
            $fields[$field] = [
                'type' => $def['type'] ?? 'mixed',
                'value' => $this->data[$field] ?? null,
            ];
        }
        return $fields;
    }

    public function addField(string $field, string $type): void
    {
        if (array_key_exists($field, $this->schema)) {
            throw new InvalidArgumentException("Field '$field' already exists in the struct.");
        }
        $this->schema[$field] = ['type' => $type, 'nullable' => true];
        $this->data[$field] = null;
    }
}
