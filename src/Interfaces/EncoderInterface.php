<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Interfaces;

/**
 * Interface EncoderInterface
 * Defines the contract for encoding strategies.
 */
interface EncoderInterface
{
    /**
     * Encodes the given data.
     *
     * @param string $data
     * @return string The encoded data.
     */
    public function encode(string $data): string;
}
