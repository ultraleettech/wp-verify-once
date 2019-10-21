<?php

namespace Tests\Feature;

use Tests\TestCase;
use Firebase\JWT\JWT;
use Tests\DefaultDataTrait;
use UnexpectedValueException;
use Ultraleet\VerifyOnce\VerifyOnce;
use Firebase\JWT\SignatureInvalidException;

class VerifyTest extends TestCase
{
    use DefaultDataTrait;

    /**
     * @var VerifyOnce
     */
    protected $verifyOnce;

    protected $payload;

    protected function setUp(): void
    {
        parent::setUp();
        $this->verifyOnce = new VerifyOnce([
            'username' => 'test',
            'password' => 'test-secret',
        ]);
        $this->payload = [
            'transaction' => $this->defaultTransactionData,
            'user' => $this->defaultUserData,
            'identityVerification' => null,
            'addressVerification' => null,
        ];
    }

    public function testValidInfo()
    {
        $encoded = JWT::encode($this->payload, 'test-secret');
        $callbackInfo = $this->verifyOnce->verify($encoded);

        $this->assertSame($this->payload, $callbackInfo->toArray());
    }

    public function testInValidPassword()
    {
        $encoded = JWT::encode($this->payload, 'i-dont-know');

        $this->expectException(SignatureInvalidException::class);
        $callbackInfo = $this->verifyOnce->verify($encoded);
    }

    public function testInvalidPayload()
    {
        $this->expectException(UnexpectedValueException::class);
        $callbackInfo = $this->verifyOnce->verify('');
    }
}
