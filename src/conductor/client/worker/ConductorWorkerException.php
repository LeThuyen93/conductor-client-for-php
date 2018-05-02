<?php
/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 4/16/18
 * Time: 2:06 PM
 */

namespace conductor\client\worker;


use Exception;
use RuntimeException;

class ConductorWorkerException extends RuntimeException
{
    private $message;

    public function __construct(string $message, int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = $message;
    }

    public function getErrorMessage() : string
    {
        return $this->message;
    }
}