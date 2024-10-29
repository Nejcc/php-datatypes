<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Encoding;

use Nejcc\PhpDatatypes\Interfaces\DecoderInterface;
use Nejcc\PhpDatatypes\Interfaces\EncoderInterface;

/**
 * Class Base64Encoding
 * Implements Base64 encoding.
 */
class Base64Encoding implements EncoderInterface, DecoderInterface
{
    /**
     * Encodes the data using Base64.
     *
     * @param string $data
     * @return string
     */
    public function encode(string $data): string
    {
        return base64_encode($data);
    }

    /**
     * Decodes the data using Base64.
     *
     * @param string $data
     * @return string
     */
    public function decode(string $data): string
    {
        $decoded = base64_decode($data, true);
        if ($decoded === false) {
            throw new \InvalidArgumentException('Base64 decoding failed.');
        }
        return $decoded;
    }
}
