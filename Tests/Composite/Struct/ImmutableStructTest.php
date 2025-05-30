<?php

declare(strict_types=1);

namespace Tests\Composite\Struct;

use Nejcc\PhpDatatypes\Composite\Struct\ImmutableStruct;
use Nejcc\PhpDatatypes\Composite\Struct\Rules\MinLengthRule;
use Nejcc\PhpDatatypes\Composite\Struct\Rules\RangeRule;
use Nejcc\PhpDatatypes\Composite\Struct\Rules\PatternRule;
use Nejcc\PhpDatatypes\Composite\Struct\Rules\EmailRule;
use Nejcc\PhpDatatypes\Composite\Struct\Rules\CustomRule;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use Nejcc\PhpDatatypes\Exceptions\ImmutableException;
use Nejcc\PhpDatatypes\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;
use Nejcc\PhpDatatypes\Composite\Struct\Rules\UrlRule;
use Nejcc\PhpDatatypes\Composite\Struct\Rules\SlugRule;
use Nejcc\PhpDatatypes\Composite\Struct\Rules\CompositeRule;
use Nejcc\PhpDatatypes\Composite\Struct\Rules\PasswordRule;

class ImmutableStructTest extends TestCase
{
    public function testBasicStructCreation(): void
    {
        $struct = new ImmutableStruct([
            'name' => ['type' => 'string'],
            'age' => ['type' => 'int']
        ]);

        $this->assertNull($struct->get('name'));
        $this->assertNull($struct->get('age'));
    }

    public function testStructWithInitialValues(): void
    {
        $struct = new ImmutableStruct(
            [
                'name' => ['type' => 'string'],
                'age' => ['type' => 'int']
            ],
            [
                'name' => 'John',
                'age' => 30
            ]
        );

        $this->assertEquals('John', $struct->get('name'));
        $this->assertEquals(30, $struct->get('age'));
    }

    public function testRequiredFields(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Required field 'name' has no value");

        new ImmutableStruct(
            [
                'name' => ['type' => 'string', 'required' => true],
                'age' => ['type' => 'int']
            ]
        );
    }

    public function testDefaultValues(): void
    {
        $struct = new ImmutableStruct([
            'name' => ['type' => 'string', 'default' => 'Unknown'],
            'age' => ['type' => 'int', 'default' => 0]
        ]);

        $this->assertEquals('Unknown', $struct->get('name'));
        $this->assertEquals(0, $struct->get('age'));
    }

