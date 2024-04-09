<?php

namespace Exceptions;

use Throwable;
use RuntimeException;

class CreateException extends RuntimeException
{
    public function __construct($message = "La création a échoué.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}