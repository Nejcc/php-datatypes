<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite\Struct;

/**
 * Pre-compiled struct schema.
 *
 * Schema normalisation (resolving type/nullable/default/rules/alias defaults,
 * detecting the legacy ['field' => 'type'] format, computing the "required"
 * flag) is expensive enough to dominate Struct construction for small payloads.
 * Compile once, construct many.
 *
 * Typical use:
 *
 *     $compiled = CompiledSchema::compile($schema);
 *     foreach ($rows as $row) {
 *         $structs[] = new Struct($compiled, $row);
 *     }
 *
 * Immutable; safe to share between threads/requests/coroutines.
 */
final class CompiledSchema
{
    /**
     * Per-field tuple: [type, nullable, default, rules, alias, required].
     *
     * @var array<string, array{0: string, 1: bool, 2: mixed, 3: array, 4: ?string, 5: bool}>
     */
    public readonly array $fields;

    /**
     * Original (post-BC-conversion) schema, kept so Struct::toArray and
     * friends that walk the schema can still see the user's definitions.
     *
     * @var array<string, array>
     */
    public readonly array $original;

    private function __construct(array $fields, array $original)
    {
        $this->fields = $fields;
        $this->original = $original;
    }

    public static function compile(array $schema): self
    {
        // Legacy format detection: ['id' => 'int', ...] -> wrap each entry.
        $firstKey = array_key_first($schema);
        if ($firstKey !== null && is_string($schema[$firstKey])) {
            $newSchema = [];
            foreach ($schema as $field => $type) {
                $newSchema[$field] = ['type' => $type, 'nullable' => true];
            }
            $schema = $newSchema;
        }

        $compiled = [];
        foreach ($schema as $name => $def) {
            $type = $def['type'] ?? 'mixed';
            $nullable = $def['nullable'] ?? false;
            $default = $def['default'] ?? null;
            $rules = $def['rules'] ?? [];
            $alias = $def['alias'] ?? null;
            $required = !$nullable && $default === null;
            $compiled[$name] = [$type, $nullable, $default, $rules, $alias, $required];
        }

        return new self($compiled, $schema);
    }
}
