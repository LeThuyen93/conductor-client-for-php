<?php
/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/31/18
 * Time: 12:50 AM
 */

namespace conductor\client\task;

require_once __DIR__ . '/../../common/metadata/tasks/ConductorTask.php';
require_once __DIR__ . '/../worker/ConductorWorkerExecute.php';
require_once __DIR__ . '/../../common/metadata/tasks/TaskResult.php';
require_once __DIR__ . '/../../common/metadata/tasks/TaskExecLog.php';

use conductor\client\http\TaskClient;
use conductor\client\worker\ConductorWorker;

class WorkflowTaskCoordinatorBuilder
{
    /**
     * @var string
     */
    private $workerNamePrefix = 'workflow-worker-';

    /**
     * @var int
     */
    private $sleepWhenRetry = 500;

    /**
     * @var int
     */
    private $threadCount = 1;

    /**
     * @var int
     */
    private $updateRetryCount = 3;

    /**
     * @var int
     */
    private $workerQueueSize = 1;

    /**
     * @var ConductorWorker[]
     */
    private $taskWorkers;

    /**
     * @var TaskClient
     */
    private $client;

    /**
     * @param string $workerNamePrefix
     * @return WorkflowTaskCoordinatorBuilder
     */
    public function withWorkerNamePrefix(string $workerNamePrefix) : WorkflowTaskCoordinatorBuilder
    {
        $this->workerNamePrefix = $workerNamePrefix;
        return $this;
    }

    /**
     * @param int $sleepWhenRetry
     * @return WorkflowTaskCoordinatorBuilder
     */
    public function withSleepWhenRetry(int $sleepWhenRetry) : WorkflowTaskCoordinatorBuilder
    {
        $this->sleepWhenRetry = $sleepWhenRetry;
        return $this;
    }


    public function withThreadCount(int $threadCount) : WorkflowTaskCoordinatorBuilder
    {
        $this->threadCount = $threadCount;
        return $this;
    }

    /**
     * @param int $updateRetryCount
     * @return WorkflowTaskCoordinatorBuilder
     */
    public function withUpdateRetryCount(int $updateRetryCount) : WorkflowTaskCoordinatorBuilder
    {
        $this->updateRetryCount = $updateRetryCount;
        return $this;
    }

    /**
     * @param int $workerQueueSize
     * @return WorkflowTaskCoordinatorBuilder
     */
    public function withWorkerQueueSize(int $workerQueueSize) : WorkflowTaskCoordinatorBuilder
    {
        $this->workerQueueSize = $workerQueueSize;
        return $this;
    }

    /**
     * @param TaskClient $client
     * @return WorkflowTaskCoordinatorBuilder
     */
    public function withTaskClient(TaskClient $client) : WorkflowTaskCoordinatorBuilder
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @param ConductorWorker[] $taskWorkers
     * @return WorkflowTaskCoordinatorBuilder
     */
    public function withWorkers(array $taskWorkers) : WorkflowTaskCoordinatorBuilder
    {
        $this->taskWorkers = $taskWorkers;
        return $this;
    }

    /**
     * @return WorkflowTaskCoordinator
     */
    public function build() : WorkflowTaskCoordinator
    {
        if ($this->taskWorkers == null) {
            throw new WorkflowTaskCoordinatorException(
                "No task workers are specified.  use withWorkers() to add one mor more task workers");
        }

        if ($this->client == null) {
            throw new WorkflowTaskCoordinatorException("No TaskClient provided.  use withTaskClient() to provide one");
        }
        return new WorkflowTaskCoordinator($this->client, $this->sleepWhenRetry, $this->threadCount, $this->updateRetryCount,
            $this->workerQueueSize, $this->taskWorkers, $this->workerNamePrefix);
    }
}