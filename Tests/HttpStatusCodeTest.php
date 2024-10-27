<?php

namespace Nejcc\PhpDatatypes\Tests;



use Nejcc\PhpDatatypes\Enums\Http\HttpStatusCode;
use PHPUnit\Framework\TestCase;

class HttpStatusCodeTest extends TestCase
{
    public function testIsInformational()
    {
        $this->assertTrue(HttpStatusCode::CONTINUE->isInformational());
        $this->assertFalse(HttpStatusCode::OK->isInformational());
    }

    public function testIsSuccess()
    {
        $this->assertTrue(HttpStatusCode::OK->isSuccess());
        $this->assertFalse(HttpStatusCode::BAD_REQUEST->isSuccess());
    }

    public function testIsRedirection()
    {
        $this->assertTrue(HttpStatusCode::MOVED_PERMANENTLY->isRedirection());
        $this->assertFalse(HttpStatusCode::NOT_FOUND->isRedirection());
    }

    public function testIsClientError()
    {
        $this->assertTrue(HttpStatusCode::NOT_FOUND->isClientError());
        $this->assertFalse(HttpStatusCode::OK->isClientError());
    }

    public function testIsServerError()
    {
        $this->assertTrue(HttpStatusCode::INTERNAL_SERVER_ERROR->isServerError());
        $this->assertFalse(HttpStatusCode::BAD_REQUEST->isServerError());
    }

    public function testGetMessage()
    {
        $this->assertEquals('OK', HttpStatusCode::OK->getMessage());
        $this->assertEquals('Not Found', HttpStatusCode::NOT_FOUND->getMessage());
        $this->assertEquals('Internal Server Error', HttpStatusCode::INTERNAL_SERVER_ERROR->getMessage());
    }

    public function testGetSuggestion()
    {
        $this->assertEquals(
            'Check the request parameters and try again.',
            HttpStatusCode::BAD_REQUEST->getSuggestion()
        );
        $this->assertEquals(
            'The server is currently down for maintenance. Try again later.',
            HttpStatusCode::SERVICE_UNAVAILABLE->getSuggestion()
        );
        $this->assertEquals(
            'No specific suggestion.',
            HttpStatusCode::OK->getSuggestion()
        );
    }

    public function testBuildResponse()
    {
        $response = HttpStatusCode::OK->buildResponse(
            data: ['message' => 'Success'],
            headers: ['Content-Type' => 'application/json']
        );

        $expectedResponse = [
            'status' => 200,
            'message' => 'OK',
            'data' => ['message' => 'Success'],
            'headers' => ['Content-Type' => 'application/json'],
        ];

        $this->assertEquals($expectedResponse, $response);
    }

    public function testGetSuccessCodes()
    {
        $successCodes = HttpStatusCode::getSuccessCodes();
        $this->assertContains(HttpStatusCode::OK, $successCodes);
        $this->assertNotContains(HttpStatusCode::BAD_REQUEST, $successCodes);
    }

    public function testGetClientErrorCodes()
    {
        $clientErrorCodes = HttpStatusCode::getClientErrorCodes();
        $this->assertContains(HttpStatusCode::NOT_FOUND, $clientErrorCodes);
        $this->assertNotContains(HttpStatusCode::INTERNAL_SERVER_ERROR, $clientErrorCodes);
    }
}
