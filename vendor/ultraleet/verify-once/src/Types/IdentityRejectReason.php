<?php

namespace Ultraleet\VerifyOnce\Types;

use MyCLabs\Enum\Enum;

class IdentityRejectReason extends Enum
{
    private const ID_INVALID_DATA = 'ID_INVALID_DATA';
    private const ID_UNSUPPORTED = 'ID_UNSUPPORTED';
    private const ID_INSUFFICIENT_QUALITY = 'ID_INSUFFICIENT_QUALITY';
    private const ID_EXPIRED = 'ID_EXPIRED';
    private const ID_UNDERAGE = 'ID_UNDERAGE';
    private const ID_DATA_MISMATCH = 'ID_DATA_MISMATCH';
    private const ID_COMPROMISED = 'ID_COMPROMISED';
    private const SELFIE_MISMATCH = 'SELFIE_MISMATCH';
    private const SELFIE_INSUFFICIENT_QUALITY = 'SELFIE_INSUFFICIENT_QUALITY';
    private const UNKNOWN = 'UNKNOWN';
}
