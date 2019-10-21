<?php

namespace Tests\Unit\Data;

use TypeError;
use Tests\TestCase;
use Ultraleet\VerifyOnce\Data\InitiateResponse;

class InitiateResponseTest extends TestCase
{
    const URL = 'http://localhost/verify/testId';

    public function testValidData()
    {
        $initiateResponse = new InitiateResponse([
            'transactionId' => 'testId',
            'url' => self::URL,
        ]);
        $this->assertSame('testId', $initiateResponse->transactionId);
    }

    public function testInvalidData()
    {
        $this->expectException(TypeError::class);
        $initiateResponse = new InitiateResponse([
            'transactionId' => null,
            'url' => self::URL,
        ]);
    }
}
