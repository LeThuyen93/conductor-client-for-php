<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/30/18
 * Time: 10:19 AM
 */
namespace conductor\common\metadata\tasks;

use conductor\common\metadata\workflows\WorkflowTask;

class ConductorTask
{
    public $taskType;
    public $status;
    public $inputData;
    public $referenceTaskName;
    public $retryCount;
    public $seq;
    public $correlationId;
    public $pollCount;
    public $taskDefName;
    public $scheduledTime;
    public $startTime;
    public $endTime;
    public $updateTime;
    public $startDelayInSeconds;
    public $retriedTaskId;
    public $retried;
    public $callbackFromWorker = true;
    public $responseTimeoutSeconds;
    public $workflowInstanceId;
    public $taskId;
    public $reasonForIncompletion;
    public $callbackAfterSeconds;
    public $workerId;
    public $outputData;
    /**
     * @var WorkflowTask
     */
    public $workflowTask;
    public $domain;
    public $queueWaitTime;
}

class ConductorTaskStatus
{
    const
        IN_PROGRESS = 'IN_PROGRESS',
        FAILED = 'FAILED',
        COMPLETED = 'COMPLETED',
        SCHEDULED = 'SCHEDULED',
        CANCELED = 'CANCELED',
        COMPLETED_WITH_ERRORS = 'COMPLETED_WITH_ERRORS',
        TIMED_OUT = 'TIMED_OUT',
        READY_FOR_RERUN = 'READY_FOR_RERUN',
        SKIPPED = 'SKIPPED'
    ;
}