<?php
use conductor\client\http\ClientBase;
use conductor\common\metadata\tasks\TaskDef;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: thuyenlv
 * Date: 4/16/18
 * Time: 3:06 PM
 */
require_once __DIR__ . '/../src/conductor/client/http/ClientBase.php';
require_once __DIR__ . '/../src/conductor/common/metadata/tasks/TaskDef.php';

class ClientBaseTest extends TestCase
{
    /**
     * @var ClientBase
     */
    private $clientBase;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $conductorHost = getenv('CONDUCTOR_HOST');
        $conductorPort = getenv('CONDUCTOR_PORT');
        $conductorRootUri = "http://{$conductorHost}:{$conductorPort}/api/";
        $this->clientBase = new ClientBase();
        $this->clientBase->rootUri = $conductorRootUri;
    }

    public function testGetForEntity()
    {
        $queryParams = [
            'workerid' => 'test',
            'domain' => null,
            'count' => 1,
            'timeout' => 100
        ];

        $result = $this->clientBase->getForEntity("tasks/poll/batch/test", $queryParams);
        $this->assertEquals('[]', $result);
    }

    public function testPostForEntity()
    {
        $taskDef = new TaskDef();
        $taskDef->name = 'testTask';
        $taskDef->inputKeys = ['foo', 'bar'];
        $taskDef->outputKeys = ['result'];

        $this->clientBase->postForEntity('metadata/taskdefs', [$taskDef]);
        $task = $this->clientBase->getForEntity('metadata/taskdefs/testTask');
        $taskObj = json_decode($task);
        $this->assertEquals('testTask', $taskObj->name);
    }

    public function testDelete()
    {
        $result = $this->clientBase->delete('metadata/taskdefs/testTask');
        $this->assertEquals('', $result);
    }
}