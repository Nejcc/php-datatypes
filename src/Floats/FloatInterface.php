<?php

namespace Nejcc\PhpDatatypes\Floats;

interface FloatInterface
{
    public function getValue(): float|string;

    public function add(FloatInterface $other): static;

    public function subtract(FloatInterface $other): static;

    public function multiply(FloatInterface $other): static;

    public function divide(FloatInterface $other): static;

    public function equals(FloatInterface $other): bool;

    public function compare(FloatInterface $other): int;
}
