<?php
namespace MVF\Exception;

use Throwable;

class GitHubUserNotFound extends \Exception
{
    const MESSAGE = "Can't find GitHub user with username '%s'";

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $message);
        parent::__construct($message, $code, $previous);
    }
}