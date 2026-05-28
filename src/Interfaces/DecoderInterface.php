<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Interfaces;

/**
 * Interface DecoderInterface
 * Defines the contract for decoding strategies.
 */
interface DecoderInterface
{
    /**
     * Decodes the given data.
     *
     * @param string $data
     *
     * @return string The decoded data.
     */
    public function decode(string $data): string;
}
