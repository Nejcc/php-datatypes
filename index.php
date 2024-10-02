<?php

use Nejcc\PhpDatatypes\Integers\Signed\Int128;
use Nejcc\PhpDatatypes\Integers\Signed\Int16;
use Nejcc\PhpDatatypes\Integers\Signed\Int32;
use Nejcc\PhpDatatypes\Integers\Signed\Int64;
use Nejcc\PhpDatatypes\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Integers\Unsigned\UInt8;

require_once __DIR__ . '/vendor/autoload.php';

class test
{
    public Int8 $min;
    public UInt8 $minU;
    public Int16 $max;
    public Int32 $max2;
//    public Int64 $max3;
//    public Int128 $max4;

    public function __construct(int $int, int $max, int $max2, int $max3, int $max4)
    {
        $this->minU = uint8(1);
//        $this->min = int8($int);
//        $this->max = int16($max);
//        $this->max2 = int32($max2);
//        $this->max3 = int64($max3);
//        $this->max4 = int128($max4);
    }

    public function __invoke(): Int8
    {
        return $this->min;
    }
}

$c = new test(8, 20000, 23213,23213,123123);
var_dump($c);


