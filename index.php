<?php

use Nejcc\PhpDatatypes\Integers\Signed\Int16;
use Nejcc\PhpDatatypes\Integers\Signed\Int32;
use Nejcc\PhpDatatypes\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Integers\Unsigned\UInt8;

require_once __DIR__ . '/vendor/autoload.php';

class test
{
    public \Nejcc\PhpDatatypes\Floats\Float8 $min;

    public function __construct(int $int)
    {
        $this->min = float8($int);
    }

    public function __invoke(): \Nejcc\PhpDatatypes\Floats\Float8
    {
        return $this->min;
    }
}

$c = new test(8);
var_dump($c);


