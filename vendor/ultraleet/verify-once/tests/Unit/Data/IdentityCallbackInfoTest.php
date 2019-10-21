<?php

namespace Tests\Unit\Data;

use TypeError;
use Tests\TestCase;
use BadMethodCallException;
use Tests\DefaultDataTrait;
use Ultraleet\VerifyOnce\Types\IdentityId;
use Ultraleet\VerifyOnce\Types\VerificationStatus;
use Ultraleet\VerifyOnce\Data\IdentityCallbackInfo;
use Ultraleet\VerifyOnce\Types\IdentityRejectReason;

class IdentityCallbackInfoTest extends TestCase
{
    use DefaultDataTrait;

    public function testValidData()
    {
        $info = new IdentityCallbackInfo($this->defaultIdentityData);
        $this->assertInstanceOf(VerificationStatus::class, $info->status);
        $this->assertInstanceOf(IdentityId::class, $info->idType);
        $this->assertInstanceOf(IdentityRejectReason::class, $info->rejectReason);
    }

    public function testValidDataWithAllowedNullValues()
    {
        $info = new IdentityCallbackInfo($this->mergeData([
            'idType' => null,
            'rejectReason' => null,
        ], 'Identity'));
        $this->assertInstanceOf(VerificationStatus::class, $info->status);
        $this->assertNull($info->idType);
        $this->assertNull($info->rejectReason);
    }

    public function testNullStatusIsInvalid()
    {
        $this->expectException(TypeError::class);
        $info = new IdentityCallbackInfo($this->mergeData([
            'status' => null,
        ], 'Identity'));
    }

    public function testInvalidStatus()
    {
        $this->expectException(BadMethodCallException::class);
        $info = new IdentityCallbackInfo($this->mergeData([
            'status' => 'invalid',
        ], 'Identity'));
    }

    public function testInvalidIdType()
    {
        $this->expectException(BadMethodCallException::class);
        $info = new IdentityCallbackInfo($this->mergeData([
            'idType' => 'invalid',
        ], 'Identity'));
    }

    public function testInvalidRejectReason()
    {
        $this->expectException(BadMethodCallException::class);
        $info = new IdentityCallbackInfo($this->mergeData([
            'rejectReason' => 'invalid',
        ], 'Identity'));
    }
}
