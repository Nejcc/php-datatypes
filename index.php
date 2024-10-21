<?php

declare(strict_types=1);

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

    /**
     * Create a new TestExamples instance.
     * This constructor initializes all data fields by calling setup methods.
     * Each field represents different data types for practical examples.
     *
     * @return void
     */
    public function __construct()
    {
        $this->initScalarTypes();
        $this->initCompositeTypes();
        $this->initStruct();
    }

    /**
     * Initialize scalar data types.
     * Scalar types represent individual values like numbers, bytes, and characters.
     * They are used to handle simple and atomic values within the system.
     *
     * @return void
     */
    private function initScalarTypes(): void
    {
        /**
         * 8-bit signed integer
         * Represents the number of years, restricted to small values.
         * Useful for handling small numeric ranges.
         */
        $this->years = int8(33);

        /**
         * 32-bit unsigned integer
         * Holds large positive numbers like account numbers.
         * Commonly used in systems where IDs need strict type enforcement.
         */
        $this->account_number = uint32(343233);

        /**
         * 32-bit floating-point number
         * Stores monetary values with less precision.
         * Suitable for balances that don't require high precision.
         */
        $this->account_balance = float32(1234.56);

        /**
         * 64-bit floating-point number
         * High-precision number used for large financial figures like investments.
         * Ensures accurate representation of complex decimals.
         */
        $this->investment_amount = float64(78910.12345);

        /**
         * Single character type
         * Holds a grade or other single character values.
         * Useful in cases where just one symbol needs storage.
         */
        $this->grade = char('A');

        /**
         * Byte (unsigned 8-bit integer)
         * Represents an age or other small number in a compact form.
         * Often used in systems with limited memory or for byte operations.
         */
        $this->age = byte(25);
    }

    /**
     * Initialize composite data types (arrays, lists, dictionaries).
     * Composite types represent collections of multiple elements.
     * They are used to store structured or related data, like names or scores.
     *
     * @return void
     */
    private function initCompositeTypes(): void
    {
        /**
         * Array of strings
         * Stores multiple names, useful for handling collections of textual data.
         * Commonly used to represent names in contact lists or similar collections.
         */
        $this->names = stringArray(['John', 'Jane', 'Doe']);

        /**
         * Array of integers
         * Holds multiple scores, useful for exam or performance evaluations.
         * Ensures all elements in the array are integers.
         */
        $this->scores = intArray([100, 95, 87]);

        /**
         * Array of floats
         * Contains floating-point values like weights.
         * Useful in systems that require collections of decimal numbers.
         */
        $this->weights = floatArray([60.5, 72.3, 88.9]);

        /**
         * Byte array
         * Holds a sequence of raw bytes.
         * Often used for storing binary data, such as file contents or encoded data.
         */
        $this->data = byteSlice([255, 128, 0]);

        /**
         * List of strings
         * Stores elements like fruit names, representing simple ordered collections.
         * Useful for maintaining ordered lists in a system.
         */
        $this->listData = listData(['apple', 'banana', 'orange']);

        /**
         * Dictionary with key-value pairs
         * Stores user information like name, age, and country.
         * Used when you need to access data by keys rather than indexes.
         */
        $this->dictionary = dictionary([
            'name'    => 'Nejc',
            'age'     => 99,
            'country' => 'Slovenia'
        ]);
    }

    /**
     * Initialize structured data types (Struct).
     * Structs allow for grouping data into named fields with specific types.
     * They are useful for representing records or objects with fixed attributes.
     *
     * @return void
     */
    private function initStruct(): void
    {
        /**
         * Struct definition with named fields
         * Used to group related fields into a single entity (e.g., a user profile).
         * Each field has a specific type, ensuring type-safety across attributes.
         */
        $this->struct = struct([
            'name'    => 'string',
            'age'     => 'int',
            'balance' => 'float'
        ]);

        // Set initial values for struct fields.
        $this->struct->set('name', 'Nejc');
        $this->struct->set('age', 30);
        $this->struct->set('balance', 250.75);
    }

    /**
     * Retrieve all example data as an array.
     * This method returns the initialized scalar, composite, and structured data.
     * Can be used to display or process the data in various parts of the system.
     *
     * @return array
     */
    public function getExamples(): array
    {
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
            'struct_all'        => $this->struct->getFields(), // All fields in the struct
        ];
    }
}

// Instantiate the class and invoke the examples
$example = new TestExamples();

// Display the example data
var_dump($example->getExamples());

