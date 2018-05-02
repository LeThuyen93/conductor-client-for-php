<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/30/18
 * Time: 10:19 AM
 */
namespace conductor\common\metadata\tasks;

class TaskResult
{
    public $workflowInstanceId;

    public $taskId;

    public $reasonForIncompletion;

    public $callbackAfterSeconds;

    public $workerId;
    /**
     * @var ConductorTaskStatus
     */
    public $status;

    /**
     * @var array
     */
    public $outputData;

    /**
     * @var TaskExecLog[]
     */
    public $logs;


    /**
     * @param string $log
     * @return TaskResult
     */
    public function Log(string $log) : TaskResult
    {
        $this->logs[] = new TaskExecLog($log);
        return $this;
    }

    public function __construct(ConductorTask $task = null)
    {
        if ($task != null) {
            $this->workflowInstanceId = $task->workflowInstanceId;
            $this->taskId = $task->taskId;
            $this->reasonForIncompletion = $task->reasonForIncompletion;
            $this->callbackAfterSeconds = $task->callbackAfterSeconds;
            $this->status = $task->status;
            $this->workerId = $task->workerId;
            $this->outputData = $task->outputData;
        }
    }
}