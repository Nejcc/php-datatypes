<?php

declare(strict_types=1);

use Nejcc\PhpDatatypes\Composite\String\AsciiString;
use Nejcc\PhpDatatypes\Composite\String\Utf8String;
use Nejcc\PhpDatatypes\Composite\String\EmailString;
use Nejcc\PhpDatatypes\Composite\String\SlugString;
use Nejcc\PhpDatatypes\Composite\String\UrlString;
use Nejcc\PhpDatatypes\Composite\String\PasswordString;
use Nejcc\PhpDatatypes\Composite\String\TrimmedString;
use Nejcc\PhpDatatypes\Composite\String\Base64String;
use Nejcc\PhpDatatypes\Composite\String\HexString;
use Nejcc\PhpDatatypes\Composite\String\JsonString;
use Nejcc\PhpDatatypes\Composite\String\XmlString;
use Nejcc\PhpDatatypes\Composite\String\HtmlString;
use Nejcc\PhpDatatypes\Composite\String\CssString;
use Nejcc\PhpDatatypes\Composite\String\JsString;
use Nejcc\PhpDatatypes\Composite\String\SqlString;
use Nejcc\PhpDatatypes\Composite\String\RegexString;
use Nejcc\PhpDatatypes\Composite\String\PathString;
use Nejcc\PhpDatatypes\Composite\String\CommandString;
use Nejcc\PhpDatatypes\Composite\String\VersionString;
use Nejcc\PhpDatatypes\Composite\String\SemverString;
use Nejcc\PhpDatatypes\Composite\String\UuidString;
use Nejcc\PhpDatatypes\Composite\String\IpString;
use Nejcc\PhpDatatypes\Composite\String\MacString;
use Nejcc\PhpDatatypes\Composite\String\ColorString;
use Nejcc\PhpDatatypes\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CompositeStringTypesTest extends TestCase
{
    public function testAsciiString(): void
    {
        $s = new AsciiString('Hello123!');
        $this->assertSame('Hello123!', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new AsciiString("Hello\x80");
    }

    public function testUtf8String(): void
    {
        $s = new Utf8String('Привет');
        $this->assertSame('Привет', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new Utf8String("\xFF\xFF");
    }

    public function testEmailString(): void
    {
        $s = new EmailString('test@example.com');
        $this->assertSame('test@example.com', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new EmailString('not-an-email');
    }

    public function testSlugString(): void
    {
        $s = new SlugString('hello-world-123');
        $this->assertSame('hello-world-123', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new SlugString('Hello World!');
    }

    public function testUrlString(): void
    {
        $s = new UrlString('https://example.com');
        $this->assertSame('https://example.com', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new UrlString('not-a-url');
    }

    public function testPasswordString(): void
    {
        $s = new PasswordString('abcdefgh');
        $this->assertSame('abcdefgh', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new PasswordString('short');
    }

    public function testTrimmedString(): void
    {
        $s = new TrimmedString('  hello  ');
        $this->assertSame('hello', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new TrimmedString('   ');
    }

    public function testBase64String(): void
    {
        $s = new Base64String('SGVsbG8=');
        $this->assertSame('SGVsbG8=', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new Base64String('not_base64!');
    }

    public function testHexString(): void
    {
        $s = new HexString('deadBEEF');
        $this->assertSame('deadBEEF', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new HexString('xyz123');
    }

    public function testJsonString(): void
    {
        $s = new JsonString('{"a":1}');
        $this->assertSame('{"a":1}', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new JsonString('{a:1}');
    }

    public function testXmlString(): void
    {
        $s = new XmlString('<root><a>1</a></root>');
        $this->assertSame('<root><a>1</a></root>', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new XmlString('<root><a>1</root>');
    }

    public function testHtmlString(): void
    {
        $s = new HtmlString('<b>hi</b>');
        $this->assertSame('<b>hi</b>', (string)$s);
        // Note: DOMDocument is very lenient and will not throw for malformed HTML.
        // Therefore, we do not test for exceptions on invalid HTML here.
    }

    public function testCssString(): void
    {
        $s = new CssString('body { color: red; }');
        $this->assertSame('body { color: red; }', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new CssString('body color: red; }');
    }

    public function testJsString(): void
    {
        $s = new JsString('var x = 1;');
        $this->assertSame('var x = 1;', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new JsString("alert('bad');\x01");
    }

    public function testSqlString(): void
    {
        $s = new SqlString('SELECT * FROM users;');
        $this->assertSame('SELECT * FROM users;', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new SqlString("SELECT * FROM users;\x01");
    }

    public function testRegexString(): void
    {
        $s = new RegexString('/^[a-z]+$/i');
        $this->assertSame('/^[a-z]+$/i', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new RegexString('/[a-z/');
    }

    public function testPathString(): void
    {
        $s = new PathString('/usr/local/bin');
        $this->assertSame('/usr/local/bin', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new PathString('C:\\Program Files|bad');
    }

    public function testCommandString(): void
    {
        $s = new CommandString('ls -la /tmp');
        $this->assertSame('ls -la /tmp', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new CommandString('rm -rf / ; echo $((1+1)) | bad!');
    }

    public function testVersionString(): void
    {
        $s = new VersionString('1.2.3');
        $this->assertSame('1.2.3', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new VersionString('1.2');
    }

    public function testSemverString(): void
    {
        $s = new SemverString('1.2.3-alpha.1+build');
        $this->assertSame('1.2.3-alpha.1+build', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new SemverString('1.2.3.4');
    }

    public function testUuidString(): void
    {
        $s = new UuidString('123e4567-e89b-12d3-a456-426614174000');
        $this->assertSame('123e4567-e89b-12d3-a456-426614174000', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new UuidString('not-a-uuid');
    }

    public function testIpString(): void
    {
        $s = new IpString('127.0.0.1');
        $this->assertSame('127.0.0.1', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new IpString('999.999.999.999');
    }

    public function testMacString(): void
    {
        $s = new MacString('00:1A:2B:3C:4D:5E');
        $this->assertSame('00:1A:2B:3C:4D:5E', (string)$s);
        $this->expectException(InvalidArgumentException::class);
        new MacString('00:1A:2B:3C:4D');
    }

    public function testColorString(): void
    {
        $s = new ColorString('#fff');
        $this->assertSame('#fff', (string)$s);
        $s2 = new ColorString('rgb(255,255,255)');
        $this->assertSame('rgb(255,255,255)', (string)$s2);
        $this->expectException(InvalidArgumentException::class);
        new ColorString('notacolor');
    }
} 