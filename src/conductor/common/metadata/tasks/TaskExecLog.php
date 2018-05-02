<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/30/18
 * Time: 10:19 AM
 */
namespace conductor\common\metadata\tasks;

class TaskExecLog
{
    public $log;
    public $taskId;
    public $createdTime;

    public function __construct(string $log)
    {
        $this->log = $log;
        $this->createdTime = time();
    }
}