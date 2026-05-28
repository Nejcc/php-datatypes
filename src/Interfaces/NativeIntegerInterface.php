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
    /**
     * @return int
     */
    public function getValue(): int;

    /**
     * @param NativeIntegerInterface $other
     *
     * @return $this
     */
    public function add(NativeIntegerInterface $other): static;

    /**
     * @param NativeIntegerInterface $other
     *
     * @return $this
     */
    public function subtract(NativeIntegerInterface $other): static;

    /**
     * @param NativeIntegerInterface $other
     *
     * @return $this
     */
    public function multiply(NativeIntegerInterface $other): static;

    /**
     * @param NativeIntegerInterface $other
     *
     * @return $this
     */
    public function divide(NativeIntegerInterface $other): static;

    /**
     * @param NativeIntegerInterface $other
     *
     * @return $this
     */
    public function mod(NativeIntegerInterface $other): static;

    /**
     * @param NativeIntegerInterface $other
     *
     * @return bool
     */
    public function equals(NativeIntegerInterface $other): bool;

    /**
     * @param NativeIntegerInterface $other
     *
     * @return int
     */
    public function compare(NativeIntegerInterface $other): int;
}
