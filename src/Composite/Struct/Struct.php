<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct;

use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;

class Struct
{
    protected array $data = [];
    protected array $schema = [];

    /**
     * @param array|CompiledSchema $schema Raw schema array, or a pre-compiled
     *                                     schema. The compiled form skips the
     *                                     per-construction normalisation work
     *                                     and is faster when the same schema
     *                                     is used for many instances.
     */
    public function __construct(array|CompiledSchema $schema, array $values = [])
    {
        if ($schema instanceof CompiledSchema) {
            $this->initFromCompiled($schema, $values);
            return;
        }

        // Raw-array path: skip the intermediate CompiledSchema allocation
        // for one-shot callers.
        $firstKey = array_key_first($schema);
        if ($firstKey !== null && is_string($schema[$firstKey])) {
            $newSchema = [];
            foreach ($schema as $field => $type) {
                $newSchema[$field] = ['type' => $type, 'nullable' => true];
            }
            $schema = $newSchema;
        }
        $this->schema = $schema;
        foreach ($schema as $field => $def) {
            $type = $def['type'] ?? 'mixed';
            $nullable = $def['nullable'] ?? false;
            $default = $def['default'] ?? null;
            $rules = $def['rules'] ?? [];

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

    private function initFromCompiled(CompiledSchema $compiled, array $values): void
    {
        $this->schema = $compiled->original;
        foreach ($compiled->fields as $field => $def) {
            // $def is [type, nullable, default, rules, alias, required]
            $alias = $def[4];

            if (isset($values[$field])) {
                $value = $values[$field];
            } elseif (array_key_exists($field, $values)) {
                $value = null;
            } elseif ($alias !== null && array_key_exists($alias, $values)) {
                $value = $values[$alias];
            } elseif ($def[5]) { // required
                throw new InvalidArgumentException("Field '$field' is required and has no value");
            } else {
                $value = $def[2]; // default
            }

            if ($value !== null) {
                $type = $def[0];
                if ($type !== 'mixed' && !self::isValidType($value, $type)) {
                    throw new InvalidArgumentException("Field '$field' must be of type $type");
                }
                $rules = $def[3];
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

    protected function validateField(string $field, mixed $value, string $type, array $rules, bool $nullable): void
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

    /**
     * Fast type check. Static so it doesn't pay a $this dispatch.
     * Match on the common scalar/array types first; only fall back to
     * class_exists() when the type clearly isn't a builtin.
     */
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

    public function get(string $field): mixed
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

    public function set(string $field, mixed $value): void
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

    public function __set(string $field, mixed $value): void
    {
        $this->set($field, $value);
    }

    public function __get(string $field): mixed
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
