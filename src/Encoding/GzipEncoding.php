<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Encoding;

use Nejcc\PhpDatatypes\Interfaces\DecoderInterface;
use Nejcc\PhpDatatypes\Interfaces\EncoderInterface;

/**
 * Class GzipEncoding
 * Implements Gzip compression.
 */
final class GzipEncoding implements DecoderInterface, EncoderInterface
{
    /**
     * Encodes the data using Gzip.
     *
     * @param string $data
     *
     * @return string
     */
    public function encode(string $data): string
    {
        $compressed = gzencode($data, 9);
        if ($compressed === false) {
            throw new \RuntimeException('Gzip encoding failed.');
        }
        return $compressed;
    }

    /**
     * Decodes the data using Gzip.
     *
     * @param string $data
     *
     * @return string
     */
    public function decode(string $data): string
    {
        $decoded = gzdecode($data);
        if ($decoded === false) {
            throw new \InvalidArgumentException('Gzip decoding failed.');
        }
        return $decoded;
    }
}
