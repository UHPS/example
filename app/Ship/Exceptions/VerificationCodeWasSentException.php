<?php

namespace App\Ship\Exceptions;

use Exception;

class VerificationCodeWasSentException extends Exception
{
    protected $code = 403;
}
