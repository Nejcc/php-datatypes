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
    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param BigIntegerInterface $other
     *
     * @return $this
     */
    public function add(BigIntegerInterface $other): static;

    /**
     * @param BigIntegerInterface $other
     *
     * @return $this
     */
    public function subtract(BigIntegerInterface $other): static;

    /**
     * @param BigIntegerInterface $other
     *
     * @return $this
     */
    public function multiply(BigIntegerInterface $other): static;

    /**
     * @param BigIntegerInterface $other
     *
     * @return $this
     */
    public function divide(BigIntegerInterface $other): static;

    /**
     * @param BigIntegerInterface $other
     *
     * @return $this
     */
    public function mod(BigIntegerInterface $other): static;

    /**
     * @param BigIntegerInterface $other
     *
     * @return bool
     */
    public function equals(BigIntegerInterface $other): bool;

    /**
     * @param BigIntegerInterface $other
     *
     * @return int
     */
    public function compare(BigIntegerInterface $other): int;
}
