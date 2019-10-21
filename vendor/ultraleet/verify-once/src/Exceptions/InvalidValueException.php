<?php

namespace Ultraleet\VerifyOnce\Exceptions;

use Throwable;
use InvalidArgumentException;

class InvalidValueException extends InvalidArgumentException
{
    public function __construct($field, $message = "", $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = "Field '%s' is not of correct type.";
        }
        if (false !== strstr($message, '%s')) {
            sprintf($message, $field);
        }
        parent::__construct($message, $code, $previous);
    }
}
