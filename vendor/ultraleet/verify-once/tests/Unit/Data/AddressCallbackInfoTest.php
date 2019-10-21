<?php

namespace Tests\Unit\Data;

use TypeError;
use Tests\TestCase;
use BadMethodCallException;
use Tests\DefaultDataTrait;
use Ultraleet\VerifyOnce\Types\CountryCode;
use Ultraleet\VerifyOnce\Types\VerificationStatus;
use Ultraleet\VerifyOnce\Data\AddressCallbackInfo;
use Ultraleet\VerifyOnce\Exceptions\InvalidValueException;

class AddressCallbackInfoTest extends TestCase
{
    use DefaultDataTrait;

    public function testValidData()
    {
        $info = new AddressCallbackInfo($this->defaultAddressData);
        $this->assertInstanceOf(VerificationStatus::class, $info->status);
        $this->assertInstanceOf(CountryCode::class, $info->countryCode);
    }

    public function testNullStatusIsInvalid()
    {
        $this->expectException(TypeError::class);
        $info = new AddressCallbackInfo($this->mergeData([
            'status' => null,
        ], 'Address'));
    }

    public function testInvalidStatus()
    {
        $this->expectException(BadMethodCallException::class);
        $info = new AddressCallbackInfo($this->mergeData([
            'status' => 'invalid',
        ], 'Address'));
    }

    public function testNullCountryCodeIsInvalid()
    {
        $this->expectException(TypeError::class);
        $info = new AddressCallbackInfo($this->mergeData([
            'countryCode' => null,
        ], 'Address'));
    }

    public function testInvalidCountryCode()
    {
        $this->expectException(BadMethodCallException::class);
        $info = new AddressCallbackInfo([
            'status' => 'FAILED',
            'countryCode' => 'invalid',
        ]);
    }
}
