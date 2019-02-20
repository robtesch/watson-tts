<?php

namespace Robtesch\Watsontts\Exceptions;

use Exception;

/**
 * Class FileSystemException
 */
class FileSystemException extends Exception
{

    /**
     * ValidationException constructor.
     * @param                $message
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct($message, $code = 422, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}