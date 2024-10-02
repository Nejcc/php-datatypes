<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Interfaces;

/**
 * Interface for big integer data types using arbitrary-precision arithmetic.
 *
 * @package Nejcc\PhpDatatypes\Interfaces
 */
interface BigIntegerInterface
{
    public function getValue(): string;

    public function add(BigIntegerInterface $other): static;

    public function subtract(BigIntegerInterface $other): static;

    public function multiply(BigIntegerInterface $other): static;

    public function divide(BigIntegerInterface $other): static;

    public function mod(BigIntegerInterface $other): static;

    public function equals(BigIntegerInterface $other): bool;

    public function compare(BigIntegerInterface $other): int;
}
