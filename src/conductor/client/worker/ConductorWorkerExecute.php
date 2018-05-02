<?php

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 4/10/18
 * Time: 12:13 AM
 */
namespace conductor\client\worker;

use conductor\common\metadata\tasks\ConductorTask;
use Exception;
use Thread;

class ConductorWorkerExecute extends Thread
{
    /**
     * @var ConductorTask
     */
    private $task;

    /**
     * @var ConductorWorker
     */
    private $conductorWorker;

    public function __construct(ConductorWorker $conductorWorker, ConductorTask $task)
    {
        $this->conductorWorker = $conductorWorker;
        $this->task = $task;
    }

    public function run()
    {
        $this->updateWithRetry(3);
    }

    /**
     * @param int $retryCount
     */
    private function updateWithRetry(int $retryCount)
    {
        if ($retryCount >= 0) {
            $worker = $this->conductorWorker;
            try {
                $worker->taskClient->updateTask($worker->execute($this->task));
            } catch (Exception $e) {
                try {
                    usleep($worker->sleepWhenRetry * 1000);
                    $this->updateWithRetry(--$retryCount);
                } catch (Exception $e1) {
                    $this->kill();
                }
            }
        }
    }
}