<?php

namespace App\Exceptions;

use Exception;

class InsufficientDataForSeedingException extends Exception
{
    public function __construct($message = "Insufficient data for seeding", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}