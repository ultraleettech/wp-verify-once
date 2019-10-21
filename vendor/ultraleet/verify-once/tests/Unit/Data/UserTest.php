<?php

namespace Tests\Unit\Data;

use TypeError;
use Tests\TestCase;
use BadMethodCallException;
use Tests\DefaultDataTrait;
use Ultraleet\VerifyOnce\Data\User;
use Ultraleet\VerifyOnce\Types\UserStatus;

class UserTest extends TestCase
{
    use DefaultDataTrait;

    public function testValidData()
    {
        $info = new User($this->defaultUserData);
        $this->assertInstanceOf(UserStatus::class, $info->status);
        $this->assertIsArray($info->scopes);
    }

    public function testNullStatusIsInvalid()
    {
        $this->expectException(TypeError::class);
        $info = new User([
            'status' => null,
        ]);
    }

    public function testInvalidStatus()
    {
        $this->expectException(BadMethodCallException::class);
        $info = new User([
            'status' => 'invalid',
        ]);
    }

    public function testInvalidScopesType()
    {
        $this->expectException(TypeError::class);
        $info = new User([
            'status' => 'ACTIVE',
            'scopes' => '',
        ]);
    }
}
