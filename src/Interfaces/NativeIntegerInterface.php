<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Interfaces;

/**
 * Interface for native integer data types.
 *
 * @package Nejcc\PhpDatatypes\Interfaces
 */
interface NativeIntegerInterface
{
    public function getValue(): int;

    public function add(NativeIntegerInterface $other): static;

    public function subtract(NativeIntegerInterface $other): static;

    public function multiply(NativeIntegerInterface $other): static;

    public function divide(NativeIntegerInterface $other): static;

    public function mod(NativeIntegerInterface $other): static;

    public function equals(NativeIntegerInterface $other): bool;

    public function compare(NativeIntegerInterface $other): int;
}
