<?php

namespace Ultraleet\VerifyOnce\Types;

use MyCLabs\Enum\Enum;

/**
 * Class VerificationStatus
 *
 * @package ultraleet/verify-once
 *
 * @method static self UNINITIATED()
 * @method static self INITIATED()
 * @method static self PENDING()
 * @method static self VERIFIED()
 * @method static self FAILED()
 * @method static self LOCKED()
 */
class VerificationStatus extends Enum
{
    private const UNINITIATED = 'UNINITIATED';
    private const INITIATED = 'INITIATED';
    private const PENDING = 'PENDING';
    private const VERIFIED = 'VERIFIED';
    private const FAILED = 'FAILED';
    private const LOCKED = 'LOCKED';
}
