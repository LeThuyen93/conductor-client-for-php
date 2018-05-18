<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/30/18
 * Time: 10:09 AM
 */
namespace conductor\client\task;

use conductor\client\http\TaskClient;
use conductor\client\worker\AutoLoader;
use conductor\client\worker\ConductorWorker;
use Pool;

class WorkflowTaskCoordinator
{
    /**
     * @var TaskClient
     */
    public $client;
    /**
     * @var ConductorWorker[]
     */
    public $workers;
    public $sleepWhenRetry;
    public $updateRetryCount;
    public $workerQueueSize;
    public $workerNamePrefix;
    public static $domain = "domain";
    public static $allWorkers = "all";
    public $threadCount;

    public function __construct(TaskClient $taskClient, int $sleepWhenRetry, int $threadCount, int $updateRetryCount, int $workerQueueSize, array $taskWorkers,
                                string $workerNamePrefix)
    {
        $this->client = $taskClient;
        $this->sleepWhenRetry = $sleepWhenRetry;
        $this->threadCount = $threadCount;
        $this->updateRetryCount = $updateRetryCount;
        $this->workerQueueSize = $workerQueueSize;
        $this->workerNamePrefix = $workerNamePrefix;
        $this->workers = $taskWorkers;
    }

    public function init()
    {
        $pool = new Pool(count($this->workers), AutoLoader::class, [__DIR__ . "/../../../../../../../vendor/autoload.php"]);
        foreach ($this->workers as $worker) {
            $worker->taskClient = $this->client;
            $worker->threadCount = $this->threadCount;
            $worker->sleepWhenRetry = $this->sleepWhenRetry;
            $pool->submit($worker);
        }
        while ($pool->collect(function(Collectable $work){
            return $work->isGarbage();
        })) {
            continue;
        }
        $pool->shutdown();
    }
}