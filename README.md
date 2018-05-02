# conductor-client-for-php
**Install**

_composer require mobiletech/conductor_

Require PHP 7.2 or later with ZTS

**How to use**

* Start a workflow

    ```php
    $conductorHost = 'localhost';
    $conductorPort = 8080;
    $conductorRootUri = "http://{$conductorHost}:{$conductorPort}/api/";
    $workflowName = 'test-workflow';
    $workflowVersion = 1;
    
    $inputMap = [
        'foo' => 'foo',
        'bar' => 'bar'
    ];
    
    
    $startWorkflowRequest = new StartWorkflowRequest();
    $startWorkflowRequest->withName($workflowName)
        ->withVersion($workflowVersion)
        ->withCorrelationId('1') // Optional, use for tracking workflow by correlationId  
        ->withInput($inputMap);
        
    $workflowClient = new WorkflowClient();
    $workflowClient->rootUri = $conductorRootUri;
    
    $wfId = $workflowClient->startWorkflow($startWorkflowRequest);
    
    echo sprintf("{$wfId} \n");
    ```
* Create  a worker for conductor

    ```PHP
    use conductor\client\worker\ConductorWorker;
    use conductor\common\metadata\tasks\ConductorTask;
    use conductor\common\metadata\tasks\ConductorTaskStatus;
    use conductor\common\metadata\tasks\TaskResult;
    
    class DemoWorker extends ConductorWorker
    {
        /**
         * Name of the worker task
         * @var string
         */
        private $taskDefName;
        
        /**
         * Limit number of tasks returned when poll from Conductor server
         * @var int
         */
        private $pollCount;
    
        public function __construct(string $taskDefName, int $pollCount)
        {
            $this->taskDefName = $taskDefName;
            $this->pollCount = $pollCount;
        }
    
        function getTaskDefName(): string
        {
            return $this->taskDefName;
        }
    
        function getPollCount(): int
        {
            return $this->pollCount;
        }
    
        function execute(ConductorTask $task): TaskResult
        {
            $taskResult = new TaskResult($task);
            $inputData = $task->inputData;
            try{
                $foo = $inputData->foo;
                $bar = $inputData->bar;
                
                $outputData = [
                    'foo' => $foo,
                    'bar' => $bar
                ];
    
                $taskResult->outputData = $outputData;
                $taskResult->status = ConductorTaskStatus::COMPLETED;
                $taskResult->Log('This is log for worker task');
            } catch (Exception $e) {
                $taskResult->status = ConductorTaskStatus::FAILED;
                $taskResult->Log($e->getMessage());
            }
            return $taskResult;
        }
    }  
    ```

* Init conductor workers

    ```PHP
    $conductorHost = 'localhost';
    $conductorPort = 8080;
    $conductorRootUri = "http://{$conductorHost}:{$conductorPort}/api/";
    $threadCount = 2; // Available number of thread to execute tasks
  
    $workerList = [];
    $workerList[] = new DemoWorker("demo_worker", 20);
  
    $taskClient = new TaskClient();
    $taskClient->rootUri = $conductorRootUri;
  
    $builder = new WorkflowTaskCoordinatorBuilder();
    $builder->withThreadCount($threadCount);
    $builder->withTaskClient($taskClient);
    $builder->withWorkers($workerList);
  
    $coordinator = $builder->build();
    $coordinator->init();
    ```
