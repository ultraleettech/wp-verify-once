<?php

namespace Tests\Unit\Data;

use TypeError;
use Tests\TestCase;
use Tests\DefaultDataTrait;
use Ultraleet\VerifyOnce\Data\User;
use Ultraleet\VerifyOnce\Data\Transaction;
use Ultraleet\VerifyOnce\Data\CallbackInfo;
use Ultraleet\VerifyOnce\Data\AddressCallbackInfo;
use Ultraleet\VerifyOnce\Data\IdentityCallbackInfo;

class CallbackInfoTest extends TestCase
{
    use DefaultDataTrait;

    public function testValidData()
    {
        $info = new CallbackInfo([
            'transaction' => $this->defaultTransactionData,
            'user' => $this->defaultUserData,
            'identityVerification' => $this->defaultIdentityData,
            'addressVerification' => $this->defaultAddressData,
        ]);
        $this->assertInstanceOf(Transaction::class, $info->transaction);
        $this->assertInstanceOf(User::class, $info->user);
        $this->assertInstanceOf(IdentityCallbackInfo::class, $info->identityVerification);
        $this->assertInstanceOf(AddressCallbackInfo::class, $info->addressVerification);
    }

    public function testValidDataWithAllowedNullValues()
    {
        $info = new CallbackInfo([
            'transaction' => $this->defaultTransactionData,
            'user' => $this->defaultUserData,
            'identityVerification' => null,
            'addressVerification' => null,
        ]);
        $this->assertNull($info->identityVerification);
        $this->assertNull($info->addressVerification);
    }

    public function testTransactionInfoIsRequired()
    {
        $this->expectException(TypeError::class);
        $info = new CallbackInfo([
            'transaction' => null,
            'user' => [
                'status' => 'ACTIVE',
                'scopes' => [],
            ],
            'identityVerification' => null,
            'addressVerification' => null,
        ]);
    }

    public function testUserInfoIsRequired()
    {
        $this->expectException(TypeError::class);
        $info = new CallbackInfo([
            'transaction' => $this->defaultTransactionData,
            'user' => null,
            'identityVerification' => null,
            'addressVerification' => null,
        ]);
    }
}
