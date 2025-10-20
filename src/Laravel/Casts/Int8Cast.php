<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Laravel\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;

/**
 * Eloquent cast for Int8 values
 */
final class Int8Cast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Int8|null
     */
    public function get($model, $key, $value, $attributes): ?Int8
    {
        if ($value === null) {
            return null;
        }

        return new Int8((int) $value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param Int8|mixed $value
     * @param array $attributes
     * @return int|null
     */
    public function set($model, $key, $value, $attributes): ?int
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Int8) {
            return $value->getValue();
        }

        return (int) $value;
    }
}