    public function testInvalidFieldAccess(): void
    {
        $struct = new ImmutableStruct([
            'name' => ['type' => 'string']
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Field 'age' does not exist in the struct");

        $struct->get('age');
    }

    public function testImmutableModification(): void
    {
        $struct = new ImmutableStruct([
            'name' => ['type' => 'string']
        ]);

        $this->expectException(ImmutableException::class);
        $this->expectExceptionMessage("Cannot modify a frozen struct");

        $struct->set('name', 'John');
    }

    public function testWithMethod(): void
    {
        $struct = new ImmutableStruct([
            'name' => ['type' => 'string'],
            'age' => ['type' => 'int']
        ]);

        $newStruct = $struct->with(['name' => 'John', 'age' => 30]);

        $this->assertNull($struct->get('name'));
        $this->assertNull($struct->get('age'));
        $this->assertEquals('John', $newStruct->get('name'));
        $this->assertEquals(30, $newStruct->get('age'));
    }

    public function testWithFieldMethod(): void
    {
        $struct = new ImmutableStruct([
            'name' => ['type' => 'string'],
            'age' => ['type' => 'int']
        ]);

        $newStruct = $struct->withField('name', 'John');

        $this->assertNull($struct->get('name'));
        $this->assertEquals('John', $newStruct->get('name'));
    }

    public function testNestedStructs(): void
    {
        $address = new ImmutableStruct([
            'street' => ['type' => 'string'],
            'city' => ['type' => 'string']
        ], [
            'street' => '123 Main St',
            'city' => 'Boston'
        ]);

        $person = new ImmutableStruct([
            'name' => ['type' => 'string'],
            'address' => ['type' => ImmutableStruct::class]
        ], [
            'name' => 'John',
            'address' => $address
        ]);

        $this->assertEquals('John', $person->get('name'));
        $this->assertInstanceOf(ImmutableStruct::class, $person->get('address'));
        $this->assertEquals('123 Main St', $person->get('address')->get('street'));
        $this->assertEquals('Boston', $person->get('address')->get('city'));
    }

    public function testNullableFields(): void
    {
        $struct = new ImmutableStruct([
            'name' => ['type' => '?string'],
            'age' => ['type' => '?int']
        ]);

        $this->assertNull($struct->get('name'));
        $this->assertNull($struct->get('age'));

        $newStruct = $struct->with([
            'name' => null,
            'age' => null
        ]);

        $this->assertNull($newStruct->get('name'));
        $this->assertNull($newStruct->get('age'));
    }

    public function testToArray(): void
    {
        $address = new ImmutableStruct([
            'street' => ['type' => 'string'],
            'city' => ['type' => 'string']
        ], [
            'street' => '123 Main St',
            'city' => 'Boston'
        ]);

        $person = new ImmutableStruct([
            'name' => ['type' => 'string'],
            'age' => ['type' => 'int'],
            'address' => ['type' => ImmutableStruct::class]
        ], [
            'name' => 'John',
            'age' => 30,
            'address' => $address
        ]);

        $expected = [
            'name' => 'John',
            'age' => 30,
            'address' => [
                'street' => '123 Main St',
                'city' => 'Boston'
            ]
        ];

        $this->assertEquals($expected, $person->toArray());
    }

    public function testToString(): void
    {
        $struct = new ImmutableStruct([
            'name' => ['type' => 'string'],
            'age' => ['type' => 'int']
        ], [
            'name' => 'John',
            'age' => 30
        ]);

        $expected = json_encode([
            'name' => 'John',
            'age' => 30
        ]);

        $this->assertEquals($expected, (string)$struct);
    }

    public function testGetFieldType(): void
    {
        $struct = new ImmutableStruct([
            'name' => ['type' => 'string'],
            'age' => ['type' => 'int']
        ]);

        $this->assertEquals('string', $struct->getFieldType('name'));
        $this->assertEquals('int', $struct->getFieldType('age'));

        $this->expectException(InvalidArgumentException::class);
        $struct->getFieldType('invalid');
    }

    public function testIsFieldRequired(): void
    {
        $struct = new ImmutableStruct([
            'name' => ['type' => 'string', 'required' => true, 'default' => 'John'],
            'age' => ['type' => 'int', 'required' => false]
        ]);

        $this->assertTrue($struct->isFieldRequired('name'));
        $this->assertFalse($struct->isFieldRequired('age'));

        $this->expectException(InvalidArgumentException::class);
        $struct->isFieldRequired('invalid');
    }

    public function testGetFieldRules(): void
    {
        $struct = new ImmutableStruct([
            'name' => [
                'type' => 'string',
                'rules' => [
                    new MinLengthRule(3)
                ]
            ]
        ]);

        $rules = $struct->getFieldRules('name');
        $this->assertCount(1, $rules);
        $this->assertInstanceOf(MinLengthRule::class, $rules[0]);

        $this->expectException(InvalidArgumentException::class);
        $struct->getFieldRules('invalid');
    }

    public function testMinLengthRule(): void
    {
        $struct = new ImmutableStruct([
            'name' => [
                'type' => 'string',
                'rules' => [
                    new MinLengthRule(3)
                ]
            ]
        ]);

        // Valid value
        $newStruct = $struct->with(['name' => 'John']);
        $this->assertEquals('John', $newStruct->get('name'));

        // Invalid value
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'name' must be at least 3 characters long");
        $struct->with(['name' => 'Jo']);
    }

    public function testRangeRule(): void
    {
        $struct = new ImmutableStruct([
            'age' => [
                'type' => 'int',
                'rules' => [
                    new RangeRule(0, 120)
                ]
            ]
        ]);

        // Valid value
        $newStruct = $struct->with(['age' => 30]);
        $this->assertEquals(30, $newStruct->get('age'));

        // Invalid value - too low
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'age' must be between 0 and 120");
        $struct->with(['age' => -1]);

        // Invalid value - too high
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'age' must be between 0 and 120");
        $struct->with(['age' => 121]);
    }

    public function testMultipleRules(): void
    {
        $struct = new ImmutableStruct([
            'name' => [
                'type' => 'string',
                'rules' => [
                    new MinLengthRule(3),
                    new MinLengthRule(5)
                ]
            ]
        ]);

        // Valid value
        $newStruct = $struct->with(['name' => 'Johnny']);
        $this->assertEquals('Johnny', $newStruct->get('name'));

        // Invalid value - fails first rule
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'name' must be at least 3 characters long");
        $struct->with(['name' => 'Jo']);

        // Invalid value - fails second rule
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'name' must be at least 5 characters long");
        $struct->with(['name' => 'John']);
    }

    public function testPatternRule(): void
    {
        $struct = new ImmutableStruct([
            'username' => [
                'type' => 'string',
                'rules' => [
                    new PatternRule('/^[a-zA-Z0-9_]{3,20}$/')
                ]
            ]
        ]);

        // Valid value
        $newStruct = $struct->with(['username' => 'john_doe123']);
        $this->assertEquals('john_doe123', $newStruct->get('username'));

        // Invalid value - contains invalid characters
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'username' does not match the required pattern");
        $struct->with(['username' => 'john@doe']);
    }

    public function testEmailRule(): void
    {
        $struct = new ImmutableStruct([
            'email' => [
                'type' => 'string',
                'rules' => [
                    new EmailRule()
                ]
            ]
        ]);

        // Valid value
        $newStruct = $struct->with(['email' => 'john.doe@example.com']);
        $this->assertEquals('john.doe@example.com', $newStruct->get('email'));

        // Invalid value - not an email
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'email' must be a valid email address");
        $struct->with(['email' => 'not-an-email']);
    }

    public function testCustomRule(): void
    {
        $struct = new ImmutableStruct([
            'password' => [
                'type' => 'string',
                'rules' => [
                    new CustomRule(
                        fn($value) => strlen($value) >= 8 && preg_match('/[A-Z]/', $value) && preg_match('/[a-z]/', $value) && preg_match('/[0-9]/', $value),
                        'must be at least 8 characters long and contain uppercase, lowercase, and numbers'
                    )
                ]
            ]
        ]);

        // Valid value
        $newStruct = $struct->with(['password' => 'Password123']);
        $this->assertEquals('Password123', $newStruct->get('password'));

        // Invalid value - too short
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'password': must be at least 8 characters long and contain uppercase, lowercase, and numbers");
        $struct->with(['password' => 'pass']);

        // Invalid value - missing uppercase
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'password': must be at least 8 characters long and contain uppercase, lowercase, and numbers");
        $struct->with(['password' => 'password123']);

        // Invalid value - missing numbers
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'password': must be at least 8 characters long and contain uppercase, lowercase, and numbers");
        $struct->with(['password' => 'Password']);
    }

    public function testCombinedRules(): void
    {
        $struct = new ImmutableStruct([
            'username' => [
                'type' => 'string',
                'rules' => [
                    new MinLengthRule(3),
                    new PatternRule('/^[a-zA-Z0-9_]+$/')
                ]
            ],
            'email' => [
                'type' => 'string',
                'rules' => [
                    new EmailRule(),
                    new CustomRule(
                        fn($value) => str_ends_with($value, '.com'),
                        'must be a .com email address'
                    )
                ]
            ]
        ]);

        // Valid values
        $newStruct = $struct->with([
            'username' => 'john_doe',
            'email' => 'john.doe@example.com'
        ]);
        $this->assertEquals('john_doe', $newStruct->get('username'));
        $this->assertEquals('john.doe@example.com', $newStruct->get('email'));

        // Invalid username - too short
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'username' must be at least 3 characters long");
        $struct->with(['username' => 'jo']);

        // Invalid username - invalid characters
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'username' does not match the required pattern");
        $struct->with(['username' => 'john@doe']);

        // Invalid email - not .com
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'email': must be a .com email address");
        $struct->with(['email' => 'john.doe@example.org']);
    }

    public function testUrlRule(): void
    {
        $struct = new ImmutableStruct([
            'website' => [
                'type' => 'string',
                'rules' => [
                    new UrlRule()
                ]
            ],
            'secureWebsite' => [
                'type' => 'string',
                'rules' => [
                    new UrlRule(true)
                ]
            ]
        ]);

        // Valid URLs
        $newStruct = $struct->with([
            'website' => 'http://example.com',
            'secureWebsite' => 'https://example.com'
        ]);
        $this->assertEquals('http://example.com', $newStruct->get('website'));
        $this->assertEquals('https://example.com', $newStruct->get('secureWebsite'));

        // Invalid URL
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'website' must be a valid URL");
        $struct->with(['website' => 'not-a-url']);

        // Non-HTTPS URL for secure field
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'secureWebsite' must be a secure HTTPS URL");
        $struct->with(['secureWebsite' => 'http://example.com']);
    }

    public function testSlugRule(): void
    {
        $struct = new ImmutableStruct([
            'slug' => [
                'type' => 'string',
                'rules' => [
                    new SlugRule(3, 50, true)
                ]
            ],
            'strictSlug' => [
                'type' => 'string',
                'rules' => [
                    new SlugRule(3, 50, false)
                ]
            ]
        ]);

        // Valid slugs
        $newStruct = $struct->with([
            'slug' => 'my-awesome-post_123',
            'strictSlug' => 'my-awesome-post'
        ]);
        $this->assertEquals('my-awesome-post_123', $newStruct->get('slug'));
        $this->assertEquals('my-awesome-post', $newStruct->get('strictSlug'));

        // Too short
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'slug' must be at least 3 characters long");
        $struct->with(['slug' => 'ab']);

        // Too long
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'slug' must not exceed 50 characters");
        $struct->with(['slug' => str_repeat('a', 51)]);

        // Invalid characters
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'slug' must contain only lowercase letters, numbers, hyphens, and underscores");
        $struct->with(['slug' => 'My-Post']);

        // Consecutive hyphens
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'slug' must not contain consecutive hyphens or underscores");
        $struct->with(['slug' => 'my--post']);

        // Underscores not allowed in strict mode
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'strictSlug' must contain only lowercase letters, numbers, and hyphens");
        $struct->with(['strictSlug' => 'my_post']);
    }

    public function testPasswordRule(): void
    {
        $struct = new ImmutableStruct([
            'password' => [
                'type' => 'string',
                'rules' => [
                    new PasswordRule(
                        minLength: 8,
                        requireUppercase: true,
                        requireLowercase: true,
                        requireNumbers: true,
                        requireSpecialChars: true,
                        maxLength: 100
                    )
                ]
            ],
            'simplePassword' => [
                'type' => 'string',
                'rules' => [
                    new PasswordRule(
                        minLength: 6,
                        requireUppercase: false,
                        requireLowercase: true,
                        requireNumbers: true,
                        requireSpecialChars: false
                    )
                ]
            ]
        ]);

        // Valid passwords
        $newStruct = $struct->with([
            'password' => 'Password123!',
            'simplePassword' => 'pass123'
        ]);
        $this->assertEquals('Password123!', $newStruct->get('password'));
        $this->assertEquals('pass123', $newStruct->get('simplePassword'));

        // Too short
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'password' must be at least 8 characters long");
        $struct->with(['password' => 'Pass1!']);

        // Too long
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'password' must not exceed 100 characters");
        $struct->with(['password' => str_repeat('a', 101)]);

        // Missing uppercase
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'password' must contain at least one uppercase letter");
        $struct->with(['password' => 'password123!']);

        // Missing lowercase
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'password' must contain at least one lowercase letter");
        $struct->with(['password' => 'PASSWORD123!']);

        // Missing numbers
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'password' must contain at least one number");
        $struct->with(['password' => 'Password!']);

        // Missing special characters
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'password' must contain at least one special character");
        $struct->with(['password' => 'Password123']);

        // Simple password - valid
        $newStruct = $struct->with(['simplePassword' => 'pass123']);
        $this->assertEquals('pass123', $newStruct->get('simplePassword'));

        // Simple password - invalid (missing numbers)
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'simplePassword' must contain at least one number");
        $struct->with(['simplePassword' => 'password']);
    }

    public function testCompositeRule(): void
    {
        $struct = new ImmutableStruct([
            'username' => [
                'type' => 'string',
                'rules' => [
                    CompositeRule::fromArray([
                        new MinLengthRule(3),
                        new PatternRule('/^[a-zA-Z0-9_]+$/')
                    ])
                ]
            ],
            'password' => [
                'type' => 'string',
                'rules' => [
                    new PasswordRule(
                        minLength: 8,
                        requireUppercase: true,
                        requireLowercase: true,
                        requireNumbers: true,
                        requireSpecialChars: true
                    )
                ]
            ]
        ]);

        // Valid values
        $newStruct = $struct->with([
            'username' => 'john_doe',
            'password' => 'Password123!'
        ]);
        $this->assertEquals('john_doe', $newStruct->get('username'));
        $this->assertEquals('Password123!', $newStruct->get('password'));

        // Invalid username - too short
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'username' must be at least 3 characters long");
        $struct->with(['username' => 'jo']);

        // Invalid username - invalid characters
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'username' does not match the required pattern");
        $struct->with(['username' => 'john@doe']);

        // Invalid password - missing special character
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field 'password' must contain at least one special character");
        $struct->with(['password' => 'Password123']);
    }
} 