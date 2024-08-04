<?php

namespace App\Exceptions;

use Exception;

class BatchException extends Exception
{
    public function __construct($message, $code = null, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
