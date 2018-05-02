<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/30/18
 * Time: 10:08 AM
 */
namespace conductor\client\http;

use conductor\common\metadata\tasks\ConductorTask;
use conductor\common\metadata\tasks\TaskResult;

class TaskClient extends ClientBase
{
    /**
     * @param string $taskType
     * @param string $workerId
     * @param string $domain
     * @param int $count
     * @param int $timeoutInMillisecond
     * @return array
     */
    public function poll(string $taskType, string $workerId, $domain, int $count, int $timeoutInMillisecond) : array
    {
        $queryParams = [
            'workerid' => $workerId,
            'domain' => $domain,
            'count' => $count,
            'timeout' => $timeoutInMillisecond
        ];
        $tasks = $this->getForEntity("tasks/poll/batch/{$taskType}", $queryParams);
        $conductorTaskList = [];
        if ($tasks) {
            foreach (json_decode($tasks) as $task) {
                $conductorTaskList[] = $this->convertToConductorTask($task);
            }
        }
        return $conductorTaskList;
    }

    /**
     * @param TaskResult $taskResult
     */
    public function updateTask(TaskResult $taskResult)
    {
        $this->postForEntity("tasks", $taskResult);
    }


    /**
     * @param $taskObject
     * @return ConductorTask
     */
    private function convertToConductorTask($taskObject) : ConductorTask
    {
        $conductorTask = new ConductorTask();
        $conductorTask->taskType = $taskObject->taskType;
        $conductorTask->status = $taskObject->status;
        $conductorTask->inputData = $taskObject->inputData;
        $conductorTask->referenceTaskName = $taskObject->referenceTaskName;
        $conductorTask->retryCount = $taskObject->retryCount;
        $conductorTask->seq = $taskObject->seq;
        $conductorTask->correlationId = $taskObject->correlationId;
        $conductorTask->pollCount = $taskObject->pollCount;
        $conductorTask->taskDefName = $taskObject->taskDefName;
        $conductorTask->scheduledTime = $taskObject->scheduledTime;
        $conductorTask->startTime = $taskObject->startTime;
        $conductorTask->endTime = $taskObject->endTime;
        $conductorTask->updateTime = $taskObject->updateTime;
        $conductorTask->startDelayInSeconds = $taskObject->startDelayInSeconds;
        $conductorTask->retriedTaskId = $taskObject->retriedTaskId;
        $conductorTask->retried = $taskObject->retried;
        $conductorTask->callbackFromWorker = $taskObject->callbackFromWorker;
        $conductorTask->responseTimeoutSeconds = $taskObject->responseTimeoutSeconds;
        $conductorTask->workflowInstanceId = $taskObject->workflowInstanceId;
        $conductorTask->taskId = $taskObject->taskId;
        $conductorTask->reasonForIncompletion = $taskObject->reasonForIncompletion;
        $conductorTask->callbackAfterSeconds = $taskObject->callbackAfterSeconds;
        $conductorTask->workerId = $taskObject->workerId;
        $conductorTask->outputData = $taskObject->outputData;
        return $conductorTask;
    }
}