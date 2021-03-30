<?php
namespace MVF\Exception;

use Throwable;

class UsernameIsNotSetException extends \Exception
{
    const USERNAME_IS_NOT_SET_ERROR_MESSAGE = "Unable to analyze: please set a username";

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(self::USERNAME_IS_NOT_SET_ERROR_MESSAGE, $code, $previous);
    }
}