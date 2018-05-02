<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 3/24/18
 * Time: 11:42 PM
 */
namespace conductor\client\worker;

use conductor\client\http\TaskClient;
use conductor\common\metadata\tasks\ConductorTask;
use conductor\common\metadata\tasks\TaskResult;
use Exception;
use Pool;
use Threaded;

abstract class ConductorWorker extends Threaded
{
    abstract function getTaskDefName() : string;

    abstract function getPollCount() : int;

    abstract function execute(ConductorTask $task) : TaskResult;

    /**
     * @var TaskClient
     */
    public $taskClient;
    /**
     * @var int
     */
    public $threadCount;
    /**
     * @var int
     */
    public $sleepWhenRetry;

    /**
     * Poll for task
     */
    public function run()
    {
        while (1) {
            try {
                $taskType = $this->getTaskDefName();
                $workerId = gethostname();
                $tasks = $this->taskClient->poll($taskType, $workerId, null, $this->getPollCount(), 1000);
                if (count($tasks)) {
                    $pool = new Pool($this->threadCount);
                    foreach ($tasks as $task) {
                        $pool->submit(new ConductorWorkerExecute($this, $task));
                    }
                    while ($pool->collect(function(Collectable $work){
                        return $work->isGarbage();
                    })) {
                        continue;
                    }
                    $pool->shutdown();
                }
                usleep(500000);
            } catch (Exception $e) {
                throw new ConductorWorkerException($e->getMessage());
            }
        }
    }
}