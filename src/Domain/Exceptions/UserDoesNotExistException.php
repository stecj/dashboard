<?php

namespace App\Domain\Exceptions;

use Exception;

class UserDoesNotExistException extends Exception
{
    public function __construct($message = "El usuario no existe", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}