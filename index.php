<?php

use Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice;
use Nejcc\PhpDatatypes\Composite\Arrays\FloatArray;
use Nejcc\PhpDatatypes\Composite\Arrays\IntArray;
use Nejcc\PhpDatatypes\Composite\Arrays\StringArray;
use Nejcc\PhpDatatypes\Composite\Dictionary;
use Nejcc\PhpDatatypes\Composite\ListData;
use Nejcc\PhpDatatypes\Composite\Struct\Struct;
use Nejcc\PhpDatatypes\Scalar\Byte;
use Nejcc\PhpDatatypes\Scalar\Char;
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32;
use Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float64;
use Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8;
use Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32;

require_once __DIR__ . '/vendor/autoload.php';

final class TestExamples
{
    private Float32 $account_balance;
    private Float64 $investment_amount;
    private Char $grade;
    private Byte $age;
    private StringArray $names;
    private IntArray $scores;
    private FloatArray $weights;
    private ByteSlice $data;
    private Int8 $years;
    private UInt32 $account_number;
    private ListData $listData;
    private Dictionary $dictionary;
    private Struct $struct;

    public function __construct()
    {
        $this->years = int8(33);
        $this->account_number = uint32(343233);
        // Scalar Types
        $this->account_balance = float32(1234.56);
        $this->investment_amount = float64(78910.12345);
        $this->grade = new Char('A');
        $this->age = new Byte(25);

        // Composite Types (Arrays)
        $this->names = new StringArray(['John', 'Jane', 'Doe']);
        $this->scores = new IntArray([100, 95, 87]);
        $this->weights = new FloatArray([60.5, 72.3, 88.9]);
        $this->data = new ByteSlice([255, 128, 0]);

        $this->listData = new ListData(['apple', 'banana', 'orange']);
        $this->dictionary = new Dictionary(['name' => 'Nejc', 'age' => 99, 'country' => 'Slovenia']);

        $this->struct = new Struct([
            'name'    => 'string',
            'age'     => 'int',
            'balance' => 'float'
        ]);

        // Setting field values
        $this->struct->set('name', 'Nejc');
        $this->struct->set('age', 30);
        $this->struct->set('balance', 250.75);


    }

    public function getExamples(): array
    {
        /*
         * Test only
            array (size=10)
              'years' =>
                object(Nejcc\PhpDatatypes\Scalar\Integers\Signed\Int8)[4]
                  protected readonly int 'value' => int 33
              'account_number' =>
                object(Nejcc\PhpDatatypes\Scalar\Integers\Unsigned\UInt32)[5]
                  protected readonly int 'value' => int 343233
              'account_balance' =>
                object(Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float32)[6]
                  protected readonly float 'value' => float 1234.56
              'investment_amount' =>
                object(Nejcc\PhpDatatypes\Scalar\FloatingPoints\Float64)[7]
                  protected readonly float 'value' => float 78910.12345
              'grade' =>
                object(Nejcc\PhpDatatypes\Scalar\Char)[8]
                  private string 'value' => string 'A' (length=1)
              'age' =>
                object(Nejcc\PhpDatatypes\Scalar\Byte)[9]
                  private int 'value' => int 25
              'names' =>
                object(Nejcc\PhpDatatypes\Composite\Arrays\StringArray)[10]
                  private array 'value' =>
                    array (size=3)
                      0 => string 'John' (length=4)
                      1 => string 'Jane' (length=4)
                      2 => string 'Doe' (length=3)
              'scores' =>
                object(Nejcc\PhpDatatypes\Composite\Arrays\IntArray)[11]
                  private array 'value' =>
                    array (size=3)
                      0 => int 100
                      1 => int 95
                      2 => int 87
              'weights' =>
                object(Nejcc\PhpDatatypes\Composite\Arrays\FloatArray)[12]
                  private array 'value' =>
                    array (size=3)
                      0 => float 60.5
                      1 => float 72.3
                      2 => float 88.9
              'data' =>
                object(Nejcc\PhpDatatypes\Composite\Arrays\ByteSlice)[13]
                  private array 'value' =>
                    array (size=3)
                      0 => int 255
                      1 => int 128
                      2 => int 0
         */
        return [
            'years'             => $this->years,
            'account_number'    => $this->account_number,
            'account_balance'   => $this->account_balance,
            'investment_amount' => $this->investment_amount,
            'grade'             => $this->grade,
            'age'               => $this->age,
            'names'             => $this->names,
            'scores'            => $this->scores,
            'weights'           => $this->weights,
            'data'              => $this->data,
            'listData'          => $this->listData,
            'dictionary'        => $this->dictionary,
            'struct'            => $this->struct,
            'struct_all'            => $this->struct->getFields(),
        ];
    }
}

// Instantiate the class and invoke the examples
$example = new TestExamples();
var_dump($example->getExamples());
