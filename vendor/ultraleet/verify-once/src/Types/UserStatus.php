<?php

namespace Ultraleet\VerifyOnce\Types;

use MyCLabs\Enum\Enum;

/**
 * Class UserStatus
 *
 * @package ultraleet/verify-once
 *
 * @method static self ACTIVE()
 * @method static self BLOCKED()
 */
class UserStatus extends Enum
{
    const ACTIVE = 'ACTIVE';
    const BLOCKED = 'BLOCKED';
}
