<?php
/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 4/16/18
 * Time: 1:48 PM
 */

namespace conductor\client\task;

use Exception;
use RuntimeException;

class WorkflowTaskCoordinatorException extends RuntimeException
{
    private $message;

    public function __construct(string $message, Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->message = $message;
    }

    public function getErrorMessage() : string
    {
        return $this->message;
    }
}