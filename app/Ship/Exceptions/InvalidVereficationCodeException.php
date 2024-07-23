<?php

namespace App\Ship\Exceptions;

use Exception;

class InvalidVereficationCodeException extends Exception
{
    protected $message = 'exception_messages.invalid_verefication_code';
    protected $code = 418;
}
