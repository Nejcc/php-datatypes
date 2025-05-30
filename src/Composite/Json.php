<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Composite;

use InvalidArgumentException;
use JsonException;
use Nejcc\PhpDatatypes\Interfaces\DecoderInterface;
use Nejcc\PhpDatatypes\Interfaces\EncoderInterface;
use Nejcc\PhpDatatypes\Abstract\ArrayAbstraction;

/**
 * Class Json
 * A strict and immutable type for handling JSON data with advanced features.
 */
final class Json extends ArrayAbstraction
{
    /**
     * @var string The JSON string.
     */
    private readonly string $json;

    /**
     * @var array|null The decoded JSON data.
     */
    private ?array $data = null;

    /**
     * @var string|null The JSON schema.
     */
    private ?string $schema = null;

    /**
     * Json constructor.
     *
     * @param string $json The JSON string.
     * @param string|null $schema Optional JSON schema for validation.
     * @throws InvalidArgumentException If the JSON is invalid or does not comply with the schema.
     */
    public function __construct(string $json, ?string $schema = null)
    {
        $this->validateJson($json);
        $this->schema = $schema;
        $this->json = $json;
        parent::__construct([]); // Not used, but required by ArrayAbstraction
    }

    /**
     * Serializes the JSON data to an array.
     *
     * @return array
     * @throws JsonException
     */
    public function toArray(): array
    {
        if ($this->data === null) {
            $this->data = json_decode($this->json, true, 512, JSON_THROW_ON_ERROR);
        }

        return $this->data;
    }

    /**
     * Serializes the JSON data to an object.
     *
     * @return object
     * @throws JsonException
     */
    public function toObject(): object
    {
        return json_decode($this->json, false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Deserializes an array to a Json instance.
     *
     * @param array $data
     * @param string|null $schema
     * @return self
     * @throws InvalidArgumentException
     * @throws JsonException
     */
    public static function fromArray(array $data, ?string $schema = null): self
    {
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        return new self($json, $schema);
    }

    /**
     * Deserializes an object to a Json instance.
     *
     * @param object $object
     * @param string|null $schema
     * @return self
     * @throws InvalidArgumentException
     * @throws JsonException
     */
    public static function fromObject(object $object, ?string $schema = null): self
    {
        $json = json_encode($object, JSON_THROW_ON_ERROR);
        return new self($json, $schema);
    }

    /**
     * Gets the JSON string.
     *
     * @return string
     */
    public function getJson(): string
    {
        return $this->json;
    }

    /**
     * Compresses the JSON string using the provided encoder.
     *
     * @param EncoderInterface $encoder
     * @return string The compressed string.
     */
    public function compress(EncoderInterface $encoder): string
    {
        return $encoder->encode($this->json);
    }

    /**
     * Decompresses the string using the provided decoder.
     *
     * @param DecoderInterface $decoder
     * @param string $compressed
     * @return self
     * @throws InvalidArgumentException
     */
    public static function decompress(DecoderInterface $decoder, string $compressed): self
    {
        $json = $decoder->decode($compressed);
        return new self($json);
    }

    /**
     * Merges this JSON with another Json instance.
     * In case of conflicting keys, values from the other Json take precedence.
     *
     * @param Json $other
     * @return self
     * @throws JsonException
     */
    public function merge(Json $other): self
    {
        $mergedData = array_merge_recursive($this->toArray(), $other->toArray());
        $mergedJson = json_encode($mergedData, JSON_THROW_ON_ERROR);
        return new self($mergedJson, $this->schema);
    }

    /**
     * Updates the JSON data with a given key-value pair.
     *
     * @param string $key
     * @param mixed $value
     * @return self
     * @throws JsonException
     */
    public function update(string $key, mixed $value): self
    {
        $data = $this->toArray();
        $data[$key] = $value;
        $updatedJson = json_encode($data, JSON_THROW_ON_ERROR);
        return new self($updatedJson, $this->schema);
    }

    /**
     * Removes a key from the JSON data.
     *
     * @param string $key
     * @return self
     * @throws JsonException
     */
    public function remove(string $key): self
    {
        $data = $this->toArray();
        unset($data[$key]);
        $updatedJson = json_encode($data, JSON_THROW_ON_ERROR);
        return new self($updatedJson, $this->schema);
    }
}
